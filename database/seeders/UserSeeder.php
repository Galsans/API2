<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'department_id' => 1,
        ]);

        User::create([
            'name' => 'hendra',
            'email' => 'hendra@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'department_id' => 10,
        ]);

        User::create([
            'name' => 'ijadin',
            'email' => 'ijadin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'department_id' => 16,
        ]);

        User::create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'department_id' => 12,
        ]);
        User::create([
            'name' => 'bambang',
            'email' => 'bambang@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'department_id' => 21,
        ]);
    }
}
