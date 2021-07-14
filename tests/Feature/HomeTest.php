<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomeTest extends TestCase
{
    /** @test */
    public function the_homepage_shows_my_name_and_tagline()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('David Peach');
        $response->assertSee('a personal digital reboot');
    }
}
