<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // For each training program, create 3 to 5 training attendances
        \App\Models\TrainingProgram::all()->each(function (\App\Models\TrainingProgram $trainingProgram) use ($faker) {
            for ($i = 0; $i < 3; $i++) {
                $start_time = $faker->time('H:i:s');
                // take $start_time hour of the day and add 1 hour to it
                // this will be the end time of the training attendance
                $end_time = date('H:i:s', strtotime($start_time) + 3600);
                $day = $faker->dayOfWeek();
                $exists = \App\Models\TrainingAttendance::where('attendance_day', $day)
                    ->where('training_program_id', $trainingProgram->id)
                    ->exists();
                if (!$exists) {
                    \App\Models\TrainingAttendance::factory()->create([
                        'training_program_id' => $trainingProgram->id,
                        'attendance_day' => $day,
                        'start_time' => $start_time,
                        'end_time' => $end_time,
                    ]);
                } else {
                    $i--;
                    continue;
                }
            }
        });
    }
}
