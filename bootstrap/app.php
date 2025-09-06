<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RoleMiddleware; // ✅ Add this if needed
use App\Http\Middleware\CheckSubscription; // ✅ Add this if needed
use App\Http\Middleware\RedirectIfSubscriptionInvalid; // ✅ Add this if needed
use App\Http\Middleware\RedirectIfSubscriptionInvalidUsers; // ✅ Add this if needed

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        // ✅ Register route middleware here:
        $middleware->alias([
            'role' => RoleMiddleware::class,
            'check.subscription' => CheckSubscription::class,
            'check.expiredsub' => RedirectIfSubscriptionInvalid::class,
            'check.expiredsubuser' => RedirectIfSubscriptionInvalidUsers::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
