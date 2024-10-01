<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Quiz;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Quiz::create([
            'title' => 'Sample Quiz',
            'description' => 'This is a sample quiz',
            'start_time' => now(),
            'end_time' => now()->addHours(2),
        ]);
    }
}
