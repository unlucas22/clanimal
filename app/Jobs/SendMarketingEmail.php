<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\MarketingEmail;
use App\Models\{MarketingCampaign, MarketingTracking};
use Illuminate\Support\Facades\{Auth, Log};
use Illuminate\Support\Facades\Mail;
use DB;

class SendMarketingEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $campaigns = MarketingCampaign::with(['marketing_trackings', 'marketing_templates'])
            ->whereDate('fecha', now()->toDateString())
            ->where('status', '!=', 'completado')
            ->get();

        try {
            
            DB::beginTransaction();

            MarketingCampaign::whereIn('id', $campaigns->pluck('id'))->update([
                'status' => 'en proceso',
            ]);

            foreach ($campaigns as $campaign)
            {
                try
                {
                    $title = $campaign->marketing_templates->name;

                    $content = $campaign->marketing_templates->content;

                    $image = $campaign->marketing_templates->image;

                    Log::info(storage_path($image));

                    $button_text = $campaign->marketing_templates->button_text;
                    $button_url = $campaign->marketing_templates->button_url;

                    foreach ($campaign->marketing_trackings as $tracking)
                    {
                        $email_view = new MarketingEmail($title, $content, $image, $button_text, $button_url);

                        Mail::to($tracking->users->email)->send($email_view);
                    }
                }
                catch (\Exception $e)
                {
                    Log::info($e->getMessage());
                }
            }
                
            MarketingCampaign::whereIn('id', $campaigns->pluck('id'))->update([
                'status' => 'completado',
            ]);

            DB::commit();

        } catch (\Exception $e) {
            Log::info($e->getMessage());
            DB::rollback();
        }
    }
}
