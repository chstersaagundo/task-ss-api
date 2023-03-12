<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BlockWebsite;

class BlockWebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlockWebsite::create([
            'user_id' => 1,
            'website_link' => 'www.youtube.com',
            'website_name' => 'YouTube',
            'is_include' => true
        ]);

        BlockWebsite::create([
            'user_id' => 1,
            'website_link' => 'www.facebook.com',
            'website_name' => 'Facebook',
            'is_include' => true
        ]);
    }
}
