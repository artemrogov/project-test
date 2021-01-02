<?php

namespace App\Providers;

use App\Services\Archive;
use App\Services\ArchiveInterface;
use Illuminate\Support\ServiceProvider;

class ArchiveProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArchiveInterface::class,
        Archive::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
