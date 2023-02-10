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
            $table->integer('category_id');
            $table->string('task_name', 100);
            $table->string('task_desc', 255)->nullable();
            $table->boolean('is_starred');
            $table->string('priority', 50);
            $table->string('status', 50);
            $table->date('start_date', $precision = 0);
            $table->date('end_date', $precision = 0);
            $table->time('start_time', $precision = 0);
            $table->time('end_time', $precision = 0);

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
        Schema::dropIfExists('tasks');
    }
};
