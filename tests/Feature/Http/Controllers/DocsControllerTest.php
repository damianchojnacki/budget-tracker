<?php

namespace Tests\Feature\Http\Controllers;

use App\Http\Controllers\DocsController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Storage;
use Tests\TestCase;

/**
 * @see DocsController
 */
class DocsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_docs_are_visible_in_local_env(): void
    {
        Storage::fake('docs');

        Storage::disk('docs')->put('index.html', '<h1>Documentation</h1>');
        Storage::disk('docs')->put('css/base.css', '.base { color: #000; }');

        $this->app->detectEnvironment(static function () {
            return 'local';
        });

        $this->get(route('docs'))
            ->assertSuccessful()
            ->assertSeeText('Documentation');

        $this->get(route('docs', ['path' => 'css/base.css']))
            ->assertSuccessful()
            ->assertHeader('Content-Type', 'text/css; charset=UTF-8');
    }

    public function test_docs_are_not_visible_by_guest_in_production_env(): void
    {
        $this->app->detectEnvironment(static function () {
            return 'production';
        });

        $this->get(route('docs'))
            ->assertForbidden();
    }

    public function test_docs_return_not_found_if_invalid_path(): void
    {
        $this->app->detectEnvironment(static function () {
            return 'local';
        });

        $this->get(route('docs', ['path', 'invalid']))
            ->assertNotFound();
    }
}
