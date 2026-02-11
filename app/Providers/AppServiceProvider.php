<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Memorial;
use App\Models\Photo;
use App\Models\Tribute;
use App\Policies\MemorialPolicy;
use App\Policies\PhotoPolicy;
use App\Policies\TributePolicy;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Memorial::class, MemorialPolicy::class);
        Gate::policy(Tribute::class, TributePolicy::class);
        Gate::policy(Photo::class, PhotoPolicy::class);

        Blade::if('subscribed', function () {
            return auth()->check() && auth()->user()->isPremium();
        });
    }
}
