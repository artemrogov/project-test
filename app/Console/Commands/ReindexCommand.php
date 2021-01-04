<?php

namespace App\Console\Commands;

use App\Models\Document;
use Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $elasticsearch)
    {
        parent::__construct();
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Переиндексация поиска для elasticsearch');

        foreach (Document::cursor() as $document){
            $this->elasticsearch->index([
               'index'=>$document->getSearchIndex(),
               'type'=>$document->getSearchType(),
               'id'=>$document->getKey(),
               'body'=>$document->toSearchArray()
            ]);
            $this->output->write('.');
        }

        $this->info('\nDone');

        return 0;
    }
}
