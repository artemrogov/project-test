<?php

namespace App\Providers;

use App\Contracts\DocumentInterface;
use App\DocumentsRepository\DocumentsRepositories;
use App\DocumentsRepository\ElasticsearchRepository;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;


class DocumentsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DocumentInterface::class,function($app){

            if(!config('services.search.enabled')){
               return new DocumentsRepositories();
           }

           return new ElasticsearchRepository(
             $app->make(Client::class)
           );

        });

        $this->bindSearchClient();

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

    private function bindSearchClient()
    {
        $this->app->bind(Client::class,function($app){
           return ClientBuilder::create()->setHosts($app['config']
               ->get('services.search.hosts'))->build();
        });
    }

}
