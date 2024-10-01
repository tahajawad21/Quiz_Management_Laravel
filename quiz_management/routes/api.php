<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Api\StudentRegisterController;

Route::post('/register', [StudentRegisterController::class, 'register']);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\QuizController;
use App\Http\Controllers\StudentSubmissionController;
use App\Http\Controllers\ManagerController;

Route::get('/submissions/pending', [StudentSubmissionController::class, 'getPendingSubmissions']);
Route::get('/students', [StudentSubmissionController::class, 'viewStudents'])->middleware(['auth:api', 'role:admin|supervisor']);

Route::post('/admin/add-manager', [AdminController::class, 'addManager'])->middleware('auth:api');


use App\Http\Controllers\QuizAttemptController;

Route::post('/quiz-attempts', [QuizAttemptController::class, 'store']);

Route::post('/quiz-results', [QuizController::class, 'calculateAndStoreResult']);

Route::post('/student-submission', [StudentSubmissionController::class, 'store']);
Route::put('/student-submission/{id}/status', [StudentSubmissionController::class, 'updateSubmissionStatus']);
Route::get('/student-submission/{id}/download-cv', [StudentSubmissionController::class, 'downloadCV']);

//Public Routes
Route::post('/register-student', [AdminController::class, 'addStudent'])->withoutMiddleware(['auth']);
Route::post('/student-submission', [StudentSubmissionController::class, 'store']);
Route::post('password/forgot', [AuthController::class, 'forgotPassword']);
Route::post('password/reset', [AuthController::class, 'resetPassword']);
Route::post('password/resend-link', [AuthController::class, 'resendResetLink']);
Route::post('login', [AuthController::class, 'login']);
Route::post('/manager/add-student', [ManagerController::class, 'addStudent'])->middleware(['auth', 'role:manager']);

Route::group(['middleware' => ['auth', 'permission:manage users']], function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

// Routes secured with JWT middleware
Route::middleware('auth.jwt')->group(function () {
    
    // Quiz routes
    Route::post('/quizzes', [QuizController::class, 'store']);
    Route::post('assign-quiz', [QuizController::class, 'assignQuiz']);
    Route::get('student/{id}/quizzes', [QuizController::class, 'getAssignedQuizzes']);
    Route::post('store-video', [QuizController::class, 'storeQuizVideo']);
    Route::post('quiz/{id}/calculate-result', [QuizController::class, 'calculateResult']);
    Route::put('quiz/{id}/reschedule', [QuizController::class, 'rescheduleQuiz']);
    Route::post('/quiz/{quizId}/assign-user', [QuizController::class, 'assignUserToQuiz']);
    Route::get('/quizzes', [QuizController::class, 'getAllQuizzes']);

    
    // Admin routes for managing submissions
    Route::post('admin/submission-review/{id}', [AdminController::class, 'reviewSubmission']);
    Route::post('admin/add-user', [AdminController::class, 'addManager']);
    Route::post('admin/add-student', [AdminController::class, 'addStudent']);
    Route::post('admin/submission/{id}/accept', [AdminController::class, 'acceptSubmission']);
    Route::post('admin/submission/{id}/reject', [AdminController::class, 'rejectSubmission']);
    

    // Auth-related routes for logged-in users
    Route::post('logout', [AuthController::class, 'logout']);
});
// Route for admin access only
Route::group(['middleware' => ['role:Super Admin']], function() {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
});

// Route for permission-based access
Route::group(['middleware' => ['permission:user can create quiz']], function() {
    Route::post('/quiz', [QuizController::class, 'create']);
});
Route::get('/test-email', function () {
    Mail::raw('This is a test email', function ($message) {
        $message->to('your-email@example.com')
                ->subject('Test Email');
    });

    return 'Test email sent!';
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
