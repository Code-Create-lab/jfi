<?php

namespace Tests\Feature;

use App\Enums\Gender;
use App\Models\Certificate;
use App\Models\CommunityCategory;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Page;
use App\Models\Player;
use App\Models\Setting;
use App\Models\StateAssociation;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\DemoSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Placeholder in pageProvider for the demo certificate's verification code.
     */
    private const string DEMO_CERTIFICATE = 'demo-certificate';

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');
        Storage::fake('local');
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Every public page from CLAUDE.md section 4 (except the admin area),
     * with DemoSeeder data.
     *
     * @return array<string, array{string, array<string, string>, string}>
     */
    public static function pageProvider(): array
    {
        return [
            'home' => ['frontend.home', [], 'Jumpball Federation of India'],
            'about federation' => ['frontend.about.federation', [], 'About the Federation'],
            'about jumpball' => ['frontend.about.jumpball', [], 'About Jumpball'],
            'president message' => ['frontend.about.president', [], 'President&#039;s Message'],
            'national office bearers' => ['frontend.office-bearers.national', [], 'National Office Bearers'],
            'state office bearers' => ['frontend.office-bearers.state', [], 'State Office Bearers'],
            'state associations' => ['frontend.associations.index', [], 'Recognized State Associations'],
            'association registration' => ['frontend.associations.register', [], 'Register a State Association'],
            'player registration' => ['frontend.players.register', [], 'Player Registration'],
            'player database' => ['frontend.players.index', [], 'Player Database'],
            'international players' => ['frontend.players.international', [], 'International Players'],
            'player login' => ['frontend.players.login', [], 'Player Login'],
            'rule book' => ['frontend.rule-book', [], 'Rule Book'],
            'current events' => ['frontend.events.current', [], 'Current Events'],
            'upcoming events' => ['frontend.events.upcoming', [], 'Upcoming Events'],
            'previous events' => ['frontend.events.previous', [], 'Previous Events'],
            'event detail' => ['frontend.events.show', ['slug' => 'junior-national-jumpball-championship'], 'Junior National Jumpball Championship'],
            'championship results' => ['frontend.results.index', [], 'Championship Results'],
            'winners' => ['frontend.results.winners', [], 'Winners'],
            'runners-up' => ['frontend.results.runners-up', [], 'Runners-up'],
            'third place' => ['frontend.results.third-place', [], 'Third Place'],
            'certificates' => ['frontend.certificates.index', [], 'Certificates &amp; Verification'],
            'certificate verification' => ['frontend.certificates.verify', ['code' => self::DEMO_CERTIFICATE], 'Certificate Verification'],
            'news' => ['frontend.news.index', [], 'News &amp; Press Releases'],
            'news article' => ['frontend.news.show', ['slug' => 'junior-national-championship-concludes'], 'Junior National Championship Concludes'],
            'photo gallery' => ['frontend.gallery.index', [], 'Photo Gallery'],
            'photo album' => ['frontend.gallery.show', ['slug' => 'junior-national-championship-photos'], 'Junior National Championship Photos - Photos'],
            'video gallery' => ['frontend.videos', [], 'Video Gallery'],
            'downloads' => ['frontend.downloads', [], 'Downloads &amp; Official Notices'],
            'community' => ['frontend.community.index', [], 'Community &amp; Awareness'],
            'community topic' => ['frontend.community.show', ['slug' => 'player-safety'], 'Player Safety'],
            'contact' => ['frontend.contact', [], 'Contact the Federation'],
            'privacy policy' => ['frontend.legal.privacy', [], 'Privacy Policy'],
            'terms' => ['frontend.legal.terms', [], 'Terms &amp; Conditions'],
        ];
    }

    /**
     * @param  array<string, string>  $parameters
     */
    #[DataProvider('pageProvider')]
    public function test_page_renders_with_demo_data(string $routeName, array $parameters, string $title): void
    {
        $this->seed(DemoSeeder::class);

        // The demo certificate's verification code is random, so it is looked up after seeding.
        $parameters = array_map(
            fn (string $value): string => $value === self::DEMO_CERTIFICATE ? Certificate::query()->value('verification_code') : $value,
            $parameters,
        );

        $this->get(route($routeName, $parameters))
            ->assertOk()
            ->assertSee('<title>'.$title.' | JFI</title>', false)
            ->assertSee(asset('assets/css/jfi-components.css'), false)
            ->assertSee('id="main-content"', false)
            ->assertSee('<footer>', false)
            ->assertDontSee('Lorem ipsum');
    }

    public function test_every_page_without_parameters_works_on_an_empty_database(): void
    {
        $routes = collect(Route::getRoutes()->getRoutesByName())
            ->filter(fn ($route, string $name): bool => str_starts_with($name, 'frontend.') && $route->parameterNames() === []);

        $this->assertGreaterThan(25, $routes->count());

        foreach ($routes->keys() as $name) {
            $this->get(route($name))->assertOk();
        }
    }

    public function test_content_comes_from_the_database(): void
    {
        $this->seed(DemoSeeder::class);

        $this->get(route('frontend.home'))
            ->assertSee('Senior National Jumpball Championship')
            ->assertSee('National Championship Calendar Announced')
            ->assertSee('sample-banner.webp');

        $this->get(route('frontend.events.show', 'junior-national-jumpball-championship'))
            ->assertSee('Junior Boys')
            ->assertSee('Maharashtra Jumpball Association');

        $this->get(route('frontend.results.winners'))
            ->assertSee('Maharashtra')
            ->assertDontSee('17 - 21');
    }

    public function test_unpublished_content_is_not_found(): void
    {
        $this->seed(DemoSeeder::class);

        Event::query()->where('slug', 'junior-national-jumpball-championship')->update(['is_published' => false]);
        News::query()->where('slug', 'junior-national-championship-concludes')->update(['is_published' => false]);
        Gallery::query()->update(['is_published' => false]);
        CommunityCategory::query()->where('slug', 'player-safety')->update(['is_published' => false]);
        Page::query()->where('slug', 'about-jumpball')->update(['is_published' => false]);

        $this->get(route('frontend.events.show', 'junior-national-jumpball-championship'))->assertNotFound();
        $this->get(route('frontend.news.show', 'junior-national-championship-concludes'))->assertNotFound();
        $this->get(route('frontend.gallery.show', 'junior-national-championship-photos'))->assertNotFound();
        $this->get(route('frontend.community.show', 'player-safety'))->assertNotFound();
        $this->get(route('frontend.about.jumpball'))->assertNotFound();
        $this->get(route('frontend.events.previous'))->assertDontSee('Junior National Jumpball Championship');
    }

    public function test_public_player_list_shows_approved_players_only_without_personal_details(): void
    {
        $association = StateAssociation::query()->create(['name' => 'Kerala Jumpball Association', 'state' => 'Kerala', 'email' => 'k@example.com', 'phone' => '9800000000']);
        $approved = $this->player('Approved Player', 'approved@example.com', '9811111111', $association);
        $approved->approve();
        $this->player('Pending Player', 'pending@example.com', '9822222222', $association);

        $this->get(route('frontend.players.index'))
            ->assertOk()
            ->assertSee('Approved Player')
            ->assertSee($approved->registration_no)
            ->assertDontSee('Pending Player')
            ->assertDontSee('approved@example.com')
            ->assertDontSee('9811111111')
            ->assertDontSee('2008-01-15')
            ->assertSeeInOrder(['<th scope="col">Player ID</th>', '<th scope="col">Name</th>', '<th scope="col">State association</th>'], false);

        $this->get(route('frontend.players.index', ['q' => $approved->registration_no]))->assertSee('Approved Player');
        $this->get(route('frontend.players.index', ['q' => 'nobody']))->assertSee('No players found');
    }

    public function test_pending_associations_are_not_listed(): void
    {
        $this->seed(DemoSeeder::class);

        $this->get(route('frontend.associations.index'))
            ->assertSee('Maharashtra Jumpball Association')
            ->assertDontSee('Karnataka Jumpball Association');
    }

    public function test_footer_and_contact_page_use_site_settings(): void
    {
        Setting::query()->where('key', 'contact_email')->first()->update(['value' => 'office@jfi.example']);
        Setting::query()->where('key', 'facebook_url')->first()->update(['value' => 'https://facebook.com/jfi']);
        Setting::query()->where('key', 'map_embed')->first()->update(['value' => 'https://www.google.com/maps/embed?pb=test']);

        $this->get(route('frontend.contact'))
            ->assertSee('mailto:office@jfi.example', false)
            ->assertSee('https://facebook.com/jfi', false)
            ->assertSee('https://www.google.com/maps/embed?pb=test', false);

        $this->get(route('frontend.home'))->assertSee('mailto:office@jfi.example', false);
    }

    public function test_unknown_certificate_code_shows_not_found_state(): void
    {
        $this->get(route('frontend.certificates.verify', ['code' => 'invalid']))
            ->assertNotFound()
            ->assertSee('Not a valid certificate');
    }

    public function test_unknown_page_shows_custom_404(): void
    {
        $this->get('/this-page-does-not-exist')
            ->assertNotFound()
            ->assertSee('Page Not Found')
            ->assertSee(asset('assets/css/jfi-components.css'), false);
    }

    public function test_footer_credits_the_developer(): void
    {
        $this->get(route('frontend.home'))
            ->assertOk()
            ->assertSee('Designed &amp; Developed by', false)
            ->assertSee('href="https://10xcart.snehal.info/"', false)
            ->assertSee('href="https://www.instagram.com/10xcart"', false);
    }

    public function test_site_stylesheets_and_scripts_carry_a_version_for_browser_caches(): void
    {
        $this->get(route('frontend.home'))
            ->assertOk()
            ->assertSee(asset('assets/css/jfi-theme.css').'?v='.filemtime(public_path('assets/css/jfi-theme.css')), false)
            ->assertSee(asset('assets/js/banner.js').'?v='.filemtime(public_path('assets/js/banner.js')), false);
    }

    private function player(string $name, string $email, string $phone, StateAssociation $association): Player
    {
        return Player::query()->create([
            'name' => $name, 'email' => $email, 'phone' => $phone, 'date_of_birth' => '2008-01-15',
            'gender' => Gender::Male, 'password' => 'secret-password', 'state_association_id' => $association->id,
        ])->refresh();
    }
}
