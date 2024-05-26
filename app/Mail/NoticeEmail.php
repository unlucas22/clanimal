<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoticeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $message;
    public $button_text;
    public $button_url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $message, $button_url, $button_text)
    {
        $this->title = $title;
        $this->message = $message;
        $this->button_text = $button_text;
        $this->button_url = $button_url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.default')
            ->subject($this->title)->with([
                'title' => $this->title,
                'message' => $this->message,
                'button_text' => $this->button_text,
                'button_url' => $this->button_url,
            ]);
    }
}
