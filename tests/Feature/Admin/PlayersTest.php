<?php

namespace Tests\Feature\Admin;

use App\Enums\Gender;
use App\Enums\RegistrationStatus;
use App\Filament\Resources\Players\Pages\CreatePlayer;
use App\Filament\Resources\Players\Pages\EditPlayer;
use App\Filament\Resources\Players\Pages\ListPlayers;
use App\Filament\Resources\Players\Pages\ViewPlayer;
use App\Filament\Resources\Players\Tables\PlayersTable;
use App\Mail\RegistrationApproved;
use App\Mail\RegistrationRejected;
use App\Models\Player;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use RuntimeException;
use Tests\TestCase;

class PlayersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_list_shows_players_and_status_tabs_filter(): void
    {
        $pending = $this->makePlayer('Aarav Sharma');
        $approved = $this->makePlayer('Priya Nair');
        $approved->approve();

        Livewire::test(ListPlayers::class)
            ->assertCanSeeTableRecords([$pending, $approved])
            ->set('activeTab', 'pending')
            ->assertCanSeeTableRecords([$pending])
            ->assertCanNotSeeTableRecords([$approved]);
    }

    public function test_list_searches_by_player_id(): void
    {
        $first = $this->makePlayer('Aarav Sharma');
        $second = $this->makePlayer('Priya Nair');

        Livewire::test(ListPlayers::class)
            ->searchTable($second->registration_no)
            ->assertCanSeeTableRecords([$second])
            ->assertCanNotSeeTableRecords([$first]);
    }

    public function test_admin_can_create_a_player_with_documents(): void
    {
        Storage::fake('local');

        Livewire::test(CreatePlayer::class)
            ->fillForm([
                'name' => 'Rohan Verma',
                'date_of_birth' => '2007-05-20',
                'gender' => Gender::Male->value,
                'email' => 'rohan@example.com',
                'phone' => '9876543210',
                'pincode' => '411001',
                'password' => 'secret-password',
                'documents' => [
                    ['document_type' => 'age_proof', 'file_path' => [UploadedFile::fake()->create('birth-certificate.pdf', 100, 'application/pdf')]],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $player = Player::query()->where('email', 'rohan@example.com')->firstOrFail();

        $this->assertMatchesRegularExpression('/^JFI-\d{4}-\d{5}$/', $player->registration_no);
        $this->assertSame(RegistrationStatus::Pending, $player->status);
        $this->assertTrue(Hash::check('secret-password', $player->password));

        $document = $player->documents()->firstOrFail();
        $this->assertSame('birth-certificate.pdf', $document->original_name);
        Storage::disk('local')->assertExists($document->file_path);
    }

    public function test_form_validates_required_fields_and_formats(): void
    {
        Livewire::test(CreatePlayer::class)
            ->fillForm(['name' => '', 'email' => 'not-an-email', 'phone' => '12', 'pincode' => '000'])
            ->call('create')
            ->assertHasFormErrors(['name' => 'required', 'email', 'phone', 'pincode', 'date_of_birth' => 'required', 'password' => 'required']);
    }

    public function test_editing_without_a_password_keeps_the_current_one(): void
    {
        $player = $this->makePlayer('Aarav Sharma');

        Livewire::test(EditPlayer::class, ['record' => $player->getRouteKey()])
            ->fillForm(['city' => 'Pune', 'password' => ''])
            ->call('save')
            ->assertHasNoFormErrors();

        $player->refresh();
        $this->assertSame('Pune', $player->city);
        $this->assertTrue(Hash::check('secret-password', $player->password));
    }

    public function test_approving_sets_review_fields_and_emails_the_player(): void
    {
        Mail::fake();
        $player = $this->makePlayer('Aarav Sharma');

        Livewire::test(ViewPlayer::class, ['record' => $player->getRouteKey()])
            ->callAction('approve', ['remarks' => 'Welcome aboard.'])
            ->assertHasNoActionErrors();

        $player->refresh();
        $this->assertSame(RegistrationStatus::Approved, $player->status);
        $this->assertSame('Welcome aboard.', $player->admin_remarks);
        $this->assertNotNull($player->reviewed_at);
        Mail::assertSent(RegistrationApproved::class, fn (RegistrationApproved $mail): bool => $mail->hasTo($player->email));
    }

    public function test_rejecting_requires_a_reason_and_emails_the_player(): void
    {
        Mail::fake();
        $player = $this->makePlayer('Aarav Sharma');

        Livewire::test(ListPlayers::class)
            ->callAction(TestAction::make('reject')->table($player), ['remarks' => ''])
            ->assertHasActionErrors(['remarks' => 'required']);

        Livewire::test(ListPlayers::class)
            ->callAction(TestAction::make('reject')->table($player), ['remarks' => 'Age proof is unreadable.'])
            ->assertHasNoActionErrors();

        $player->refresh();
        $this->assertSame(RegistrationStatus::Rejected, $player->status);
        $this->assertSame('Age proof is unreadable.', $player->admin_remarks);
        Mail::assertSent(RegistrationRejected::class);
    }

    public function test_status_is_saved_even_if_the_email_fails(): void
    {
        Mail::shouldReceive('to')->andThrow(new RuntimeException('SMTP not configured'));
        $player = $this->makePlayer('Aarav Sharma');

        Livewire::test(ViewPlayer::class, ['record' => $player->getRouteKey()])
            ->callAction('approve')
            ->assertNotified();

        $this->assertSame(RegistrationStatus::Approved, $player->fresh()->status);
    }

    public function test_csv_export_lists_players_and_neutralises_formulas(): void
    {
        $this->makePlayer('=HYPERLINK("http://evil.example")');
        $this->makePlayer('Priya Nair');

        ob_start();
        PlayersTable::exportCsv(Player::query())->sendContent();
        $csv = ob_get_clean();

        $this->assertStringContainsString('"Player ID",Name', $csv);
        $this->assertStringContainsString('Priya Nair', $csv);
        $this->assertStringContainsString("'=HYPERLINK", $csv);

        Livewire::test(ListPlayers::class)
            ->callAction(TestAction::make('exportCsv')->table())
            ->assertFileDownloaded('jfi-players-'.now()->format('Y-m-d').'.csv');
    }

    public function test_documents_download_only_for_admins(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('registration-documents/players/id.pdf', 'pdf-bytes');

        $player = $this->makePlayer('Aarav Sharma');
        $document = $player->documents()->create(['document_type' => 'id_proof', 'file_path' => 'registration-documents/players/id.pdf', 'original_name' => 'id-proof.pdf']);
        $url = route('filament.admin.registration-documents.download', $document);

        $this->get($url)->assertOk()->assertDownload('id-proof.pdf');

        auth()->logout();
        $this->get($url)->assertRedirect('/admin/login');
    }

    public function test_deleting_a_player_removes_documents_and_photo(): void
    {
        Storage::fake('local');
        Storage::disk('local')->put('player-photos/p.jpg', 'x');
        Storage::disk('local')->put('registration-documents/players/id.pdf', 'x');

        $player = $this->makePlayer('Aarav Sharma', ['photo' => 'player-photos/p.jpg']);
        $player->documents()->create(['document_type' => 'id_proof', 'file_path' => 'registration-documents/players/id.pdf']);

        Livewire::test(EditPlayer::class, ['record' => $player->getRouteKey()])->callAction('delete');

        $this->assertModelMissing($player);
        Storage::disk('local')->assertMissing(['player-photos/p.jpg', 'registration-documents/players/id.pdf']);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function makePlayer(string $name, array $attributes = []): Player
    {
        static $n = 0;
        $n++;

        return Player::query()->create([
            'name' => $name,
            'date_of_birth' => '2008-01-15',
            'gender' => Gender::Female,
            'email' => "player{$n}@example.com",
            'phone' => '98000000'.str_pad((string) $n, 2, '0', STR_PAD_LEFT),
            'password' => 'secret-password',
            ...$attributes,
        ])->refresh();
    }
}
