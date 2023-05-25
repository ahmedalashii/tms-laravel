<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TrainingAttendance>
 */
class TrainingAttendanceFactory extends Factory
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
            'attendance_day' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'][rand(0, 6)],
            'start_time' => $this->faker->time(),
            'end_time' => $this->faker->time(strtotime($this->faker->time()) + 3600),
        ];
    }
}
