<?php

use Illuminate\Support\Facades\Storage;

test('docs are visible in local env', function (): void {
    Storage::fake('docs');

    Storage::disk('docs')->put('index.html', '<h1>Documentation</h1>');
    Storage::disk('docs')->put('css/base.css', '.base { color: #000; }');

    app()->detectEnvironment(static fn (): string => 'local');

    test()
        ->get(route('docs'))
        ->assertSuccessful()
        ->assertSeeText('Documentation');

    test()
        ->get(route('docs', ['path' => 'css/base.css']))
        ->assertSuccessful()
        ->assertHeader('Content-Type', 'text/css; charset=utf-8');
});

test('docs are not visible by guest in production env', function (): void {
    app()->detectEnvironment(static fn (): string => 'production');

    test()
        ->get(route('docs'))
        ->assertForbidden();
});

test('docs return not found if invalid path', function (): void {
    app()->detectEnvironment(static fn (): string => 'local');

    test()
        ->get(route('docs', ['path', 'invalid']))
        ->assertNotFound();
});
