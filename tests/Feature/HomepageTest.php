<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_homepage_returns_to_dashboard(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('dashboard');
    }
}
