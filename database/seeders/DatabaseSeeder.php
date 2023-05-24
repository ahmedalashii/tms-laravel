<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\DisciplineSeeder;
use Database\Seeders\TrainingProgramSeeder;
use Database\Seeders\TrainingCriterionSeeder;
use Illuminate\Foundation\Auth\RegistersUsers;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;

class DatabaseSeeder extends Seeder
{
    use RegistersUsers;
    protected $auth;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(FirebaseAuth $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $name = 'Ahmed Alashi';
        $email = 'admin@admin.com';
        $password = '123456';
        try {
            $user = $this->auth->getUserByEmail($email);
        } catch (\Kreait\Firebase\Exception\Auth\UserNotFound $e) {
            // if the user doesn't exist, create a new one
            $userProperties = [
                'email' => $email,
                'emailVerified' => true,
                'password' => $password,
                'role' => 'super_manager',
                'displayName' => $name,
                'disabled' => false,
            ];
            $user = $this->auth->createUser($userProperties);
        }
        $manager = new \App\Models\Manager;
        $manager->firebase_uid = $user->uid;
        $manager->displayName = $name;
        $manager->email = $email;
        $manager->is_active = true;
        $manager->role = 'super_manager';
        $manager->password = Hash::make($password);
        $manager->save();
        $this->call(DisciplineSeeder::class);
        $this->call(TrainingProgramSeeder::class);
        $this->call(TrainingCriterionSeeder::class);
    }
}
