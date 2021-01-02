<?php

namespace App\Console\Commands;

use App\Events\SaveEventCompanies;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Console\Command;
use PDO;


class RunnerPostgresEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $client;


    protected $signature = 'run:pg-notify';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'run postgres event listener - purchase_changed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = DB::connection()->getPdo();
        parent::__construct();
    }


    public function handle()
    {
        $this->client->exec('LISTEN purchase_changed');

        while(true) {
            while ($result = $this->client->pgsqlGetNotify(PDO::FETCH_ASSOC, 30000)) {
                event(new SaveEventCompanies($result['payload']));
                $this->info('Обработка...');
            }
        }
    }

}
