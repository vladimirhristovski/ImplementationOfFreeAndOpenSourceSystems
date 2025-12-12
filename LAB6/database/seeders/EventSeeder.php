<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $organizers = Organizer::all();

        Event::factory()
            ->count(10)
            ->create([
                'organizer_id' => fn() => $organizers->random()->id
            ]);
    }
}
