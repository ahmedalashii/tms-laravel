<?php

namespace Database\Factories;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingProgram>
 */
class TrainingProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'discipline_id' => Discipline::factory(),
            'description' => $this->faker->text(),
            'duration' => $this->faker->numberBetween(1, 5),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
        ];
    }
}
