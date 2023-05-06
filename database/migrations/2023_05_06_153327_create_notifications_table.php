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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index('notifications_user_id_foreign');
            $table->unsignedBigInteger('task_id')->index('notifications_task_id_foreign');
            $table->string('description', 255)->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('display')->default(0);
            $table->datetime('triggerdate', $precision = 0);
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('cascade');
            $table->foreign('task_id')->references('id')->on('tasks')->onUpdate('NO ACTION')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
