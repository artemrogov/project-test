<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUsers extends Mailable
{

    use Queueable, SerializesModels;

    public $title;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $title = $this->title;
        return $this
            ->subject('Тестовый заголовк письма')
            ->view('test',compact('title'))
            ->attach('public/test_zip_extract/test_image4.jpg',
                ['mime'=>'image/jpg','as'=>'test_image4.jpg']);
    }
}