<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

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
        if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
            $settings = Setting::pluck('value', 'key')->toArray();
            View::share('settings', $settings);
        }
    }
}

use Illuminate\Support\Facades\URL;

// Force HTTPS in production
if (env('APP_ENV') === 'production' || env('APP_ENV') === 'local') {
    URL::forceScheme('https');
}
