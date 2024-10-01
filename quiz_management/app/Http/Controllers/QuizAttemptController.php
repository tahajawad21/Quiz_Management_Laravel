<?php

namespace App\Http\Controllers;

use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use App\Models\Quiz;
use App\Models\User;

class QuizAttemptController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'quiz_id' => 'required|exists:quizzes,id',
            'answers' => 'required|array',
            'video_path' => 'nullable|string'
        ]);

        $attempt = QuizAttempt::create([
            'user_id' => $validated['user_id'],
            'quiz_id' => $validated['quiz_id'],
            'answers' => json_encode($validated['answers']),
            'video_path' => $validated['video_path'] ?? null,
            'attempted_at' => now(),
        ]);
    
        return response()->json([
            'status' => 200,
            'message' => 'Quiz attempt stored successfully',
            'data' => [
                'user_id' => $attempt->user_id,
                'quiz_id' => $attempt->quiz_id,
                'answers' => $attempt->answers,
                'attempted_at' => $attempt->attempted_at,
                'created_at' => $attempt->created_at,
                'updated_at' => $attempt->updated_at,
                'id' => $attempt->id
            ]
        ]);
        
    }
    
}
