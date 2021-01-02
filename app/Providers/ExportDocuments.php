<?php

namespace App\Providers;

use App\Contracts\ExportContractInterface;
use App\Services\JsonDocument;
use Illuminate\Support\ServiceProvider;

class ExportDocuments extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ExportContractInterface::class,JsonDocument::class);
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
