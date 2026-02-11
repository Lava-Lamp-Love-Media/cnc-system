<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Company;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $c1 = Company::where('email', 'info@cnc.com')->firstOrFail();
        $c2 = Company::where('email', 'contact@precision.com')->firstOrFail();

        $users = [
            ['name' => 'Super Admin', 'email' => 'superadmin@cnc.com', 'role' => 'super_admin', 'company_id' => null],

            ['name' => 'Company Admin 1', 'email' => 'admin1@cnc.com', 'role' => 'company_admin', 'company_id' => $c1->id],
            ['name' => 'User 1', 'email' => 'user1@cnc.com', 'role' => 'user', 'company_id' => $c1->id],

            ['name' => 'Company Admin 2', 'email' => 'admin2@cnc.com', 'role' => 'company_admin', 'company_id' => $c2->id],
            ['name' => 'User 2', 'email' => 'user2@cnc.com', 'role' => 'user', 'company_id' => $c2->id],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(['email' => $u['email']], [
                'name' => $u['name'],
                'password' => Hash::make('password123'),
                'role' => $u['role'],
                'company_id' => $u['company_id'],
            ]);
        }
    }
}
