<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Events\DiagnosingHealth;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HealthCheckController
 */
class HealthCheckControllerTest extends TestCase
{
    public function testHealthCheckReturnsHtml(): void
    {
        $this->get(route('up'))
            ->assertSuccessful()
            ->assertSeeText('Application up');
    }

    public function testHealthCheckReturnsJson(): void
    {
        $this->getJson(route('up'))
            ->assertSuccessful()
            ->assertJson(['status' => 'ok']);
    }

    public function testHealthCheckDispatchesDiagnosingHealthEvent(): void
    {
        Event::fake([
            DiagnosingHealth::class
        ]);

        $this->getJson(route('up'))
            ->assertSuccessful();

        Event::assertDispatched(DiagnosingHealth::class);
    }
}
