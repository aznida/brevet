<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
            \App\Http\Middleware\ShareAnnouncementsData::class, // Tambahkan middleware baru
        ]);
        $middleware->alias([
            'participant' => \App\Http\Middleware\AuthParticipant::class,
            'check.local.admin' => \App\Http\Middleware\CheckLocalAdmin::class,
            'check.mitra' => \App\Http\Middleware\CheckMitra::class, // Add this line
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();