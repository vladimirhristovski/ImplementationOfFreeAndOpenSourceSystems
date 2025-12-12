<?php

namespace App\Providers;

use App\Models\Organizer;
use App\Observers\OrganizerObserver;
use App\Models\Event;
use App\Observers\EventObserver;
use App\Repositories\OrganizerRepository;
use App\Repositories\OrganizerRepositoryInterface;
use App\Repositories\EventRepository;
use App\Repositories\EventRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(OrganizerRepositoryInterface::class, OrganizerRepository::class);
        $this->app->singleton(EventRepositoryInterface::class, EventRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Organizer::observe(OrganizerObserver::class);
        Event::observe(EventObserver::class);
    }
}
