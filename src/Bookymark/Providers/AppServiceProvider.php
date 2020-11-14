<?php

declare(strict_types=1);

namespace Bookymark\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /** {@inheritdoc} */
    public function register()
    {
        // intentionally blank
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // intentionally blank
    }
}
