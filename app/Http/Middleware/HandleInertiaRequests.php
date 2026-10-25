<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = function_exists('current_user') ? current_user() : null;

        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user ? Arr::except($user, ['password']) : null,
            ],
            'flash' => [
                'sukses' => $request->session()->get('sukses'),
                'galat' => $request->session()->get('galat'),
            ],
        ];
    }
}
