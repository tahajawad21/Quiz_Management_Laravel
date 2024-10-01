<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            QuizSeeder::class,
            QuizUserSeeder::class,
            ManagerSeeder::class,
            AdminSeeder::class,
            UserSeeder::class
        ]);
    }
}
