<?php

namespace App\Console\Commands;

use App\Models\Document;
use App\Models\User;
use App\Notifications\TestNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;


class TestNotifyUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:test';

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

        $doc = Document::query()->where('id',10008)->first();

        Notification::send(
            User::query()->where('id',2)->first(),
            new TestNotification($doc)
        );

        return 0;
    }
}
