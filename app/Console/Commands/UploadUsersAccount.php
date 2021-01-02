<?php

namespace App\Console\Commands;

use App\Jobs\CreateZipArchive;
use App\Jobs\ImportUsers;
use Illuminate\Bus\Batch;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Throwable;

/**
 * Выгрузка пользовательских аккаунтов и упокавока их в zip архив
 * Class UploadUsersAccount
 * @package App\Console\Commands
 */
class UploadUsersAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'upload:users';

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
        Bus::batch([
          new ImportUsers,
          new CreateZipArchive,
        ])->then(function (Batch $batch){
            Storage::disk('public')->deleteDirectory('/users');
            Log::info("ЗАДАНИЕ ЗАВЕРШЕНО успешно:{$batch->id} {$batch->name}");
            return 0;
        })->catch(function(Batch $batch, Throwable $e){
            Log::debug("ЗАДАНИЕ ПРОВАЛЕНО:");
            return -1;
        })->finally(function (Batch $batch){
            return 0;
        })->dispatch();

        return 0;
    }
}
