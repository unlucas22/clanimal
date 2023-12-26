<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingTrackingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_trackings', function (Blueprint $table) {
            $table->id();

            $table->foreign('marketing_campaign_id')->references('id')->on('marketing_campaigns');
            $table->unsignedBigInteger('marketing_campaign_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id');

            $table->timestamp('open_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marketing_trackings');
    }
}
