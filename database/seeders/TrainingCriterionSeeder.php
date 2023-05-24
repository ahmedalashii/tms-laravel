<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingCriterionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
            The following criteria are used to review training requests:
                Trainee's academic background
                Trainee's work experience
                Trainee's financial need
                The availability of training programs
         */

        $criteria = [
            'Trainee\'s academic background',
            'Trainee\'s work experience',
            'Trainee\'s financial need',
            'The availability of training programs',
            "Did he pay the fees or not?",
        ];

        foreach ($criteria as $criterion) {
            \App\Models\TrainingCriterion::factory()->create([
                'name' => $criterion,
            ]);
        }
    }
}
