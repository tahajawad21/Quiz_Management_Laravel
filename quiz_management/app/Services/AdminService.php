<?php

namespace App\Services;

use App\Models\User;
use App\Models\StudentSubmission;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\StudentSubmissionStatus;
use App\DTO\CreateUserDTO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AdminService
{
    public function acceptSubmission($id, $message = null)
    {
        $submission = StudentSubmission::findOrFail($id);
        $submission->status = 'accepted';
        $submission->save();

        $customMessage = $message ?? 'Your submission has been accepted.';
        Mail::to($submission->email)->send(new StudentSubmissionStatus($submission->name, $submission->status, $customMessage));

        return ['message' => 'Submission accepted successfully.'];
    }

    public function rejectSubmission($id, $message = null)
    {
        $submission = StudentSubmission::findOrFail($id);
        $submission->status = 'rejected';
        $submission->save();

        $customMessage = $message ?? 'Unfortunately, your submission has been rejected.';
        Mail::to($submission->email)->send(new StudentSubmissionStatus($submission, $customMessage));


        return ['message' => 'Submission rejected.'];
    }

    public function reviewSubmission($id, $status, $message = null)
    {
        $submission = StudentSubmission::findOrFail($id);
        $submission->status = $status;
        $submission->save();

        $customMessage = $message ?? 'Your submission status has been updated.';
        Mail::to($submission->email)->send(new StudentSubmissionStatus($submission->name, $submission->status, $customMessage));

        return ['message' => 'Submission reviewed successfully.'];
    }

    public function addUser(CreateUserDTO $userDTO)
    {
        try {
            $user = User::create([
                'name' => $userDTO->name,
                'email' => $userDTO->email,
                'password' => Hash::make($userDTO->password),
                'role' => $userDTO->role,
            ]);

            Log::info('Admin added user successfully', ['user_id' => $user->id]);
            return ['message' => 'User added successfully', 'user' => $user];
        } catch (\Exception $e) {
            Log::error('Failed to add user', ['error' => $e->getMessage()]);
            return ['error' => 'Failed to add user'];
        }
    }
    public function addStudent(CreateUserDTO $createUserDTO)
    {
        Log::info('Adding a student', ['name' => $createUserDTO->name, 'email' => $createUserDTO->email]);
    
        try {
            // Create a new student (user)
            $student = User::create([
                'name' => $createUserDTO->name,
                'email' => $createUserDTO->email,
                'password' => Hash::make($createUserDTO->password), // Hash the password before storing it
                'role' => 'student', // Make sure the user role is set to 'student'
            ]);
    
            Log::info('Student added successfully', ['student_id' => $student->id]);
    
            return ['message' => 'Student added successfully', 'student' => $student];
        } catch (\Exception $e) {
            Log::error('Error adding student', ['error' => $e->getMessage()]);
            return ['error' => 'Failed to add student'];
        }
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
