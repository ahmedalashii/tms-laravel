<?php

namespace Database\Seeders;

use App\Models\Discipline;
use App\Models\TrainingProgram;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrainingProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

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
            $disciplineModel = Discipline::where('name', $discipline)->first();

            $trainingPrograms = [];

            switch ($discipline) {
                case 'Web Development':
                    $trainingPrograms = [
                        [
                            'name' => 'Introduction to HTML and CSS',
                            'description' => 'Learn the basics of HTML and CSS for web development.',
                        ],
                        [
                            'name' => 'Responsive Web Design with Bootstrap',
                            'description' => 'Master the skills to create responsive websites using Bootstrap.',
                        ],
                        [
                            'name' => 'JavaScript Fundamentals',
                            'description' => 'Learn the fundamentals of JavaScript programming language.',
                        ],
                    ];
                    break;
                case 'Mobile Development':
                    $trainingPrograms = [
                        [
                            'name' => 'iOS App Development with Swift',
                            'description' => 'Build iOS applications using the Swift programming language.',
                        ],
                        [
                            'name' => 'Android App Development for Beginners',
                            'description' => 'Learn how to develop Android apps using Java or Kotlin.',
                        ],
                        [
                            'name' => 'Cross-Platform Mobile Development',
                            'description' => 'Explore frameworks for building cross-platform mobile applications.',
                        ],
                    ];
                    break;
                case 'Software Development':
                    $trainingPrograms = [
                        [
                            'name' => 'Introduction to Programming Concepts',
                            'description' => 'Learn the basics of programming.',
                        ],
                        [
                            'name' => 'Object-Oriented Programming in Java',
                            'description' => 'Learn the fundamentals of object-oriented programming using Java.',
                        ],
                        [
                            'name' => 'Software Testing and Quality Assurance',
                            'description' => 'Learn how to test and ensure the quality of software.',
                        ],
                        [
                            'name' => 'Agile Software Development Methodologies',
                            'description' => 'Learn about agile software development methodologies.',
                        ],
                    ];
                    break;
                case 'Database Administration':
                    $trainingPrograms = [
                        [
                            'name' => 'Introduction to Relational Databases',
                            'description' => 'Learn the basics of relational databases.',
                        ],
                        [
                            'name' => 'SQL Fundamentals for Database Management',
                            'description' => 'Learn the fundamentals of SQL for database management.',
                        ],
                        [
                            'name' => 'Database Performance Optimization',
                            'description' => 'Learn how to optimize database performance.',
                        ],
                        [
                            'name' => 'Data Backup and Recovery Strategies',
                            'description' => 'Learn how to backup and recover data.',
                        ],
                    ];
                    break;
                case 'Data Science':
                    $trainingPrograms = [
                        [
                            'name' => 'Introduction to Data Analysis with Python',
                            'description' => 'Learn the basics of data analysis with Python.',
                        ],
                        [
                            'name' => 'Exploratory Data Analysis Techniques',
                            'description' => 'Learn how to perform exploratory data analysis.',
                        ],
                        [
                            'name' => 'Machine Learning Algorithms for Data Scientists',
                            'description' => 'Learn the fundamentals of machine learning algorithms.',
                        ],
                        [
                            'name' => 'Data Visualization and Interpretation',
                            'description' => 'Learn how to visualize and interpret data.',
                        ],
                    ];
                    break;
                case 'Artificial Intelligence':
                    $trainingPrograms = [
                        [
                            'name' => 'Introduction to Artificial Intelligence Concepts',
                            'description' => 'Learn the basics of artificial intelligence.',
                        ],
                        [
                            'name' => 'Neural Networks and Deep Learning Basics',
                            'description' => 'Learn the fundamentals of neural networks and deep learning.',
                        ],
                        [
                            'name' => 'Natural Language Processing Fundamentals',
                            'description' => 'Learn the fundamentals of natural language processing.',
                        ],
                        [
                            'name' => 'Computer Vision and Image Recognition',
                            'description' => 'Learn the fundamentals of computer vision and image recognition.',
                        ],
                    ];
                    break;
                case 'Machine Learning':
                    $trainingPrograms = [
                        [
                            'name' => 'Introduction to Machine Learning Algorithms',
                            'description' => 'Learn the basics of machine learning algorithms.',
                        ],
                        [
                            'name' => 'Supervised Learning Techniques',
                            'description' => 'Learn the fundamentals of supervised learning techniques.',
                        ],
                        [
                            'name' => 'Unsupervised Learning and Clustering',
                            'description' => 'Learn the fundamentals of unsupervised learning and clustering.',
                        ],
                        [
                            'name' => 'Model Evaluation and Selection Methods',
                            'description' => 'Learn how to evaluate and select models.',
                        ],
                    ];
                    break;
                case 'Cyber Security':
                    $trainingPrograms = [
                        [
                            'name' => 'Introduction to Cyber Security Principles',
                            'description' => 'Learn the basics of cyber security.',
                        ],
                        [
                            'name' => 'Network Security Fundamentals',
                            'description' => 'Learn the fundamentals of network security.',
                        ],
                        [
                            'name' => 'Ethical Hacking and Penetration Testing',
                            'description' => 'Learn the fundamentals of ethical hacking and penetration testing.',
                        ],
                        [
                            'name' => 'Security Incident Response and Management',
                            'description' => 'Learn how to respond to and manage security incidents.',
                        ],
                    ];
                    break;
                case 'Cloud Computing':
                    $trainingPrograms = [
                        [
                            'name' => 'Introduction to Cloud Computing Concepts',
                            'description' => 'Learn the basics of cloud computing.',
                        ],
                        [
                            'name' => 'Cloud Infrastructure and Deployment Models',
                            'description' => 'Learn the fundamentals of cloud infrastructure and deployment models.',
                        ],
                        [
                            'name' => 'Cloud Storage and Data Management',
                            'description' => 'Learn the fundamentals of cloud storage and data management.',
                        ],
                        [
                            'name' => 'Cloud Security and Compliance',
                            'description' => 'Learn the fundamentals of cloud security and compliance.',
                        ],
                    ];
                    break;
                case 'Network Administration':
                    $trainingPrograms = [
                        [
                            'name' => 'Introduction to Networking Concepts',
                            'description' => 'Learn the basics of networking.',
                        ],
                        [
                            'name' => 'Network Protocols and Routing',
                            'description' => 'Learn the fundamentals of network protocols and routing.',
                        ],
                        [
                            'name' => 'Network Troubleshooting and Performance Optimization',
                            'description' => 'Learn how to troubleshoot and optimize network performance.',
                        ],
                        [
                            'name' => 'Network Security and Firewall Configuration',
                            'description' => 'Learn the fundamentals of network security and firewall configuration.',
                        ],
                    ];
                    break;
                case 'Game Development':
                    $trainingPrograms = [
                        [
                            'name' => 'Introduction to Game Design Principles',
                            'description' => 'Learn the basics of game design.',
                        ],
                        [
                            'name' => 'Game Development with Unity Engine',
                            'description' => 'Learn how to develop games using the Unity engine.',
                        ],
                        [
                            'name' => '2D Game Development using GameMaker Studio',
                            'description' => 'Learn how to develop 2D games using GameMaker Studio.',
                        ],
                        [
                            'name' => 'Game Physics and Artificial Intelligence in Games',
                            'description' => 'Learn the fundamentals of game physics and artificial intelligence in games.',
                        ],
                    ];
                    break;
                case 'DevOps':
                    $trainingPrograms = [
                        [
                            'name' => 'Introduction to DevOps Practices and Principles',
                            'description' => 'Learn the basics of DevOps practices and principles.',
                        ],
                        [
                            'name' => 'Continuous Integration and Deployment Techniques',
                            'description' => 'Learn the fundamentals of continuous integration and deployment techniques.',
                        ],
                        [
                            'name' => 'Infrastructure as Code with Configuration Management Tools',
                            'description' => 'Learn how to use configuration management tools.',
                        ],
                        [
                            'name' => 'Monitoring and Performance Optimization in DevOps',
                            'description' => 'Learn how to monitor and optimize performance in DevOps.',
                        ],
                    ];
                    break;
                default:
                    break;
            }
            foreach ($trainingPrograms as $program) {
                TrainingProgram::factory()->create([
                    'name' => $program['name'],
                    'description' => $program['description'],
                    'discipline_id' => $disciplineModel->id,
                    'duration' => rand(1, 5),
                    'duration_unit' => ['days', 'weeks', 'months', 'years'][rand(0, 3)],
                    'location' => $faker->address(),
                    'fees' => rand(0, 100),
                    'start_date' => now(),
                    'end_date' => now()->addDays(rand(1, 30)),
                ]);
            }
        }
    }
}
