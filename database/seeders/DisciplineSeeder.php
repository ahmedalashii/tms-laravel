<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DisciplineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        // Add these disciplines to the database
        $disciplines = [
            'Web Development',
            'Mobile Development',
            'Software Development',
            'Database Administration',
            'Data Science',
            'Artificial Intelligence',
            'Machine Learning',
            'Cyber Security',
            'Cloud Computing',
            'Network Administration',
            'Game Development',
            'DevOps',
        ];
        foreach ($disciplines as $discipline) {
            \App\Models\Discipline::factory()->create([
                'name' => $discipline,
                'description' => $faker->sentence(),
            ]);
        }
    }
}
