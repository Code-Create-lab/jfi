<?php

namespace Tests\Feature;

use App\Enums\Gender;
use App\Enums\RegistrationStatus;
use App\Mail\PlayerPasswordReset;
use App\Models\Certificate;
use App\Models\Player;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PlayerAreaTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');
    }

    public function test_player_signs_in_with_email(): void
    {
        $player = $this->player('Aarav Sharma');

        $this->post(route('frontend.players.login.store'), ['login' => $player->email, 'password' => 'secret-password'])
            ->assertRedirect(route('player.dashboard'));

        $this->assertAuthenticatedAs($player, 'player');
    }

    public function test_player_signs_in_with_player_id_in_any_case(): void
    {
        $player = $this->player('Aarav Sharma');

        $this->post(route('frontend.players.login.store'), ['login' => ' '.strtolower($player->registration_no), 'password' => 'secret-password'])
            ->assertRedirect(route('player.dashboard'));

        $this->assertAuthenticatedAs($player, 'player');
    }

    public function test_wrong_password_gets_a_generic_message(): void
    {
        $player = $this->player('Aarav Sharma');

        $this->post(route('frontend.players.login.store'), ['login' => $player->email, 'password' => 'wrong-password'])
            ->assertSessionHasErrors(['login' => 'The details you entered do not match our records.']);

        $this->assertGuest('player');
    }

    public function test_sign_in_is_limited_to_five_attempts_a_minute(): void
    {
        $player = $this->player('Aarav Sharma');

        foreach (range(1, 5) as $attempt) {
            $this->post(route('frontend.players.login.store'), ['login' => $player->email, 'password' => 'wrong-password'])->assertRedirect();
        }

        $this->post(route('frontend.players.login.store'), ['login' => $player->email, 'password' => 'secret-password'])
            ->assertTooManyRequests();
    }

    public function test_guests_are_sent_to_the_player_login(): void
    {
        $this->get(route('player.dashboard'))->assertRedirect(route('frontend.players.login'));
    }

    public function test_an_admin_session_does_not_open_the_player_area(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('player.dashboard'))->assertRedirect(route('frontend.players.login'));
    }

    public function test_signed_in_player_skips_the_login_page_and_sees_account_links(): void
    {
        $this->actingAs($this->player('Aarav Sharma'), 'player');

        $this->get(route('frontend.players.login'))->assertRedirect(route('player.dashboard'));
        $this->get(route('frontend.home'))->assertSee('My Account')->assertSee('Log out');
    }

    public function test_pending_player_sees_their_status_and_no_certificates(): void
    {
        $this->actingAs($this->player('Priya Nair', RegistrationStatus::Pending), 'player');

        $this->get(route('player.dashboard'))
            ->assertOk()
            ->assertSee('Registration pending')
            ->assertSee('Certificates are available once your registration is approved.');
    }

    public function test_rejected_player_sees_the_reason(): void
    {
        $player = $this->player('Priya Nair', RegistrationStatus::Pending);
        $player->reject('Age proof is unreadable.');

        $this->actingAs($player, 'player');

        $this->get(route('player.dashboard'))
            ->assertOk()
            ->assertSee('Registration rejected')
            ->assertSee('Age proof is unreadable.');
    }

    public function test_approved_player_downloads_their_own_certificate(): void
    {
        $player = $this->player('Aarav Sharma');
        $certificate = $this->issue($player);

        $this->actingAs($player, 'player');

        $this->get(route('player.dashboard'))->assertSee($certificate->certificate_no);
        $this->get(route('player.certificates.download', $certificate))
            ->assertOk()
            ->assertDownload($certificate->certificate_no.'.pdf');
    }

    public function test_player_cannot_download_another_players_certificate(): void
    {
        $other = $this->issue($this->player('Priya Nair'));

        $this->actingAs($this->player('Aarav Sharma'), 'player');

        $this->get(route('player.certificates.download', $other))->assertNotFound();
    }

    public function test_pending_player_cannot_download_certificates(): void
    {
        $player = $this->player('Aarav Sharma');
        $certificate = $this->issue($player);
        $player->forceFill(['status' => RegistrationStatus::Pending])->save();

        $this->actingAs($player, 'player');

        $this->get(route('player.certificates.download', $certificate))
            ->assertRedirect(route('player.dashboard'))
            ->assertSessionHas('status', 'Certificates can be downloaded once your registration is approved.');
    }

    public function test_logout_signs_the_player_out(): void
    {
        $this->actingAs($this->player('Aarav Sharma'), 'player');

        $this->post(route('player.logout'))->assertRedirect(route('frontend.players.login'));

        $this->assertGuest('player');
    }

    public function test_forgot_password_emails_a_reset_link_and_never_reveals_unknown_emails(): void
    {
        Mail::fake();
        $player = $this->player('Aarav Sharma');

        $this->post(route('player.password.email'), ['email' => $player->email])->assertSessionHas('status');
        $this->post(route('player.password.email'), ['email' => 'nobody@example.com'])->assertSessionHas('status');

        Mail::assertSent(PlayerPasswordReset::class, 1);
        Mail::assertSent(PlayerPasswordReset::class, fn (PlayerPasswordReset $mail): bool => $mail->hasTo($player->email)
            && str_contains($mail->render(), '/player/reset-password/'));
    }

    public function test_password_can_be_reset_with_a_valid_token(): void
    {
        $player = $this->player('Aarav Sharma');
        $token = Password::broker('players')->createToken($player);

        $this->post(route('player.password.update'), ['token' => $token, 'email' => $player->email, 'password' => 'new-secret-123', 'password_confirmation' => 'new-secret-123'])
            ->assertRedirect(route('frontend.players.login'));

        $this->assertTrue(Hash::check('new-secret-123', $player->refresh()->password));
    }

    public function test_an_invalid_reset_token_is_rejected(): void
    {
        $player = $this->player('Aarav Sharma');

        $this->post(route('player.password.update'), ['token' => 'not-a-token', 'email' => $player->email, 'password' => 'new-secret-123', 'password_confirmation' => 'new-secret-123'])
            ->assertSessionHasErrors(['email' => 'This reset link is invalid or has expired. Please request a new one.']);

        $this->assertTrue(Hash::check('secret-password', $player->refresh()->password));
    }

    private function player(string $name, RegistrationStatus $status = RegistrationStatus::Approved): Player
    {
        $player = Player::query()->create([
            'name' => $name,
            'date_of_birth' => '2008-01-15',
            'gender' => Gender::Male,
            'email' => str($name)->slug().'@example.com',
            'phone' => '9800000001',
            'password' => 'secret-password',
        ]);
        $player->forceFill(['status' => $status])->save();

        return $player->refresh();
    }

    private function issue(Player $player): Certificate
    {
        return $player->certificates()->create(['title' => 'Certificate of Participation', 'issued_on' => '2026-11-05'])->refresh();
    }
}
