<?php

namespace Database\Seeders;

use App\Models\TrainingProgram;
use Illuminate\Database\Seeder;
use App\Models\TrainingProgramTask;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrainingProgramTaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // For each training program, check the name of this training program and give 3 tasks to it >> swich case
        $trainingPrograms = TrainingProgram::all();

        foreach ($trainingPrograms as $trainingProgram) {
            $tasks = [];
            switch ($trainingProgram->name) {
                case 'JavaScript Fundamentals':
                    $tasks = [
                        [
                            'name' => 'Learn how to use a content management system (CMS) like WordPress or Drupal.',
                            'description' => 'A CMS is a software application that helps you create and manage a website without having to know how to code.',
                        ],
                        [
                            'name' => 'Learn how to use a web development framework like Laravel or Symfony.',
                            'description' => 'A web development framework is a collection of pre-written code that can help you speed up the development of your website.',
                        ],
                        [
                            'name' => 'Learn how to use a version control system like Git or Mercurial.',
                            'description' => 'A version control system is a way to track changes to your code over time. This can be helpful if you ever need to revert to a previous version of your code or collaborate with other developers on a project.',
                        ],
                        [
                            'name' => 'Learn how to deploy a website to a production server.',
                            'description' => 'A production server is a computer that hosts your website so that it can be accessed by the public.',
                        ],
                        [
                            'name' => 'Learn how to optimize a website for search engines.',
                            'description' => 'Search engine optimization (SEO) is the process of improving the ranking of a website in search engine results pages (SERPs).',
                        ],
                    ];
                    break;
                case 'Android App Development for Beginners':
                    $tasks = [
                        [
                            'name' => 'Create a simple mobile app using React Native. The app should have a home screen and a settings screen.',
                            'description' => 'The app should be responsive and work on all screen sizes.',
                        ],
                        [
                            'name' => 'Learn how to use a mobile development framework like React Native or Flutter.',
                            'description' => 'A mobile development framework is a collection of pre-written code that can help you speed up the development of your mobile app.',
                        ],
                        [
                            'name' => 'Learn how to use a version control system like Git or Mercurial.',
                            'description' => 'A version control system is a way to track changes to your code over time. This can be helpful if you ever need to revert to a previous version of your code or collaborate with other developers on a project.',
                        ],
                        [
                            'name' => 'Learn how to deploy a mobile app to the App Store or Google Play.',
                            'description' => 'The App Store and Google Play are the two major app stores where you can distribute your mobile app.',
                        ],
                    ];
                    break;
                default:
                    break;
            }

            foreach ($tasks as $task) {
                TrainingProgramTask::factory()->create([
                    'training_program_id' => $trainingProgram->id,
                    'name' => $task['name'],
                    'description' => $task['description'],
                    'end_date' => now()->addDays(rand(5, 30))->format('Y-m-d'),
                ]);
            }
        }
    }
}
