<?php

namespace App\Providers;

use App\RepositoryFiles\FilesRepository;
use App\RepositoryFiles\FileStorageInterface;
use Illuminate\Support\ServiceProvider;

class FilesCloudProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(
          FileStorageInterface::class,
          FilesRepository::class
        );
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
