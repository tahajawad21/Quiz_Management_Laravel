<?php

namespace App\Services;

use App\Models\User;
use App\Models\Manager;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserService
{
    public function addManager($data)
    {
        $userData = [
            'email' => $data['email'],
            'name' => $data['name'],
            'password' => Hash::make('password'), // You can set a default password
            'role' => 'Manager',
        ];

        return $this->addUser($userData);
    }

    public function addUser(array $data)
    {
        try {
            DB::beginTransaction();

            $user = User::create($data);

            $user->assignRole($data['role']);
            $user->save();

            // If role is Manager, create the Manager model entry
            if ($data['role'] === 'Manager') {
                Manager::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'user_id' => $user->id,
                ]);
            }

            DB::commit();

            return $user;

        } catch (QueryException $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
