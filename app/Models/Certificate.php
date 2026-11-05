<?php

namespace App\Models;

use App\Models\Concerns\DeletesStoredFiles;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/**
 * verification_code is random and used in the QR verification URL, so
 * certificates cannot be found by guessing certificate numbers.
 *
 * The PDF is rendered from resources/views/certificates/certificate.blade.php
 * into the private disk when the certificate is created, again when its
 * printed details change, and on the admin's Regenerate action.
 */
#[Fillable(['player_id', 'event_id', 'title', 'achievement', 'issued_on'])]
class Certificate extends Model
{
    use DeletesStoredFiles;

    /**
     * Columns printed on the certificate; changing one renders a new PDF.
     *
     * @var list<string>
     */
    private const array PRINTED_ATTRIBUTES = ['player_id', 'event_id', 'title', 'achievement', 'issued_on'];

    protected static function booted(): void
    {
        static::creating(function (Certificate $certificate): void {
            $certificate->verification_code ??= Str::random(32);
        });

        static::created(function (Certificate $certificate): void {
            $certificate->certificate_no = sprintf(
                '%s-%s-%05d',
                config('jumpball.certificate_prefix'),
                $certificate->created_at->format('Y'),
                $certificate->getKey(),
            );

            $certificate->saveQuietly();
            $certificate->generatePdf();
        });

        static::updated(function (Certificate $certificate): void {
            if ($certificate->wasChanged(self::PRINTED_ATTRIBUTES)) {
                $certificate->generatePdf();
            }
        });
    }

    /**
     * @return BelongsTo<Player, $this>
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * @return BelongsTo<Event, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Renders the certificate and saves it as certificates/{certificate_no}.pdf
     * on the private disk, replacing any earlier copy.
     */
    public function generatePdf(): void
    {
        $this->load(['player', 'event']);

        $path = 'certificates/'.$this->certificate_no.'.pdf';

        Storage::disk('local')->put($path, $this->renderPdf());

        $this->forceFill(['pdf_path' => $path])->saveQuietly();
    }

    /**
     * The certificate as PDF bytes, drawn from the player and event relations
     * already on the model (generatePdf() loads them first).
     */
    public function renderPdf(): string
    {
        return Pdf::loadView('certificates.certificate', [
            'certificate' => $this,
            'images' => [
                'frame' => self::artwork('certificate-frame.svg'),
                'emblem' => self::artwork('certificate-emblem.svg'),
                'logo' => self::artwork('certificate-logo.png'),
                'watermark' => self::artwork('certificate-watermark.png'),
                'qrCode' => 'data:image/svg+xml;base64,'.base64_encode((string) QrCode::format('svg')->size(300)->margin(0)->errorCorrection('M')->generate($this->verificationUrl())),
            ],
            'verifyAt' => Str::after(route('frontend.certificates.index'), '://'),
        ])
            ->setPaper('a4', 'landscape')
            // Embed only the glyphs used, not the whole font (about 1 MB otherwise).
            ->setOption('isFontSubsettingEnabled', true)
            ->output();
    }

    /**
     * A certificate artwork file from public/assets/images/jfi as a data URI,
     * so dompdf needs no file or network access to draw it.
     */
    private static function artwork(string $file): string
    {
        $mime = str_ends_with($file, '.svg') ? 'image/svg+xml' : 'image/png';

        return 'data:'.$mime.';base64,'.base64_encode((string) file_get_contents(public_path('assets/images/jfi/'.$file)));
    }

    /**
     * The public verification page the QR code points to.
     */
    public function verificationUrl(): string
    {
        return route('frontend.certificates.verify', $this->verification_code);
    }

    /**
     * @return array<string, string>
     */
    protected function storedFiles(): array
    {
        return ['pdf_path' => 'local'];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'issued_on' => 'date',
        ];
    }
}
