<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Show authenticated user.
     */
    public function show(Request $request): UserResource
    {
        /** @var User $user */
        $user = $request->user();

        if (!$user->hasVerifiedEmail()) {
            abort(409, 'You must verify your email address.');
        }

        $user->load('organization');

        return new UserResource($user);
    }
}
