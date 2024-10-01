<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use Illuminate\Http\Request;
use App\DTO\CreateUserDTO;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected $adminService;
    public function __construct(AdminService $adminService)
    {
        $this->middleware('permission:manage users', ['only' => ['dashboard']]);
        $this->adminService = $adminService;  
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function acceptSubmission($id, Request $request)
    {
        $message = $request->input('message');
        $response = $this->adminService->acceptSubmission($id, $message);
        return response()->json($response, 200);
    }
    public function rejectSubmission($id, Request $request)
    {
        $message = $request->input('message');
        $response = $this->adminService->rejectSubmission($id, $message);
        return response()->json($response, 200);
    }

    public function reviewSubmission($id, Request $request)
    {
        $status = $request->input('status', 'pending');
        $message = $request->input('message');
        $response = $this->adminService->reviewSubmission($id, $status, $message);
        return response()->json($response, 200);
    }

    public function addUser(CreateUserRequest $request)
    {

    try{
        Log::info('Attempting to create a user', ['data' => $request->all()]);
        $createUserDTO = new CreateUserDTO($request->validated());
    
        $response = $this->adminService->addUser($createUserDTO);
    
        Log::info('User created successfully', ['user' => $response['user']]);
            return response()->json($response, 201);
        } 
        catch (\Exception $e) {
            Log::error('Error creating user', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'User creation failed'], 500);
        }
    }
    public function addStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $createUserDTO = new CreateUserDTO($request->only(['name', 'email', 'password']));

        $response = $this->adminService->addStudent($createUserDTO);

        if (isset($response['error'])) {
            return response()->json(['error' => $response['error']], 422);
        }

        return response()->json($response, 201);
    }
    public function assignRoleToUser($userId)
    {
        $user = User::find($userId);
        $user->assignRole('admin');

        return response()->json(['message' => 'Role assigned successfully']);
    }
    

    public function assignPermissionToUser($userId)
    {
        $user = User::find($userId);
        $user->givePermissionTo('manage_users');

        return response()->json(['message' => 'Permission assigned successfully']);
    }

}
