<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MarketingEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $content;

    public $image;

    public $button_text;
    public $button_url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title, $content, $image = null, $button_text = null, $button_url = null)
    {
        $this->title = $title;
        $this->content = $content;
        
        $this->image = $image;
        
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
        return $this->view('emails.marketing')
            ->subject($this->title)->with([
                'content' => $this->content,
                'image' => $this->image,
                'button_text' => $this->button_text,
                'button_url' => $this->button_url,
            ]);
    }
}
