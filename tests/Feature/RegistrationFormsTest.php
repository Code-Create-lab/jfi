<?php

namespace Tests\Feature;

use App\Enums\RegistrationStatus;
use App\Mail\RegistrationReceived;
use App\Models\ContactMessage;
use App\Models\Player;
use App\Models\StateAssociation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Tests\TestCase;

class RegistrationFormsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
        Storage::fake('public');
        Mail::fake();
    }

    public function test_the_contact_form_saves_a_message(): void
    {
        $this->post(route('frontend.contact.store'), [
            'name' => 'Asha Patil',
            'email' => 'asha@example.com',
            'phone' => '9876543210',
            'subject' => 'Certificates',
            'message' => 'When will the certificates be issued?',
        ])
            ->assertRedirect(route('frontend.contact'))
            ->assertSessionHas('status');

        $message = ContactMessage::query()->sole();
        $this->assertSame('Asha Patil', $message->name);
        $this->assertSame('Certificates', $message->subject);
        $this->assertNull($message->read_at);

        $this->get(route('frontend.contact'))->assertSee('Your message has been sent');
    }

    public function test_the_contact_form_shows_errors_and_keeps_old_input(): void
    {
        $this->from(route('frontend.contact'))
            ->followingRedirects()
            ->post(route('frontend.contact.store'), ['name' => 'Asha Patil'])
            ->assertOk()
            ->assertSee('value="Asha Patil"', false)
            ->assertSee('The email field is required.')
            ->assertSee('The message field is required.')
            ->assertSee('aria-invalid="true"', false);

        $this->assertSame(0, ContactMessage::query()->count());
    }

    public function test_a_filled_honeypot_is_rejected_on_every_form(): void
    {
        $association = $this->approvedAssociation();

        $this->post(route('frontend.contact.store'), [...$this->contactData(), 'website' => 'spam'])
            ->assertSessionHasErrors('website');
        $this->post(route('frontend.associations.store'), [...$this->associationData(), 'website' => 'spam'])
            ->assertSessionHasErrors('website');
        $this->post(route('frontend.players.store'), [...$this->playerData($association), 'website' => 'spam'])
            ->assertSessionHasErrors('website');

        $this->assertSame(0, ContactMessage::query()->count());
        $this->assertSame(1, StateAssociation::query()->count());
        $this->assertSame(0, Player::query()->count());
        Mail::assertNothingSent();
    }

    public function test_the_forms_are_throttled_to_five_submissions_a_minute(): void
    {
        foreach (range(1, 5) as $attempt) {
            $this->post(route('frontend.contact.store'), $this->contactData())->assertRedirect();
        }

        $this->post(route('frontend.contact.store'), $this->contactData())->assertTooManyRequests();
        $this->assertSame(5, ContactMessage::query()->count());
    }

    public function test_a_state_association_registration_is_saved_as_pending_with_private_documents(): void
    {
        $this->post(route('frontend.associations.store'), $this->associationData())
            ->assertRedirect(route('frontend.associations.register'))
            ->assertSessionHas('registered_association', 'Kerala Jumpball Association');

        $association = StateAssociation::query()->with('documents')->sole();
        $this->assertSame(RegistrationStatus::Pending, $association->status);
        $this->assertNull($association->reviewed_at);
        $this->assertNotNull($association->terms_accepted_at);
        Storage::disk('public')->assertExists($association->logo);

        $this->assertCount(2, $association->documents);
        $this->assertEqualsCanonicalizing(['registration_certificate', 'authorization_letter'], $association->documents->pluck('document_type')->all());
        foreach ($association->documents as $document) {
            $this->assertStringStartsWith('registration-documents/associations/', $document->file_path);
            $this->assertStringNotContainsString('certificate.pdf', $document->file_path);
            Storage::disk('local')->assertExists($document->file_path);
            Storage::disk('public')->assertMissing($document->file_path);
        }
        $this->assertSame('certificate.pdf', $association->documents->firstWhere('document_type', 'registration_certificate')->original_name);

        Mail::assertSent(RegistrationReceived::class, fn (RegistrationReceived $mail): bool => $mail->hasTo('office@keralajumpball.in') && $mail->registrant->is($association));

        $this->get(route('frontend.associations.register'))->assertSee('Application received');
    }

    public function test_a_state_association_registration_requires_every_document_and_the_declaration(): void
    {
        $data = $this->associationData();
        unset($data['documents']['authorization_letter'], $data['terms']);

        $this->post(route('frontend.associations.store'), $data)
            ->assertSessionHasErrors(['documents.authorization_letter', 'terms']);

        $this->assertSame(0, StateAssociation::query()->count());
        $this->assertEmpty(Storage::disk('local')->allFiles());
    }

    public function test_a_player_registration_is_saved_as_pending_with_a_player_id_and_private_files(): void
    {
        $association = $this->approvedAssociation();

        $response = $this->post(route('frontend.players.store'), $this->playerData($association));

        $player = Player::query()->with('documents')->sole();
        $response->assertRedirect(route('frontend.players.register'))
            ->assertSessionHas('registered_player', ['name' => 'Rohan Verma', 'registration_no' => $player->registration_no]);

        $this->assertSame(sprintf('JFI-%s-%05d', $player->created_at->format('Y'), $player->id), $player->registration_no);
        $this->assertSame(RegistrationStatus::Pending, $player->status);
        $this->assertTrue($player->stateAssociation()->is($association));
        $this->assertTrue(Hash::check('secret-pass', $player->password));
        $this->assertNotNull($player->terms_accepted_at);

        $this->assertStringStartsWith('player-photos/', $player->photo);
        Storage::disk('local')->assertExists($player->photo);
        $this->assertCount(2, $player->documents);
        foreach ($player->documents as $document) {
            $this->assertStringStartsWith('registration-documents/players/', $document->file_path);
            Storage::disk('local')->assertExists($document->file_path);
        }
        $this->assertEmpty(Storage::disk('public')->allFiles());

        Mail::assertSent(RegistrationReceived::class, fn (RegistrationReceived $mail): bool => $mail->hasTo('rohan@example.com') && $mail->registrant->is($player));
        $this->assertStringContainsString($player->registration_no, (new RegistrationReceived($player))->render());

        $this->get(route('frontend.players.register'))
            ->assertSee($player->registration_no)
            ->assertSee('Pending approval');
    }

    public function test_a_player_must_choose_an_approved_association(): void
    {
        $this->approvedAssociation();
        $pending = StateAssociation::query()->create([
            'name' => 'Goa Jumpball Association',
            'state' => 'Goa',
            'email' => 'goa@example.com',
            'phone' => '9800000001',
        ]);

        $this->post(route('frontend.players.store'), $this->playerData($pending))
            ->assertSessionHasErrors('state_association_id');

        $this->get(route('frontend.players.register'))
            ->assertSee('Kerala Jumpball Association')
            ->assertDontSee('Goa Jumpball Association');
        $this->assertSame(0, Player::query()->count());
    }

    public function test_a_player_registration_validates_the_mobile_number_email_and_password(): void
    {
        $association = $this->approvedAssociation();
        $this->post(route('frontend.players.store'), $this->playerData($association))->assertSessionHasNoErrors();

        $this->post(route('frontend.players.store'), [
            ...$this->playerData($association),
            'phone' => '+91 98765',
            'date_of_birth' => now()->addDay()->toDateString(),
            'password_confirmation' => 'different-pass',
        ])->assertSessionHasErrors(['email', 'phone', 'date_of_birth', 'password']);

        $this->assertSame(1, Player::query()->count());
    }

    public function test_the_player_form_is_replaced_by_a_message_while_no_association_is_approved(): void
    {
        $this->get(route('frontend.players.register'))
            ->assertOk()
            ->assertSee('Registration opens soon')
            ->assertDontSee('name="password"', false);
    }

    public function test_a_mail_failure_does_not_break_the_registration(): void
    {
        Mail::shouldReceive('to')->andThrow(new RuntimeException('SMTP not configured'));
        $association = $this->approvedAssociation();

        $this->post(route('frontend.players.store'), $this->playerData($association))
            ->assertRedirect(route('frontend.players.register'))
            ->assertSessionHas('registered_player');

        $this->assertSame(RegistrationStatus::Pending, Player::query()->sole()->status);
    }

    /**
     * @return array<string, string>
     */
    private function contactData(): array
    {
        return [
            'name' => 'Asha Patil',
            'email' => 'asha@example.com',
            'message' => 'Hello from the contact form.',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function associationData(): array
    {
        return [
            'name' => 'Kerala Jumpball Association',
            'state' => 'Kerala',
            'city' => 'Kochi',
            'pincode' => '682001',
            'email' => 'office@keralajumpball.in',
            'phone' => '9876543210',
            'president_name' => 'K. Menon',
            'logo' => UploadedFile::fake()->image('logo.png', 200, 200),
            'documents' => [
                'registration_certificate' => UploadedFile::fake()->create('certificate.pdf', 300, 'application/pdf'),
                'authorization_letter' => UploadedFile::fake()->create('letter.pdf', 300, 'application/pdf'),
            ],
            'terms' => '1',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function playerData(StateAssociation $association): array
    {
        return [
            'name' => 'Rohan Verma',
            'father_name' => 'Suresh Verma',
            'date_of_birth' => '2008-05-14',
            'gender' => 'male',
            'email' => 'rohan@example.com',
            'phone' => '9876543210',
            'city' => 'Kochi',
            'state' => 'Kerala',
            'pincode' => '682001',
            'state_association_id' => $association->id,
            'photo' => UploadedFile::fake()->image('photo.jpg', 300, 400),
            'documents' => [
                'id_proof' => UploadedFile::fake()->create('id.pdf', 300, 'application/pdf'),
                'age_proof' => UploadedFile::fake()->image('age.jpg'),
            ],
            'password' => 'secret-pass',
            'password_confirmation' => 'secret-pass',
            'terms' => '1',
        ];
    }

    private function approvedAssociation(): StateAssociation
    {
        $association = StateAssociation::query()->create([
            'name' => 'Kerala Jumpball Association',
            'state' => 'Kerala',
            'email' => 'kerala@example.com',
            'phone' => '9800000000',
        ]);
        $association->approve();

        return $association;
    }
}
