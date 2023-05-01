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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('subscriptions_user_id_foreign');
            $table->unsignedBigInteger('subscription_type_id')->index('subscriptions_subscription_type_id_foreign');
            $table->string('status', 50);
            $table->date('end_date', $precision = 0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('cascade');
            $table->foreign('subscription_type_id')->references('id')->on('subscription_types')->onUpdate('NO ACTION')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};