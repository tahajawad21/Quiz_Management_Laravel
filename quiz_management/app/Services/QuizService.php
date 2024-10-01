<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\Question;
use App\Models\User;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuizService
{
    public function storeQuiz(array $data)
    {
        // Create Quiz
        $quiz = Quiz::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'] ?? null,
        ]);

        foreach ($data['questions'] as $question) {
            $quiz->questions()->create([
                'question_text' => $question['question_text'],
                'correct_answer' => $question['correct_answer'],
                'options' => $question['options'],
            ]);
        }

        return $quiz->load('questions');
    }

    public function getAssignedQuizzes($studentId)
    {
        $student = User::findOrFail($studentId);
        $quizzes = $student->quizzes()->paginate(10);

        return $quizzes;
    }

    public function assignUserToQuiz($quizId, $userId)
    {
        $quiz = Quiz::findOrFail($quizId);

        $quiz->users()->attach($userId, [
            'assigned_at' => now(),
            'status' => 'pending',
            'due_date' => now()->addDays(7),
        ]);

        return [
            'quiz_id' => $quizId,
            'user_id' => $userId,
            'assigned_at' => now(),
            'status' => 'pending',
            'due_date' => now()->addDays(7),
        ];
    }

    public function getAllQuizzes()
    {
        return Quiz::with('questions')->paginate(10);
    }

    public function assignQuiz($quizId, $studentId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $student = User::findOrFail($studentId);

        if ($quiz && $student) {
            $quiz->users()->attach($studentId);
            return 'Quiz assigned successfully';
        }

        return 'Invalid quiz or student ID';
    }

    public function fetchAllQuizzes()
    {
        return Quiz::all();
    }

    public function calculateResult($quizId, $studentId, $answers)
    {
        $quiz = Quiz::findOrFail($quizId);
        $student = User::findOrFail($studentId);
        $correctAnswers = 0;

        // comparing answers to stored correct answers
        foreach ($answers as $questionId => $answer) {
            $question = Question::find($questionId);
            if ($question && $question->correct_answer == $answer) {
                $correctAnswers++;
            }
        }

        $totalQuestions = count($answers);
        $score = ($correctAnswers / $totalQuestions) * 100;

        QuizAttempt::create([
            'user_id' => $student->id,
            'quiz_id' => $quiz->id,
            'score' => $score,
            'attempted_at' => now(),
        ]);

        return $score;
    }

    public function storeQuizVideo($quizId, $videoUrl)
    {
        $quiz = Quiz::findOrFail($quizId);

        if (!$quiz) {
            return 'Quiz not found';
        }

        $quiz->video_url = $videoUrl;
        $quiz->save();

        return 'Video URL stored successfully';
    }
}
