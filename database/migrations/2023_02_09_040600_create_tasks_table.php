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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->index('tasks_category_id_foreign');
            $table->unsignedBigInteger('task_type_id')->index('tasks_types_task_type_id_foreign');
            $table->unsignedBigInteger('user_id')->index('tasks_user_id_foreign');
            $table->string('task_name', 100);
            $table->string('task_desc', 255)->nullable();
            $table->boolean('is_starred');
            $table->string('priority', 50);
            $table->string('status', 50);
            $table->date('start_date', $precision = 0);
            $table->date('end_date', $precision = 0)->nullable();
            $table->time('start_time', $precision = 0);
            $table->time('end_time', $precision = 0)->nullable();
            
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('NO ACTION')->onDelete('cascade');
            $table->foreign('task_type_id')->references('id')->on('task_types')->onUpdate('NO ACTION')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
