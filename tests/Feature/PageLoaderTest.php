<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageLoaderTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_home_page_shows_the_loader(): void
    {
        $this->get(route('frontend.home'))
            ->assertOk()
            ->assertSee('id="page-loader"', false);
    }

    public function test_other_pages_do_not_show_the_loader(): void
    {
        $this->get(route('frontend.office-bearers.national'))
            ->assertOk()
            ->assertDontSee('id="page-loader"', false);
    }
}
