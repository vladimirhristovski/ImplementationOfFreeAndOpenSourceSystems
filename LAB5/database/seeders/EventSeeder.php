<?php

namespace Database\Seeders;

use App\Enums\EventTypeEnum;
use App\Models\Organizer;
use App\Models\Event;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $organizers = Organizer::all();

        foreach (range(1, 20) as $index) {
            Event::query()
                ->create([
                    'name' => $faker->name,
                    'description' => $faker->text,
                    'type' => EventTypeEnum::cases()[array_rand(EventTypeEnum::cases())]->value,
                    'organizer_id' => $organizers->random()->id,
                    'date' => $faker->date(),
                ]);
        }
    }
}
