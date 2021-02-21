<?php

namespace App\Console\Commands;

use App\Mail\SendUsers;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendMailerUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:users';

    private $limit = 10;

    private $offset = 0;

    private $debug = false;

    const SECONDS = 10;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Рассылка пользователям';

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
        while ($users = $this->getUsersAccount())
        {
            $this->sendEmailAddressRecipient($users);
            sleep(self::SECONDS);
            Log::info('################end time mailer######################');
        }

        return 0;
    }


    protected function sendEmailAddressRecipient($users)
    {
        $data = $this->extractEmail($users);

        foreach($data as $email){
            Log::info($email);
            $this->sendMailUEmails($email);
        }
    }

    public function extractEmail($data)
    {
        foreach($data as $item){
            yield $item->email => $item->email;
        }
    }

    private function sendMailUEmails($email)
    {
        if(!$this->debug){
            Mail::to($email)->queue(new SendUsers('Тестовая рассылка'));
        }else {
            Log::info($email);
        }
    }

    protected function getUsersAccount()
    {
        $data = User::query()->whereBetween('id',[13,41])
            ->offset($this->offset)
            ->limit($this->limit)
            ->orderBy('id')
            ->get();

        $this->offset+=$this->limit;

        return ($data->count() <=0 ) ? false : $data;
    }
}
