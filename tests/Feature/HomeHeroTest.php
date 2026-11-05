<?php

namespace Tests\Feature;

use App\Models\Banner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeHeroTest extends TestCase
{
    use RefreshDatabase;

    public function test_banners_are_shown_whole_with_their_description_and_link(): void
    {
        Banner::query()->create(['title' => 'Players in action under stadium lights', 'image' => 'banners/showcase.png', 'button_text' => 'Register', 'button_url' => '/players/register', 'sort_order' => 1]);
        Banner::query()->create(['title' => 'East Zone Championship team photo', 'image' => 'banners/team.jpg', 'sort_order' => 2]);

        $this->get(route('frontend.home'))
            ->assertOk()
            ->assertSeeInOrder(['id="hero-title"', 'Players in action under stadium lights', 'East Zone Championship team photo'], false)
            ->assertSee('alt="Players in action under stadium lights"', false)
            ->assertSee('src="/storage/banners/showcase.png"', false)
            ->assertSee('href="/players/register"', false)
            ->assertSee('<span class="visually-hidden">Register</span>', false)
            ->assertSee('aria-label="Show banner 2 of 2"', false)
            ->assertSee('aria-label="Next banner"', false);
    }

    public function test_a_single_banner_has_no_slider_controls(): void
    {
        Banner::query()->create(['title' => 'Players in action under stadium lights', 'image' => 'banners/showcase.png']);

        $this->get(route('frontend.home'))
            ->assertOk()
            ->assertSee('data-hero-slider', false)
            ->assertDontSee('data-hero-dot', false)
            ->assertDontSee('aria-label="Next banner"', false);
    }

    public function test_the_brand_plate_is_shown_until_a_banner_is_published(): void
    {
        Banner::query()->create(['title' => 'Hidden draft banner', 'image' => 'banners/draft.png', 'is_published' => false]);

        $this->get(route('frontend.home'))
            ->assertOk()
            ->assertSee('hero-media-plate', false)
            ->assertDontSee('data-hero-slider', false)
            ->assertDontSee('Hidden draft banner');
    }
}
