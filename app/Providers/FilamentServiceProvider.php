<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Filament::serving(function () {
            if (auth()->check() && !auth()->user()->canAccessFilament()) {
                abort(403);
            }
        });
        
        
    }
}
