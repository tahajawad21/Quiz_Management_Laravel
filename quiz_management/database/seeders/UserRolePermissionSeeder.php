<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assign admin role to user with ID 1
        $admin = User::find(1);
        $admin->assignRole('admin');

        // Assign manager role to user with ID 2
        $manager = User::find(2);
        $manager->assignRole('manager');

        // Assign specific permissions
        $admin->givePermissionTo('manage_users');
        $manager->givePermissionTo('create_quiz');
    }
}
