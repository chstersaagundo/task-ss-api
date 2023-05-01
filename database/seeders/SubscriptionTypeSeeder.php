<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SubscriptionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SubscriptionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        SubscriptionType::create([
            'sub_type_name' => 'pro',
            'sub_type_desc' => 'Pro Subscription',
            'interval' => 'month',
            'sub_fee_price' => '500.00',
        ]);

        SubscriptionType::create([
            'sub_type_name' => 'pro',
            'sub_type_desc' => 'Pro Subscription',
            'interval' => 'year',
            'sub_fee_price' => '6000.00',
        ]);

        // SubscriptionType::create([
        //     'sub_type_name' => 'user',
        //     'sub_type_desc' => 'user',
        //     'sub_fee_price' => '',
        // ]);
    }
}