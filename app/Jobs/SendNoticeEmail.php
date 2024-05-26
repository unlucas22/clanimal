<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\{Alert, User};
use App\Mail\NoticeEmail;
use Mail;

class SendNoticeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Alert $alert;
    public $user_email;
    public $button_url;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($alert_id, $user_id, $tracking)
    {
        $this->alert = Alert::where('id', $alert_id)->first();
        $this->user_email = (User::where('id', $user_id)->first())->email;

        $this->button_url = route('show.paquete', [
            'hashid' => $tracking->hashid,
        ]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if($this->alert->email)
        {
            $email_view = new NoticeEmail($this->alert->title, $this->alert->message, $this->button_url, $this->alert->button_text);

            Mail::to($this->user_email)->send($email_view);
        }
    }
}
