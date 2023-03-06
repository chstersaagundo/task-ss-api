<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $priority = $this->faker->randomElement(['P4', 'P3', 'P2', 'P1']);
        $status = $this->faker->randomElement(['completed', 'pending', 'abandoned']);

        return [
            'category_id' => Category::factory(),
            'task_type_id' => $this->faker->randomElement(['1', '2']),
            'task_name' => $this->faker->word(),
            'task_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'is_starred' => $this->faker->boolean(),
            'priority' => $priority,
            'status' => $status,
            'start_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'end_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'start_time' => $this->faker->time($format = 'H:i:s', $max = 'now'),
            'end_time' => $this->faker->time($format = 'H:i:s', $max = 'now')

        ];
    }
}
