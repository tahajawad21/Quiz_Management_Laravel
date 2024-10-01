<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentSubmissionRequest;
use App\Http\Requests\UpdateStudentSubmissionStatusRequest;
use App\Models\StudentSubmission;
use App\Services\StudentSubmissionService;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class StudentSubmissionController extends Controller
{
    protected $submissionService;

    public function __construct(StudentSubmissionService $submissionService)
    {
        $this->submissionService = $submissionService;
    }

    public function store(StoreStudentSubmissionRequest $request)
    {
        $validatedData = $request->validated();
        Log::info($validatedData);

        $submission = $this->submissionService->storeSubmission($validatedData);

        return response()->json(['message' => 'Submission received successfully. Check your email for confirmation.'], 201);
    }
    
   public function getPendingSubmissions()
    {
        $pendingSubmissions = StudentSubmission::where('status', 'pending')->get();

        return response()->json([
            'status' => 200,
            'message' => 'Pending student submissions retrieved successfully',
            'data' => $pendingSubmissions,
        ], 200);
    }
    public function viewStudents(Request $request)
    {
    $result = $this->submissionService->viewStudents($request->status);
    return response()->json([
        'data'=>$result
    ]);
    
}

}
