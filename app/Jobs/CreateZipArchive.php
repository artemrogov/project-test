<?php

namespace App\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CreateZipArchive implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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

        //$nameArchive = Carbon::now()->format('d_m_Y_H_i_s');
        $zipFile = new \PhpZip\ZipFile();
        $zipFile->addDir(base_path('storage/app/public/users'))
            ->saveAsFile("public/users.zip")->close();
    }
}
