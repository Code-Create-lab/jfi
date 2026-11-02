<?php

namespace Tests\Feature\Admin;

use App\Enums\RegistrationStatus;
use App\Filament\Widgets\LatestAssociations;
use App\Filament\Widgets\LatestPlayers;
use App\Filament\Widgets\StatsOverview;
use App\Models\Player;
use App\Models\StateAssociation;
use App\Models\User;
use Filament\Auth\Pages\Login;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AdminPanelTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_the_admin_login(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_login_page_renders(): void
    {
        $this->get('/admin/login')
            ->assertOk()
            ->assertSee('Jumpball Federation of India');
    }

    public function test_admin_can_log_in(): void
    {
        $user = User::factory()->create(['password' => 'secret-password']);

        Livewire::test(Login::class)
            ->fillForm(['email' => $user->email, 'password' => 'secret-password'])
            ->call('authenticate')
            ->assertHasNoFormErrors()
            ->assertRedirect('/admin');

        $this->assertAuthenticatedAs($user);
    }

    public function test_wrong_password_is_rejected(): void
    {
        $user = User::factory()->create(['password' => 'secret-password']);

        Livewire::test(Login::class)
            ->fillForm(['email' => $user->email, 'password' => 'wrong-password'])
            ->call('authenticate')
            ->assertHasFormErrors(['email']);

        $this->assertGuest();
    }

    public function test_dashboard_shows_counts_and_recent_submissions(): void
    {
        $association = StateAssociation::query()->create([
            'name' => 'Maharashtra Jumpball Association',
            'state' => 'Maharashtra',
            'email' => 'office@mja.example',
            'phone' => '9800000000',
        ]);
        $player = Player::query()->create([
            'name' => 'Aarav Sharma',
            'date_of_birth' => '2008-04-12',
            'gender' => 'male',
            'email' => 'aarav@example.com',
            'phone' => '9800000001',
            'password' => 'secret-password',
            'state_association_id' => $association->id,
        ]);

        $this->actingAs(User::factory()->create());

        $this->get('/admin')->assertOk();

        Livewire::test(StatsOverview::class)
            ->assertSee('Registered players')
            ->assertSee('1 pending review')
            ->assertSee('1 application pending');

        Livewire::test(LatestPlayers::class)
            ->assertCanSeeTableRecords([$player])
            ->assertSee($player->fresh()->registration_no);

        Livewire::test(LatestAssociations::class)
            ->assertCanSeeTableRecords([$association])
            ->assertSee(RegistrationStatus::Pending->label());
    }
}
