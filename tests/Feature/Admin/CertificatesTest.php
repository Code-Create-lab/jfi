<?php

namespace Tests\Feature\Admin;

use App\Enums\Gender;
use App\Enums\RegistrationStatus;
use App\Filament\Resources\Certificates\CertificateResource;
use App\Filament\Resources\Certificates\Pages\CreateCertificate;
use App\Filament\Resources\Certificates\Pages\EditCertificate;
use App\Filament\Resources\Certificates\Pages\ListCertificates;
use App\Filament\Resources\Players\Pages\ViewPlayer;
use App\Models\Certificate;
use App\Models\Player;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class CertificatesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        $this->actingAs(User::factory()->create());
    }

    public function test_issue_certificate_action_on_an_approved_player_creates_the_pdf(): void
    {
        $player = $this->makePlayer('Aarav Sharma', approved: true);

        Livewire::test(ViewPlayer::class, ['record' => $player->getRouteKey()])
            ->callAction('issueCertificate', ['title' => 'Certificate of Merit', 'achievement' => 'Winner, Junior Boys', 'issued_on' => '2026-11-05'])
            ->assertHasNoActionErrors()
            ->assertNotified();

        $certificate = $player->certificates()->sole();
        $this->assertSame('Certificate of Merit', $certificate->title);
        Storage::disk('local')->assertExists($certificate->pdf_path);
    }

    public function test_issue_certificate_is_not_offered_for_players_who_are_not_approved(): void
    {
        $player = $this->makePlayer('Priya Nair');

        Livewire::test(ViewPlayer::class, ['record' => $player->getRouteKey()])
            ->assertActionHidden('issueCertificate');
    }

    public function test_create_page_offers_approved_players_only(): void
    {
        $approved = $this->makePlayer('Aarav Sharma', approved: true);
        $pending = $this->makePlayer('Priya Nair');

        Livewire::test(CreateCertificate::class)
            ->fillForm(['player_id' => $pending->id, 'title' => 'Certificate of Participation', 'issued_on' => '2026-11-05'])
            ->call('create')
            ->assertHasFormErrors(['player_id']);

        Livewire::test(CreateCertificate::class)
            ->fillForm(['player_id' => $approved->id, 'title' => 'Certificate of Participation', 'issued_on' => '2026-11-05'])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertSame(1, Certificate::query()->count());
        $this->assertTrue($approved->certificates()->exists());
    }

    public function test_title_must_fit_on_one_line_of_the_template(): void
    {
        $player = $this->makePlayer('Aarav Sharma', approved: true);

        Livewire::test(CreateCertificate::class)
            ->fillForm(['player_id' => $player->id, 'title' => str_repeat('A', 41), 'issued_on' => '2026-11-05'])
            ->call('create')
            ->assertHasFormErrors(['title' => 'max']);
    }

    public function test_regenerate_renders_the_pdf_again(): void
    {
        $certificate = $this->issueTo($this->makePlayer('Aarav Sharma', approved: true));
        Storage::disk('local')->put($certificate->pdf_path, 'stale copy');

        Livewire::test(ListCertificates::class)
            ->callAction(TestAction::make('regenerate')->table($certificate))
            ->assertNotified('PDF regenerated');

        $this->assertStringStartsWith('%PDF', Storage::disk('local')->get($certificate->pdf_path));
    }

    public function test_certificates_have_no_bulk_actions(): void
    {
        $certificate = $this->issueTo($this->makePlayer('Aarav Sharma', approved: true));

        $table = Livewire::test(ListCertificates::class)
            ->assertCanSeeTableRecords([$certificate])
            ->instance()
            ->getTable();

        $this->assertSame([], $table->getFlatBulkActions());
        $this->assertFalse($table->isSelectionEnabled());
    }

    public function test_deleting_a_certificate_deletes_its_pdf(): void
    {
        $certificate = $this->issueTo($this->makePlayer('Aarav Sharma', approved: true));

        Livewire::test(EditCertificate::class, ['record' => $certificate->getRouteKey()])->callAction('delete');

        $this->assertModelMissing($certificate);
        Storage::disk('local')->assertMissing($certificate->pdf_path);
    }

    public function test_admin_pages_load(): void
    {
        $certificate = $this->issueTo($this->makePlayer('Aarav Sharma', approved: true));

        $this->get(CertificateResource::getUrl('index'))->assertOk()->assertSee($certificate->certificate_no);
        $this->get(CertificateResource::getUrl('create'))->assertOk()->assertSee('Issue certificate');
        $this->get(CertificateResource::getUrl('edit', ['record' => $certificate]))->assertOk()->assertSee('Download PDF');
    }

    public function test_table_search_finds_certificates_by_player_id(): void
    {
        $aarav = $this->issueTo($this->makePlayer('Aarav Sharma', approved: true));
        $priya = $this->issueTo($this->makePlayer('Priya Nair', approved: true));

        Livewire::test(ListCertificates::class)
            ->searchTable($priya->player->registration_no)
            ->assertCanSeeTableRecords([$priya])
            ->assertCanNotSeeTableRecords([$aarav]);
    }

    public function test_admin_download_needs_an_admin_session(): void
    {
        $certificate = $this->issueTo($this->makePlayer('Aarav Sharma', approved: true));
        $url = route('filament.admin.certificates.download', $certificate);

        $this->get($url)->assertOk()->assertDownload($certificate->certificate_no.'.pdf');

        auth()->logout();
        $this->get($url)->assertRedirect('/admin/login');
    }

    private function issueTo(Player $player): Certificate
    {
        return $player->certificates()->create(['title' => 'Certificate of Participation', 'issued_on' => '2026-11-05'])->refresh();
    }

    private function makePlayer(string $name, bool $approved = false): Player
    {
        $player = Player::query()->create([
            'name' => $name,
            'date_of_birth' => '2008-01-15',
            'gender' => Gender::Male,
            'email' => str($name)->slug().'@example.com',
            'phone' => '9800000001',
            'password' => 'secret-password',
        ]);

        if ($approved) {
            $player->forceFill(['status' => RegistrationStatus::Approved])->save();
        }

        return $player->refresh();
    }
}
