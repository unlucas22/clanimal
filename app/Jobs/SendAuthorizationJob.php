<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\SendAuthorizationEmail;
use Illuminate\Support\Facades\{Auth, Log};
use App\Models\Role;
use Mail;

class SendAuthorizationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $code;
    public $name;
    public $producto;

    /**
     * Create a new job instance.
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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email_view = new SendAuthorizationEmail($this->code, $this->name, $this->producto);

        $gerentes = Role::with('users')->where('key', 'gerente_general')->get();

        if(count($gerentes))
        {
            foreach ($gerentes as $gerente)
            {
                Mail::to($gerente->users->email)->send($email_view);
            }
        }
        else
        {
            Log::info('no hay gerentes');
        }
    }
}
