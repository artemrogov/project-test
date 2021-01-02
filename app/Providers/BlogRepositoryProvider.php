<?php

namespace App\Providers;

use App\RepositoryBlog\BlogRepository;
use App\RepositoryBlog\BlogRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class BlogRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
          BlogRepositoryInterface::class,
          BlogRepository::class
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
