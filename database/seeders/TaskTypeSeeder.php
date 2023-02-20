<?php

namespace Database\Seeders;

use App\Models\TaskType;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        TaskType::create([
            'task_type_name' => 'to do list',
            'task_type_desc' => 'To Do List'
        ]);

        TaskType::create([
            'task_type_name' => 'to be done',
            'task_type_desc' => 'To Be Done'
        ]);
    }
}
