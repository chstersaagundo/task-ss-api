<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $color = $this->faker->randomElement(['100', '200', '300', '400', '500']);

        return [
            'user_id' => User::factory(),
            'category_name' => $this->faker->word(),
            'category_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'color' => $color
        ];
    }
}
