<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomepageTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testHomepageReturnsToDashboard(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('dashboard');
    }
}
