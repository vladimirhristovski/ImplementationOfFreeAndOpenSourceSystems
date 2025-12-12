<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Organizer;

class OrganizerFactory extends Factory
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organizer::factory(10)->create();
    }
}
