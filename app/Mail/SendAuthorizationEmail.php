<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendAuthorizationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $name;
    public $producto;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code, $name, $producto)
    {
        $this->code = $code;
        $this->name = $name;
        $this->producto = $producto;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.authorization')
            ->subject('Se requiere autorización para '.$this->name)->with([
                'producto' => $this->producto,
                'code' => $this->code,
                'name' => $this->name,
            ]);
    }
}
