<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
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
