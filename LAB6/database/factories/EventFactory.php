<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\EventTypeEnum;
use App\Models\Organizer;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3, true),
            'description' => $this->faker->paragraph(),
            'type' => $this->faker->randomElement(EventTypeEnum::cases())->value,
            'organizer_id' => null,
            'date' => $this->faker->dateTimeBetween('now', '+1 year'),
        ];
    }
}
