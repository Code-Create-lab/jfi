<?php

namespace Tests\Feature\Admin;

use App\Enums\BearerLevel;
use App\Enums\Gender;
use App\Enums\RegistrationStatus;
use App\Filament\Resources\OfficeBearers\Pages\CreateOfficeBearer;
use App\Filament\Resources\StateAssociations\Pages\CreateStateAssociation;
use App\Filament\Resources\StateAssociations\Pages\EditStateAssociation;
use App\Filament\Resources\StateAssociations\Pages\ListStateAssociations;
use App\Filament\Resources\StateAssociations\Pages\ViewStateAssociation;
use App\Mail\RegistrationApproved;
use App\Mail\RegistrationRejected;
use App\Models\OfficeBearer;
use App\Models\Player;
use App\Models\StateAssociation;
use App\Models\User;
use Filament\Actions\Testing\TestAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use RuntimeException;
use Tests\TestCase;

class StateAssociationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_approving_sets_status_and_reviewed_at_and_sends_the_approval_mail(): void
    {
        Mail::fake();
        $association = $this->makeAssociation('Kerala Jumpball Association');

        Livewire::test(ViewStateAssociation::class, ['record' => $association->getRouteKey()])
            ->callAction('approve', ['remarks' => 'Recognized for 2026.'])
            ->assertHasNoActionErrors();

        $association->refresh();
        $this->assertSame(RegistrationStatus::Approved, $association->status);
        $this->assertSame('Recognized for 2026.', $association->admin_remarks);
        $this->assertNotNull($association->reviewed_at);
        Mail::assertSent(RegistrationApproved::class, fn (RegistrationApproved $mail): bool => $mail->hasTo($association->email) && $mail->registrant->is($association));
        Mail::assertNotSent(RegistrationRejected::class);
    }

    public function test_rejecting_requires_a_reason_and_sends_the_rejection_mail(): void
    {
        Mail::fake();
        $association = $this->makeAssociation('Kerala Jumpball Association');

        Livewire::test(ListStateAssociations::class)
            ->callAction(TestAction::make('reject')->table($association), ['remarks' => ''])
            ->assertHasActionErrors(['remarks' => 'required']);

        $this->assertSame(RegistrationStatus::Pending, $association->fresh()->status);

        Livewire::test(ListStateAssociations::class)
            ->callAction(TestAction::make('reject')->table($association), ['remarks' => 'Society certificate missing.'])
            ->assertHasNoActionErrors();

        $association->refresh();
        $this->assertSame(RegistrationStatus::Rejected, $association->status);
        $this->assertSame('Society certificate missing.', $association->admin_remarks);
        $this->assertNotNull($association->reviewed_at);
        Mail::assertSent(RegistrationRejected::class, fn (RegistrationRejected $mail): bool => $mail->hasTo($association->email));
        Mail::assertNotSent(RegistrationApproved::class);
    }

    public function test_status_is_kept_when_the_mail_fails(): void
    {
        Mail::shouldReceive('to')->andThrow(new RuntimeException('SMTP not configured'));
        $association = $this->makeAssociation('Kerala Jumpball Association');

        Livewire::test(ViewStateAssociation::class, ['record' => $association->getRouteKey()])
            ->callAction('approve')
            ->assertNotified();

        $this->assertSame(RegistrationStatus::Approved, $association->fresh()->status);
    }

    public function test_emails_render_for_an_association(): void
    {
        $association = $this->makeAssociation('Kerala Jumpball Association');
        $association->reject('Society certificate missing.');

        $this->assertStringContainsString('Society certificate missing.', (new RegistrationRejected($association))->render());

        $association->approve();
        $this->assertStringContainsString('recognized state association', (new RegistrationApproved($association))->render());
    }

    public function test_admin_added_association_saves_as_pending_with_private_documents(): void
    {
        Storage::fake('local');
        Storage::fake('public');

        Livewire::test(CreateStateAssociation::class)
            ->fillForm([
                'name' => 'Goa Jumpball Association',
                'state' => 'Goa',
                'email' => 'goa@example.com',
                'phone' => '9876543210',
                'logo' => UploadedFile::fake()->image('logo.png', 300, 300),
                'documents' => [
                    ['document_type' => 'registration_certificate', 'file_path' => [UploadedFile::fake()->create('society.pdf', 100, 'application/pdf')]],
                ],
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $association = StateAssociation::query()->where('email', 'goa@example.com')->firstOrFail();
        $this->assertSame(RegistrationStatus::Pending, $association->status);
        Storage::disk('public')->assertExists($association->logo);

        $document = $association->documents()->firstOrFail();
        $this->assertSame('society.pdf', $document->original_name);
        Storage::disk('local')->assertExists($document->file_path);

        $this->get(route('filament.admin.registration-documents.download', $document))
            ->assertOk()
            ->assertDownload('society.pdf');
    }

    public function test_list_filters_by_tab_and_searches_by_email(): void
    {
        $pending = $this->makeAssociation('Kerala Jumpball Association');
        $approved = $this->makeAssociation('Goa Jumpball Association');
        $approved->approve();

        Livewire::test(ListStateAssociations::class)
            ->assertCanSeeTableRecords([$pending, $approved])
            ->set('activeTab', 'approved')
            ->assertCanSeeTableRecords([$approved])
            ->assertCanNotSeeTableRecords([$pending]);

        Livewire::test(ListStateAssociations::class)
            ->searchTable($pending->email)
            ->assertCanSeeTableRecords([$pending])
            ->assertCanNotSeeTableRecords([$approved]);
    }

    public function test_deleting_unlinks_players_and_deletes_state_bearers_with_their_files(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('association-logos/logo.png', 'x');
        Storage::disk('public')->put('office-bearers/secretary.jpg', 'x');

        $association = $this->makeAssociation('Kerala Jumpball Association', ['logo' => 'association-logos/logo.png']);
        $player = Player::query()->create([
            'state_association_id' => $association->id, 'name' => 'Aarav Sharma', 'date_of_birth' => '2008-01-15',
            'gender' => Gender::Male, 'email' => 'aarav@example.com', 'phone' => '9800000001', 'password' => 'secret-password',
        ]);
        $bearer = OfficeBearer::query()->create([
            'level' => BearerLevel::State, 'state_association_id' => $association->id,
            'name' => 'State Secretary', 'designation' => 'Secretary', 'photo' => 'office-bearers/secretary.jpg',
        ]);

        Livewire::test(EditStateAssociation::class, ['record' => $association->getRouteKey()])
            ->mountAction('delete')
            ->assertMountedActionModalSee('1 player will stay registered')
            ->callMountedAction();

        $this->assertModelMissing($association);
        $this->assertModelMissing($bearer);
        $this->assertNull($player->fresh()->state_association_id);
        Storage::disk('public')->assertMissing(['association-logos/logo.png', 'office-bearers/secretary.jpg']);
    }

    public function test_office_bearer_form_offers_approved_associations_only(): void
    {
        $pending = $this->makeAssociation('Kerala Jumpball Association');
        $approved = $this->makeAssociation('Goa Jumpball Association');
        $approved->approve();

        Livewire::test(CreateOfficeBearer::class)
            ->fillForm(['name' => 'State Person', 'designation' => 'Secretary', 'level' => BearerLevel::State->value, 'state_association_id' => $pending->id])
            ->call('create')
            ->assertHasFormErrors(['state_association_id']);

        Livewire::test(CreateOfficeBearer::class)
            ->fillForm(['name' => 'State Person', 'designation' => 'Secretary', 'level' => BearerLevel::State->value, 'state_association_id' => $approved->id])
            ->call('create')
            ->assertHasNoFormErrors();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function makeAssociation(string $name, array $attributes = []): StateAssociation
    {
        return StateAssociation::query()->create([
            'name' => $name,
            'state' => 'Kerala',
            'email' => str($name)->slug().'@example.com',
            'phone' => '9800000000',
            ...$attributes,
        ])->refresh();
    }
}
