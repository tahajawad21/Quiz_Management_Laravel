<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // Make sure you're using the correct Role model

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin',
            'guard_name' => 'web', // Add guard_name
        ]);

        Role::create([
            'name' => 'manager',
            'guard_name' => 'web', // Add guard_name
        ]);

        Role::create([
            'name' => 'student',
            'guard_name' => 'web', // Add guard_name
        ]);
        Role::create([
            'name' => 'supervisor',
            'guard_name' => 'web',
        ]);
    }
}
