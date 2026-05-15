<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * Root template
     */
    protected $rootView = 'app';

    /**
     * Asset version
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Shared props
     */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),

            /*
            |--------------------------------------------------------------------------
            | AUTH USER
            |--------------------------------------------------------------------------
            */
            'auth' => [
                'user' => $request->user(),
            ],

            /*
            |--------------------------------------------------------------------------
            | FLASH MESSAGES
            |--------------------------------------------------------------------------
            */
            'flash' => [
                'success' => session('success'),
                'error' => session('error'),
            ],

            /*
            |--------------------------------------------------------------------------
            | CSRF TOKEN
            |--------------------------------------------------------------------------
            */
            'csrf_token' => csrf_token(),
        ];
    }
}