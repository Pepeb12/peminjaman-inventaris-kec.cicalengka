<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->trustProxies(at: '*');
        $middleware->validateCsrfTokens(except: [
            'logout',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->renderable(function (PostTooLargeException $e, Request $request) {
            return back()->with('error', 'Ukuran file yang diunggah terlalu besar. Silakan gunakan file dengan ukuran maksimal 2MB.');
        });

        $exceptions->renderable(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 419) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => 'Sesi Anda telah berakhir. Silakan login kembali.',
                        'redirect' => route('login'),
                    ], 419);
                }

                return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
            }
        });

        $exceptions->renderable(function (TokenMismatchException $e, Request $request) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Sesi Anda telah berakhir. Silakan login kembali.',
                    'redirect' => route('login'),
                ], 419);
            }

            return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
        });
    })->create();
