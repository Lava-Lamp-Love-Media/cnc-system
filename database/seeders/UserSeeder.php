<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Admin User', 'email' => 'admin@cnc.com', 'role' => 'admin'],
            ['name' => 'Shop User', 'email' => 'shop@cnc.com', 'role' => 'shop'],
            ['name' => 'Engineer User', 'email' => 'engineer@cnc.com', 'role' => 'engineer'],
            ['name' => 'Editor User', 'email' => 'editor@cnc.com', 'role' => 'editor'],
            ['name' => 'QC User', 'email' => 'qc@cnc.com', 'role' => 'qc'],
            ['name' => 'Checker User', 'email' => 'checker@cnc.com', 'role' => 'checker'],
        ];

        foreach ($users as $userData) {
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'role' => $userData['role'],
            ]);
        }
    }
}
