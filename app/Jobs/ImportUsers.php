<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ImportUsers implements ShouldQueue
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

        $dir = Storage::disk('public')->exists('/users');

        if(!$dir){
            Storage::disk('public')->makeDirectory('/users');
        }

        DB::table('users')->orderBy('id')
            ->chunk(100,function ($users){
                foreach ($users as $user) {
                    Storage::disk('public')
                        ->put("users/{$user->email}.json",
                            json_encode($user));
                }
            });
    }
}
