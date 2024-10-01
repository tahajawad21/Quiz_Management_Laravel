<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => 'api']);

        $student = User::create([
            'name' => 'Taha Jawad',
            'email' => 'student@example.com',
            'password' => Hash::make('password'), // Hashed password
        ]);
        $student->assignRole($studentRole);
    }
}
