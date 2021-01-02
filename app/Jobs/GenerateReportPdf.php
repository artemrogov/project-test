<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class GenerateReportPdf implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $param1;

    public $param2;

    public $param3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($param1,$param2,$param3)
    {
        $this->param1 = $param1;
        $this->param2 = $param2;
        $this->param3 = $param3;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->batch()->canceled()){
            Log::info("пакетное задание было отменено");
            return;
        }


        $arr = [
          'param1'=>$this->param1, 'param2'=>$this->param1,'param3'=>$this->param3,
        ];

        DB::table('values_test')->insert($arr);

    }
}
