<?php

namespace App\Providers;

use App\Http\View\Composers\HomePageComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('menu', HomePageComposer::class);
        $currency = config('currency.default');
        view()->share('currencySymbol', config("currency.currencies.$currency.symbol"));
    }
}
