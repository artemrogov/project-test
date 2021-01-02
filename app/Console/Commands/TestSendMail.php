<?php

namespace App\Console\Commands;

use App\Mail\SendUsers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestSendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:test';

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

        // простая отправка:
        //Mail::to(User::query()->first())->send(new SendUsers('тестовое письмо!'));

        //Mail::to(User::query()->where('id',2)->first())
            //->bcc(User::query()->whereIn('id',[16,17])->get())
            //->send(new SendUsers('тестовое письмо 2'));

        //Mail::to(User::query()->where('id',2)->first())
            //->queue(new SendUsers('queue test send email'));

        $when = now()->addSeconds(30);

        Mail::to(User::query()->where('id',2)->first())
        ->later($when,new SendUsers('later test mail!'));

        return 0;
    }
}
