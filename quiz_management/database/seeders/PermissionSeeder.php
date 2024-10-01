<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions for admins
        Permission::create(['name' => 'user can reject student signup form']);
        Permission::create(['name' => 'user can accept student signup form']);
        Permission::create(['name' => 'user can add user']);
        Permission::create(['name' => 'user can delete user']);
        Permission::create(['name' => 'user can view managers']);

        // Permissions for manager and admin
        Permission::create(['name' => 'user can view students']);
        Permission::create(['name' => 'user can create quiz']);
        Permission::create(['name' => 'user can update quiz']);
        Permission::create(['name' => 'user can delete quiz']);
        Permission::create(['name' => 'user can view all quizzes']);
        Permission::create(['name' => 'user can assign quiz']);

        // Permissions for students
        Permission::create(['name' => 'user can attempt assigned quiz']);
        Permission::create(['name' => 'user can view assigned quiz']);
        Permission::create(['name' => 'user can view quiz result']);

        Permission::firstOrCreate(['name' => 'create_quiz', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'create_quiz', 'guard_name' => 'api']);

        $role = Role::where('name', 'admin')->first();
        if ($role) {
            $role->givePermissionTo('create_quiz');
        }

        // Create roles
        $AdminRole = Role::create(['name' => 'Admin']);
        $managerRole = Role::create(['name' => 'Manager']);
        $studentRole = Role::create(['name' => 'Student']);
        $supervisorRole = Role::create(['name' => 'supervisor']);

        // Assign permissions to roles
        $AdminRole->givePermissionTo([
            'user can reject student signup form',
            'user can accept student signup form',
            'user can add user',
            'user can delete user',
            'user can view managers',
            'user can view students',
            'user can create quiz',
            'user can update quiz',
            'user can delete quiz',
            'user can view all quizzes',
            'user can assign quiz'
        ]);

        $managerRole->givePermissionTo([
            'user can view students',
            'user can create quiz',
            'user can update quiz',
            'user can delete quiz',
            'user can view all quizzes',
            'user can assign quiz'
        ]);

        $studentRole->givePermissionTo([
            'user can attempt assigned quiz',
            'user can view assigned quiz',
            'user can view quiz result'
        ]);
    }
}
