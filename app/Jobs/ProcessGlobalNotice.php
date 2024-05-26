<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\{User, Notice};

class ProcessGlobalNotice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $alert_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($alert_id)
    {
        $this->alert_id = $alert_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        User::chunk(100, function ($users) {
            $data = [];

            foreach ($users as $user)
            {
                $data[] = [
                    'alert_id' => $this->alert_id,
                    'user_id' => $user->id
                ];
            }

            Notice::insert($data);
        });
    }
}
