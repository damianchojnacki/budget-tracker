<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocsController extends Controller
{
    public function __invoke(Request $request, string $path = 'index.html'): Response
    {
        if (!Storage::disk('docs')->exists($path)) {
            abort(404);
        }

        return response(Storage::disk('docs')->get($path), 200, [
            'Content-Type' => static::getMimeType(Storage::disk('docs')->path($path)),
        ]);
    }

    protected static function getMimeType(string $path): string|false
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);

        if (Str::startsWith($extension, 'svg')) {
            return 'image/svg+xml';
        }

        if (Str::startsWith($extension, 'css')) {
            return 'text/css';
        }

        return mime_content_type($path);
    }
}
