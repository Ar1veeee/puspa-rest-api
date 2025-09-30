<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            $email = $request->input('email') ?: $request->input('identifier');

            return [
                Limit::perMinute(5)
                    ->by($email . '|' . $request->ip())
                    ->response(function () {
                        return response()->json([
                            'success' => false,
                            'message' => 'Terlalu banyak percobaan login. Coba lagi dalam 1 menit.'
                        ], 429);
                    }),

                Limit::perMinute(10)
                    ->by($request->ip())
                    ->response(function () {
                        return response()->json([
                            'success' => false,
                            'message' => 'Terlalu banyak percobaan login dari IP ini.'
                        ], 429);
                    }),
            ];
        });

        RateLimiter::for('register', function (Request $request) {
            return [
                Limit::perHour(3)
                    ->by($request->ip())
                    ->response(function () {
                        return response()->json([
                            'success' => false,
                            'message' => 'Terlalu banyak registrasi dari IP ini. Coba lagi nanti.'
                        ], 429);
                    }),

                Limit::perDay(5)->by($request->ip()),
            ];
        });

        RateLimiter::for('forgot-password', function (Request $request) {
            $email = $request->input('email');

            return [
                Limit::perMinutes(5, 1)
                    ->by($email)
                    ->response(function () {
                        return response()->json([
                            'success' => false,
                            'message' => 'Tunggu 5 menit sebelum meminta reset password lagi.'
                        ], 429);
                    }),

                Limit::perHour(3)
                    ->by($request->ip())
                    ->response(function () {
                        return response()->json([
                            'success' => false,
                            'message' => 'Terlalu banyak permintaan reset password dari IP ini.'
                        ], 429);
                    }),
            ];
        });

        RateLimiter::for('reset-password', function (Request $request) {
            $token = $request->input('token');

            return [
                // Max 3 attempts per token (mencegah brute force token)
                Limit::perMinute(3)
                    ->by($token . '|' . $request->ip())
                    ->response(function () {
                        return response()->json([
                            'success' => false,
                            'message' => 'Terlalu banyak percobaan reset password.'
                        ], 429);
                    }),
            ];
        });

        RateLimiter::for('verification-resend', function (Request $request) {
            $email = $request->input('email');

            return [
                // Max 1 request per email per 2 menit
                Limit::perMinutes(2, 1)
                    ->by($email)
                    ->response(function () {
                        return response()->json([
                            'success' => false,
                            'message' => 'Tunggu 2 menit sebelum mengirim ulang email verifikasi.'
                        ], 429);
                    }),

                // Max 5 request per IP per jam
                Limit::perHour(5)->by($request->ip()),
            ];
        });

        RateLimiter::for('verification', function (Request $request) {
            // Max 10 attempts per IP per menit (mencegah automated clicking)
            return Limit::perMinute(10)
                ->by($request->ip())
                ->response(function () {
                    return response()->json([
                        'success' => false,
                        'message' => 'Terlalu banyak percobaan verifikasi.'
                    ], 429);
                });
        });

        RateLimiter::for('logout', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('authenticated', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()->id);
        });

        RateLimiter::for('admin', function (Request $request) {
            return Limit::perMinute(100)->by($request->user()->id);
        });

        RateLimiter::for('therapist', function (Request $request) {
            return Limit::perMinute(100)->by($request->user()->id);
        });
    }
}
