<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingProgramTask>
 */
class TrainingProgramTaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'training_program_id' => \App\Models\TrainingProgram::factory(),
            'name' => $this->faker->word(),
            'description' => $this->faker->text(),
            // end date after 20 days from now and before 30 days from now
            'end_date' => $this->faker->dateTimeBetween('+20 days', '+30 days')->format('Y-m-d'),
        ];
    }
}
