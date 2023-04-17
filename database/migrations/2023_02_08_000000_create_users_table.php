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
        Schema::create('users', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id')->index('users_role_id_foreign');
            $table->string('firstname', 100);
            $table->string('lastname', 100);
            $table->string('password', 225);
            $table->string('email')->unique();
            $table->string('phone', 20);
            $table->boolean('trial_card')->default(true);
            $table->boolean('is_verified')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('NO ACTION')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
