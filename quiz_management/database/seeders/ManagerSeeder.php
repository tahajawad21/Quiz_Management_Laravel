<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manager = User::where('email', 'manager@example.com')->first();

        if (!$manager) {
            DB::table('users')->insert([
                'name' => 'Manager',
                'email' => 'manager@example.com',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            $this->command->info('Manager user already exists, skipping seeding.');
        }
    }
}
