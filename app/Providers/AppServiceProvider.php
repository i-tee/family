<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        View::share('globalVariable', 'Это значение доступно во всех шаблонах!');

        // Добавляем глобальную переменную с деревьями пользователя
        View::composer('*', function ($view) {
            $user = Auth::user();
            $trees = $user ? $user->getTrees() : collect();
            $view->with('userTrees', $trees);
        });

    }
}
