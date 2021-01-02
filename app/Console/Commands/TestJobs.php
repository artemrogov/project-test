<?php

namespace App\Console\Commands;

use App\Jobs\TestJob1;
use App\Jobs\TestJob2;
use Carbon\Carbon;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;


class TestJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:files';

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
     */
    public function handle()
    {
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

        $nameArchive = Carbon::now()->format('d_m_Y_H_i_s');

        $zipFile = new \PhpZip\ZipFile();
        $zipFile->addDir(base_path('storage/app/public/users'))
            ->saveAsFile("public/{$nameArchive}.zip")->close();

        return 0;
    }
}
