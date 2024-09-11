<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadUserData
{
    public function handle($request, Closure $next): Response
    {
        $user = get_user();
        $contact = app(\App\Http\Controllers\ProfileController::class)->getContact();

        // Share data across all views
        View::share(compact('user', 'contact'));

        return $next($request);
    }
}
