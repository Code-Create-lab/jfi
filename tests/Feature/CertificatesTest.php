<?php

namespace Tests\Feature;

use App\Enums\Gender;
use App\Enums\RegistrationStatus;
use App\Models\Certificate;
use App\Models\Event;
use App\Models\Player;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class CertificatesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
    }

    public function test_issuing_a_certificate_saves_its_pdf_on_the_private_disk(): void
    {
        $certificate = $this->issue($this->approvedPlayer());

        $this->assertMatchesRegularExpression('/^JFI-C-\d{4}-\d{5}$/', $certificate->certificate_no);
        $this->assertSame('certificates/'.$certificate->certificate_no.'.pdf', $certificate->pdf_path);
        Storage::disk('local')->assertExists($certificate->pdf_path);
        $this->assertStringStartsWith('%PDF', Storage::disk('local')->get($certificate->pdf_path));
    }

    public function test_long_names_and_titles_still_fit_on_one_page(): void
    {
        $event = Event::query()->create(['title' => 'All India Inter-State Senior National Jumpball Championship', 'start_date' => '2026-12-28', 'end_date' => '2027-01-02', 'city' => 'Thiruvananthapuram', 'state' => 'Kerala']);
        $player = $this->approvedPlayer('Venkata Subramanya Lakshmi Narasimha Raghavendra Rao');

        $certificate = $this->issue($player, [
            'title' => 'Outstanding Contribution to Jumpball Award',
            'achievement' => str_repeat('Best Defensive Player and Captain of the Winning Team ', 2),
            'event_id' => $event->id,
        ]);

        $this->assertSame(1, $this->pageCount($certificate));
    }

    public function test_names_outside_the_core_pdf_fonts_use_the_embedded_font(): void
    {
        $plain = $this->issue($this->approvedPlayer('Aarav Sharma'));
        $accented = $this->issue($this->approvedPlayer('Ānanya Śrīnivāsan'));

        $this->assertStringNotContainsString('DejaVu', Storage::disk('local')->get($plain->pdf_path));
        $this->assertStringContainsString('DejaVuSerif', Storage::disk('local')->get($accented->pdf_path));
    }

    public function test_changing_printed_details_renders_a_new_pdf(): void
    {
        $certificate = $this->issue($this->approvedPlayer());
        Storage::disk('local')->put($certificate->pdf_path, 'old copy');

        $certificate->update(['achievement' => 'Runner-up, Junior Girls']);

        $this->assertStringStartsWith('%PDF', Storage::disk('local')->get($certificate->pdf_path));
    }

    public function test_deleting_a_player_deletes_their_certificate_pdfs(): void
    {
        $player = $this->approvedPlayer();
        $certificate = $this->issue($player);

        $player->delete();

        $this->assertModelMissing($certificate);
        Storage::disk('local')->assertMissing($certificate->pdf_path);
    }

    public function test_verify_page_shows_the_certificate_for_a_known_code(): void
    {
        $event = Event::query()->create(['title' => 'Junior National Jumpball Championship', 'start_date' => '2026-11-03', 'end_date' => '2026-11-05', 'city' => 'Deoghar']);
        $certificate = $this->issue($this->approvedPlayer(), ['event_id' => $event->id, 'achievement' => 'Winner, Junior Boys']);

        $this->get(route('frontend.certificates.verify', $certificate->verification_code))
            ->assertOk()
            ->assertSee('Valid certificate')
            ->assertSee($certificate->certificate_no)
            ->assertSee('Aarav Sharma')
            ->assertSee($certificate->player->registration_no)
            ->assertSee('Winner, Junior Boys')
            ->assertSee('Junior National Jumpball Championship')
            ->assertSee('<meta content="noindex" name="robots"/>', false);
    }

    public function test_verify_page_rejects_an_unknown_code(): void
    {
        $certificate = $this->issue($this->approvedPlayer());

        $this->get(route('frontend.certificates.verify', 'not-a-real-code'))
            ->assertNotFound()
            ->assertSee('Not a valid certificate')
            ->assertDontSee($certificate->certificate_no);
    }

    public function test_lookup_with_the_right_player_id_and_date_of_birth_lists_signed_download_links(): void
    {
        $player = $this->approvedPlayer();
        $certificate = $this->issue($player);

        $this->post(route('frontend.certificates.lookup'), ['player_id' => strtolower($player->registration_no), 'date_of_birth' => '2008-01-15'])
            ->assertRedirect(route('frontend.certificates.index'));

        $this->followingRedirects()
            ->post(route('frontend.certificates.lookup'), ['player_id' => $player->registration_no, 'date_of_birth' => '2008-01-15'])
            ->assertOk()
            ->assertSee('Certificates for Aarav Sharma')
            ->assertSee($certificate->certificate_no)
            ->assertSee('/certificates/'.$certificate->id.'/download?expires=', false)
            ->assertSee('signature=', false);
    }

    public function test_lookup_gives_one_generic_message_for_any_wrong_combination(): void
    {
        $approved = $this->approvedPlayer();
        $this->issue($approved);
        $pending = $this->player('Priya Nair');

        $attempts = [
            ['player_id' => $approved->registration_no, 'date_of_birth' => '2008-01-16'],
            ['player_id' => 'JFI-2026-99999', 'date_of_birth' => '2008-01-15'],
            ['player_id' => $pending->registration_no, 'date_of_birth' => '2008-01-15'],
        ];

        foreach ($attempts as $attempt) {
            $this->followingRedirects()
                ->post(route('frontend.certificates.lookup'), $attempt)
                ->assertOk()
                ->assertSee('We could not find certificates for this Player ID and date of birth.')
                ->assertDontSee('Certificates for');
        }
    }

    public function test_lookup_requires_both_fields(): void
    {
        $this->post(route('frontend.certificates.lookup'), [])
            ->assertSessionHasErrors([
                'player_id' => 'Enter your Player ID.',
                'date_of_birth' => 'Enter your date of birth.',
            ]);
    }

    public function test_lookup_is_limited_to_ten_attempts_a_minute(): void
    {
        foreach (range(1, 10) as $attempt) {
            $this->post(route('frontend.certificates.lookup'), ['player_id' => 'JFI-2026-99999', 'date_of_birth' => '2008-01-15'])->assertRedirect();
        }

        $this->post(route('frontend.certificates.lookup'), ['player_id' => 'JFI-2026-99999', 'date_of_birth' => '2008-01-15'])
            ->assertTooManyRequests();
    }

    public function test_a_signed_link_downloads_the_pdf(): void
    {
        $certificate = $this->issue($this->approvedPlayer());

        $this->get(URL::temporarySignedRoute('frontend.certificates.download', now()->addMinutes(30), $certificate))
            ->assertOk()
            ->assertDownload($certificate->certificate_no.'.pdf');
    }

    public function test_unsigned_and_expired_links_are_rejected(): void
    {
        $certificate = $this->issue($this->approvedPlayer());
        $signedUrl = URL::temporarySignedRoute('frontend.certificates.download', now()->addMinutes(30), $certificate);

        $this->get(route('frontend.certificates.download', $certificate))->assertForbidden();

        $this->travel(31)->minutes();

        $this->get($signedUrl)->assertForbidden();
    }

    private function pageCount(Certificate $certificate): int
    {
        return preg_match_all('#/Type\s*/Page\b(?!s)#', Storage::disk('local')->get($certificate->pdf_path));
    }

    private function approvedPlayer(string $name = 'Aarav Sharma'): Player
    {
        $player = $this->player($name);
        $player->forceFill(['status' => RegistrationStatus::Approved])->save();

        return $player;
    }

    private function player(string $name): Player
    {
        return Player::query()->create([
            'name' => $name,
            'date_of_birth' => '2008-01-15',
            'gender' => Gender::Male,
            'email' => str($name)->slug().'@example.com',
            'phone' => '9800000001',
            'password' => 'secret-password',
        ])->refresh();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function issue(Player $player, array $attributes = []): Certificate
    {
        return $player->certificates()->create([
            'title' => 'Certificate of Participation',
            'issued_on' => '2026-11-05',
            ...$attributes,
        ])->refresh();
    }
}
