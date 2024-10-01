<?php

namespace App\Services;

use App\Models\StudentSubmission;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Mail\StudentSubmissionConfirmation;
use App\Mail\StudentSubmissionStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class StudentSubmissionService
{
    public function storeSubmission($data)
    {
        Log::info('Storing student submission', ['data' => $data]);

        if (isset($data['cv'])) {
            $cvPath = $data['cv']->store('cv_uploads', 'public');
            Log::info('CV file uploaded', ['cv_path' => $cvPath]);
        } else {
            Log::error('CV file is missing in the data');
            return response()->json(['error' => 'CV file is required'], 400);
        }

        $submission = StudentSubmission::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'cv_path' => $cvPath,
            'status' => 'pending',
        ]);

        Mail::to($submission->email)->send(new StudentSubmissionStatus($submission));


        Log::info('Student submission stored successfully', ['submission_id' => $submission->id]);

        return $submission;
    }
    public function viewStudents($filterBy)

    {
        if($filterBy==='accepted'){
            $students = StudentSubmission::where('status', 'accepted')->get();
            return $students;
        }
        else if($filterBy === 'rejected'){
            $students=StudentSubmission::where('status','rejected')->get();
        }
        else if($filterBy === 'pending'){
            $students=StudentSubmission::where('status','pending')->get();
        }
        else{
            $students = StudentSubmission::all();
        }
        return $students;
    }
}
