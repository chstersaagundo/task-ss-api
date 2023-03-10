<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        
        $this->call([
            RoleSeeder::class
        ]);
        $this->call([
            TaskTypeSeeder::class
        ]);

        $users = \App\Models\User::factory()->count(2)->create();

        foreach ($users as $user) {
            $categories = \App\Models\Category::factory()->count(2)->create([
                'user_id' => $user->id
            ]);
    
            foreach ($categories as $category) {
                \App\Models\Task::factory()->count(2)->create([
                    'category_id' => $category['id'],
                    'user_id' => $user->id
                ]);
            }
        }

        $this->call([
            BlockWebsiteSeeder::class
        ]);
    }
}
