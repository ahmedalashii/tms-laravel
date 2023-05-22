<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Discipline;
use Illuminate\Database\Seeder;

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
            'Web Development' => 'Web development is the work involved in developing a Web site for the Internet or an intranet. Web development can range from developing a simple single static page of plain text to complex web applications, electronic businesses, and social network services.',
            'Mobile Development' => 'Mobile app development is the act or process by which a mobile app is developed for mobile devices, such as personal digital assistants, enterprise digital assistants or mobile phones.',
            'Software Development' => 'Software development is the process of conceiving, specifying, designing, programming, documenting, testing, and bug fixing involved in creating and maintaining applications, frameworks, or other software components.',
            'Database Administration' => 'Database administration is the function of managing and maintaining database management systems (DBMS) software. Mainstream DBMS software such as Oracle, IBM DB2 and Microsoft SQL Server need ongoing management.',
            'Data Science' => 'Data science is an inter-disciplinary field that uses scientific methods, processes, algorithms and systems to extract knowledge and insights from many structural and unstructured data.',
            'Artificial Intelligence' => 'Artificial intelligence (AI) is intelligence demonstrated by machines, unlike the natural intelligence displayed by humans and animals, which involves consciousness and emotionality.',
            'Machine Learning' => 'Machine learning (ML) is the study of computer algorithms that improve automatically through experience. It is seen as a subset of artificial intelligence.',
            'Cyber Security' => 'Cybersecurity is the practice of protecting systems, networks, and programs from digital attacks. These attacks are usually aimed at accessing, changing, or destroying sensitive information; extorting money from users; or interrupting normal business processes.',
            'Cloud Computing' => 'Cloud computing is the on-demand availability of computer system resources, especially data storage (cloud storage) and computing power, without direct active management by the user.',
            'Network Administration' => 'Network administration is the process of managing a computer network. It involves a wide range of network management tasks, that include network design, security management, network analysing, and troubleshooting.',
            'Game Development' => 'Game development is the process of creating video games. The effort is undertaken by a developer, ranging from a single person to an international team dispersed across the globe.',
            'DevOps' => 'DevOps is a set of practices that combines software development (Dev) and IT operations (Ops). It aims to shorten the systems development life cycle and provide continuous delivery with high software quality.',
        ];
        foreach ($disciplines as $discipline => $description) {
            Discipline::factory()->create([
                'name' => $discipline,
                'description' => $description,
            ]);
        }
    }
}
