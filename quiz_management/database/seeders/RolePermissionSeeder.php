<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $guardName = 'api'; // Use the correct guard, either 'api' or 'web'

        // Use firstOrCreate to avoid creating duplicate roles
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => $guardName]);
        $managerRole = Role::firstOrCreate(['name' => 'manager', 'guard_name' => $guardName]);
        $studentRole = Role::firstOrCreate(['name' => 'student', 'guard_name' => $guardName]);

        $supervisorRole = Role::firstOrCreate(['name' => 'supervisor', 'guard_name' => $guardName]);

        // Create permissions if they don't already exist
        $permissions = [
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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => $guardName]);
        }

        // Assign permissions to roles
        $adminRole->syncPermissions(Permission::all()); // Admin gets all permissions
        $managerRole->syncPermissions(['create_quiz', 'edit_quiz', 'assign_quiz']); // Manager gets specific permissions
        $studentRole->syncPermissions('view_results'); // Student can view results only
    }
}
