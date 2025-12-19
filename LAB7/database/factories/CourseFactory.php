<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'summary' => $this->faker->paragraph,
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'start_date' => $this->faker->date(),
            'seats' => $this->faker->numberBetween(10, 50),
        ];
    }
}
