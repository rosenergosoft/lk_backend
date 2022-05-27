<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewApplication extends Mailable
{
    use Queueable, SerializesModels;

    protected $url;
    protected $userName;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url, $userName)
    {
        $this->url = $url;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.newapplication', [
            'url' => $this->url,
            'userName' => $this->userName
        ]);
    }
}

