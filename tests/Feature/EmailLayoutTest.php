<?php

namespace Tests\Feature;

use App\Enums\Gender;
use App\Mail\PlayerPasswordReset;
use App\Mail\RegistrationApproved;
use App\Mail\RegistrationReceived;
use App\Mail\RegistrationRejected;
use App\Models\Player;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Mail\Mailable;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class EmailLayoutTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, array{class-string<Mailable>, string}>
     */
    public static function mailProvider(): array
    {
        return [
            'registration received' => [RegistrationReceived::class, 'Your Jumpball Federation of India registration has been received'],
            'registration approved' => [RegistrationApproved::class, 'approved'],
            'registration rejected' => [RegistrationRejected::class, 'registration'],
            'password reset' => [PlayerPasswordReset::class, 'Reset your Jumpball Federation of India player password'],
        ];
    }

    /**
     * @param  class-string<Mailable>  $mailable
     */
    #[DataProvider('mailProvider')]
    public function test_every_email_uses_the_branded_layout(string $mailable, string $subject): void
    {
        Setting::query()->create(['key' => 'contact_email', 'value' => 'office@jfi.example']);
        Setting::query()->create(['key' => 'contact_phone', 'value' => '+91 79799 06275']);

        $player = Player::query()->create([
            'name' => 'Aarav Sharma', 'date_of_birth' => '2008-01-15', 'gender' => Gender::Male,
            'email' => 'aarav@example.com', 'phone' => '9800000001', 'password' => 'secret-password',
        ])->refresh();

        $mail = $mailable === PlayerPasswordReset::class ? new $mailable($player, 'token-123') : new $mailable($player);

        $mail->assertSeeInHtml(asset('assets/images/jfi/certificate-logo.png'), false)
            ->assertSeeInHtml('office@jfi.example')
            ->assertSeeInHtml('+91 79799 06275')
            ->assertSeeInHtml('#0A2463', false)
            ->assertDontSeeInHtml('Laravel');

        $this->assertStringContainsStringIgnoringCase($subject, $mail->envelope()->subject);
    }
}
