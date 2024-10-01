<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuizAttemptRequest;
use App\Models\Quiz;
use App\Models\Question;
use App\Services\QuizService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreQuizRequest;
use App\Models\QuizAttempt;
use App\Models\User;

class QuizController extends Controller
{
    protected $quizService;

    public function __construct(QuizService $quizService)
    {
        $this->quizService = $quizService;
    }

    public function store(StoreQuizRequest $request)
    {
        $quiz = $this->quizService->storeQuiz($request->validated());

        return response()->json([
            'message' => 'Quiz created successfully',
            'quiz' => $quiz,
        ], 201);
    }
    public function getAssignedQuizzes($studentId)
    {
        $quizzes = $this->quizService->getAssignedQuizzes($studentId);

        return response()->json([
            'status' => 200,
            'message' => "Quiz list by student id $studentId",
            'data' => $quizzes,
        ]);
    }

    public function assignUserToQuiz(Request $request, $quizId)
    {
        $userId = $request->input('user_id');
        $result = $this->quizService->assignUserToQuiz($quizId, $userId);

        return response()->json([
            'status' => 200,
            'message' => 'User assigned to quiz successfully',
            'data' => $result,
        ]);
    }

    public function getAllQuizzes()
    {
        $quizzes = $this->quizService->getAllQuizzes();

        return response()->json([
            'status' => 200,
            'data' => ['quizzes' => $quizzes],
        ], 200);
    }

    public function assignQuiz(Request $request)
    {
        $quizId = $request->input('quiz_id');
        $studentId = $request->input('student_id');
        $result = $this->quizService->assignQuiz($quizId, $studentId);

        return response()->json(['message' => $result], 200);
    }

    public function fetchAllQuizzes()
    {
        $quizzes = $this->quizService->fetchAllQuizzes();
        return response()->json($quizzes);
    }

    public function calculateResult(Request $request, $quizId)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:users,id',
            'answers' => 'required|array',
        ]);

        $score = $this->quizService->calculateResult($quizId, $validated['student_id'], $validated['answers']);

        return response()->json(['message' => 'Quiz result calculated successfully', 'score' => $score]);
    }

    public function storeQuizVideo(Request $request)
    {
        $validated = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'video_url' => 'required|url',
        ]);

        $result = $this->quizService->storeQuizVideo($validated['quiz_id'], $validated['video_url']);

        return response()->json(['message' => $result], 200);
    }

    public function calculateAndStoreResult(StoreQuizAttemptRequest $request)
    {
        $validated = $request->validated();
        
        $quiz = Quiz::findOrFail($validated['quiz_id']);
        $student = User::findOrFail($validated['student_id']);
        
        $correctAnswers = 0;
        $totalQuestions = count($quiz->questions);
        
        foreach ($validated['answers'] as $questionId => $submittedAnswer) {
            $question = Question::findOrFail($questionId);
            
            if ($question && $question->correct_answer === $submittedAnswer) {
                $correctAnswers++;
            }
        }
        
        $score = ($correctAnswers / $totalQuestions) * 100;
        
        $quizAttempt = QuizAttempt::create([
            'user_id' => $student->id,
            'quiz_id' => $quiz->id,
            'answers' => $validated['answers'], 
            'score' => $score,
            'attempted_at' => now(),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Quiz result calculated and stored successfully',
            'data' => [
                'quiz_attempt' => $quizAttempt,
                'score' => $score,
            ],
        ]);
    }
}
