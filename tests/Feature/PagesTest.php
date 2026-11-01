<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PagesTest extends TestCase
{
    /**
     * @return array<string, array{string, string}>
     */
    public static function pageProvider(): array
    {
        return [
            'home' => ['home', 'Adelux'],
            'about' => ['about', 'About Us - Adelux'],
            'booking' => ['booking', 'Booking Court - Adelux'],
            'event' => ['event', 'Event/Tournament - Adelux'],
            'membership' => ['membership', 'Join Our Club / Membership - Adelux'],
            'service' => ['service', 'Our Services - Adelux'],
            'coaching' => ['coaching', 'Coaching / Academy - Adelux'],
            'community' => ['community', 'Community - Adelux'],
            'faq' => ['faq', 'FAQ - Adelux'],
            'blog' => ['blog', 'Blog / News - Adelux'],
            'single-post' => ['single-post', 'Single Post - Adelux'],
            'contact' => ['contact', 'Contact Us - Adelux'],
        ];
    }

    #[DataProvider('pageProvider')]
    public function test_page_renders_with_layout(string $routeName, string $title): void
    {
        $response = $this->get(route($routeName));

        $response->assertOk()
            ->assertSee('<title>'.$title.'</title>', false)
            ->assertSee(asset('assets/css/main.css'), false)
            ->assertSee('<header>', false)
            ->assertSee('<footer>', false);
    }

    public function test_unknown_page_shows_custom_404(): void
    {
        $response = $this->get('/this-page-does-not-exist');

        $response->assertNotFound()
            ->assertSee('Oops! Court Not Found');
    }
}
