<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {

        $numbersUser = User::count();

        return [
            'title' => $this->faker->sentence('3'),
            'description' => $this->faker->paragraph(),
            'deadline' => $this->faker->dateTimeBetween('now', '+1 month'),
            'priority' => $this->faker->randomElement(Task::PRIORITY),
            'status' => $this->faker->randomElement(Task::STATUS),
            'user_id' => $this->faker->randomNumber(1, $numbersUser),

        ];
    }
}
