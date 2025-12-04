<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Repositories\IUserOTPRepository;
use App\Domain\Repositories\IPasswordResetTokenRepository;
use App\Infrastructure\Repositories\EloquentUserRepository;
use App\Infrastructure\Repositories\EloquentUserOTPRepository;
use App\Infrastructure\Repositories\elPasswordResetTokenRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class, 
            EloquentUserRepository::class,
        );
        $this->app->bind(
            IUserOTPRepository::class, 
            EloquentUserOTPRepository::class
        );
        $this->app->bind(
            IPasswordResetTokenRepository::class,
            elPasswordResetTokenRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('otp', function($request) {
            return Limit::perMinute(3)->by($request->input('user_id'));
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
