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
        Schema::create('block_websites', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('block_websites_user_id_foreign');
            $table->string('website_link', 255);
            $table->string('website_name', 255);
            $table->boolean('is_include')->default(true);
            
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('block_websites');
    }
};
