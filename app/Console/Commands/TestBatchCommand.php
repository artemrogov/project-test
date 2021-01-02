<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\GenerateReportPdf;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class TestBatchCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:batch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Throwable
     */
    public function handle()
    {
        $batch = Bus::batch([
            new GenerateReportPdf(1,2,3),
            new GenerateReportPdf(4,5,6),
            new GenerateReportPdf(5,6,7)
        ])->then(function (Batch $batch){
                $maxParam = DB::table('values_test')->max('param1');
                DB::table('users')->update(['param1'=>$maxParam]);
                Log::info("ЗАДАНИЕ ЗАВЕРШЕНО успешно: {$batch->id} - {$batch->name}");
                return 0;
        })->catch(function(Batch $batch, Throwable $e){
            Log::debug("ЗАДАНИЕ ПРОВАЛЕНО: {$batch->id} - {$batch->name} {$e->getMessage()}");
            return -1;
        })->finally(function (Batch $batch){
            Log::info("ЗАДАНИЕ ЗАВЕРШЕНО!");
            return 0;
        })->dispatch();

        $this->info($batch->id . ' name batch: '.$batch->name);

    }
}
