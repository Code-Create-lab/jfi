<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Every public page from CLAUDE.md section 4 (except the admin area).
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
            'certificate verification' => ['frontend.certificates.verify', ['code' => 'SAMPLE'], 'Certificate Verification'],
            'news' => ['frontend.news.index', [], 'News &amp; Press Releases'],
            'news article' => ['frontend.news.show', ['slug' => 'player-registration-now-open-online'], 'Player Registration Now Open Online'],
            'photo gallery' => ['frontend.gallery.index', [], 'Photo Gallery'],
            'photo album' => ['frontend.gallery.show', ['slug' => 'junior-national-championship'], 'Junior National Championship - Photos'],
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
    public function test_page_renders_with_layout(string $routeName, array $parameters, string $title): void
    {
        $response = $this->get(route($routeName, $parameters));

        $response->assertOk()
            ->assertSee('<title>'.$title.' | JFI</title>', false)
            ->assertSee(asset('assets/css/jfi-components.css'), false)
            ->assertSee(asset('assets/images/jfi-logo.png'), false)
            ->assertSee('id="main-content"', false)
            ->assertSee('<footer>', false)
            ->assertDontSee('Adelux')
            ->assertDontSee('Lorem ipsum');
    }

    public function test_unknown_certificate_code_shows_not_found_state(): void
    {
        $this->get(route('frontend.certificates.verify', ['code' => 'invalid']))
            ->assertOk()
            ->assertSee('Certificate not found');
    }

    public function test_public_player_list_never_shows_personal_details(): void
    {
        $this->get(route('frontend.players.index'))
            ->assertOk()
            ->assertSee('JFI-2026-00001')
            ->assertSeeInOrder(['<th scope="col">Player ID</th>', '<th scope="col">Name</th>', '<th scope="col">State association</th>'], false)
            ->assertDontSee('<th scope="col">Date of birth</th>', false)
            ->assertDontSee('<th scope="col">Email</th>', false)
            ->assertDontSee('<th scope="col">Phone</th>', false);
    }

    public function test_unknown_page_shows_custom_404(): void
    {
        $this->get('/this-page-does-not-exist')
            ->assertNotFound()
            ->assertSee('Page Not Found')
            ->assertSee(asset('assets/css/jfi-components.css'), false);
    }
}
