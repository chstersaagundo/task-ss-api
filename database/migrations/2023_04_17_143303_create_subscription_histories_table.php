<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcription_id')->index('subscription_histories_subcription_id_foreign');
            $table->decimal('amount', 12,2);
            $table->date('start_date', $precision = 0);
            $table->date('end_date', $precision = 0);
            $table->timestamps();

            $table->foreign('subcription_id')->references('id')->on('subscriptions')->onUpdate('NO ACTION')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_histories');
    }
};
