<?php

namespace App\Providers;

use App\Models\Deal;
use App\Models\CommissionShare;
use App\Models\Document;
use App\Models\FollowUp;
use App\Observers\ActivityObserver;
use App\Observers\CommissionShareObserver;
use App\Observers\DealObserver;
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
        Deal::observe(DealObserver::class);
        Deal::observe(ActivityObserver::class);
        FollowUp::observe(ActivityObserver::class);
        Document::observe(ActivityObserver::class);
        CommissionShare::observe(CommissionShareObserver::class);
    }
}
