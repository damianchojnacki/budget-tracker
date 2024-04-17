<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View as ViewResponse;
use Illuminate\Foundation\Events\DiagnosingHealth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\View;

class HealthCheckController extends Controller
{
    public function __invoke(Request $request): ViewResponse|JsonResponse
    {
        Event::dispatch(new DiagnosingHealth);

        if ($request->wantsJson()) {
            return $this->json([
                'status' => 'ok'
            ]);
        }

        return View::file(base_path('/vendor/laravel/framework/src/Illuminate/Foundation/resources/health-up.blade.php'));
    }
}
