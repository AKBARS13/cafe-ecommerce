<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\CafeSetting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force HTTPS di production
        if (env('APP_ENV') === 'production' || request()->header('x-forwarded-proto') === 'https') {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }

        // Share cafe setting ke semua view
        View::composer('*', function ($view) {
            try {
                $view->with('cafeSetting', CafeSetting::current());
            } catch (\Exception $e) {
                $view->with('cafeSetting', null);
            }
        });
    }
}