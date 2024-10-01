<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuizUserSeeder extends Seeder
{
    public function run()
    {
        $quizId = DB::table('quizzes')->first()->id ?? null;
        $userId = DB::table('users')->first()->id ?? null;

        if ($quizId && $userId) {
            DB::table('quiz_user')->insert([
                'quiz_id' => $quizId,
                'user_id' => $userId,
                'assigned_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } else {
            $this->command->info('No quizzes or users found in the database.');
        }
    }
}
