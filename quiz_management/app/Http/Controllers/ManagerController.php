<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{
    public function addStudent(Request $request)
    {
        // Check if the authenticated user is a manager
        if (Auth::user()->role !== 'manager') {
            return response()->json(['error' => 'Only managers can add students'], 403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $student = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        return response()->json(['message' => 'Student added successfully', 'student' => $student], 201);
    }
}
