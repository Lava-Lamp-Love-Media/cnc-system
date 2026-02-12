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
        // Get existing companies
        $c1 = Company::where('email', 'info@cnc.com')->firstOrFail();
        $c2 = Company::where('email', 'contact@precision.com')->firstOrFail();

        $users = [
            // ========== SUPER ADMIN ==========
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@cnc.com',
                'role' => 'super_admin',
                'company_id' => null
            ],

            // ========== COMPANY 1 (CNC) - ALL ROLES ==========
            [
                'name' => 'CNC Company Admin',
                'email' => 'admin1@cnc.com',
                'role' => 'company_admin',
                'company_id' => $c1->id
            ],
            [
                'name' => 'John Shop Manager',
                'email' => 'shop@cnc.com',
                'role' => 'shop',
                'company_id' => $c1->id
            ],
            [
                'name' => 'Mike Engineer',
                'email' => 'engineer@cnc.com',
                'role' => 'engineer',
                'company_id' => $c1->id
            ],
            [
                'name' => 'Sarah Editor',
                'email' => 'editor@cnc.com',
                'role' => 'editor',
                'company_id' => $c1->id
            ],
            [
                'name' => 'Tom QC Inspector',
                'email' => 'qc@cnc.com',
                'role' => 'qc',
                'company_id' => $c1->id
            ],
            [
                'name' => 'Lisa Checker',
                'email' => 'checker@cnc.com',
                'role' => 'checker',
                'company_id' => $c1->id
            ],
            [
                'name' => 'Regular User 1',
                'email' => 'user1@cnc.com',
                'role' => 'user',
                'company_id' => $c1->id
            ],

            // ========== COMPANY 2 (Precision) - SAMPLE ROLES ==========
            [
                'name' => 'Precision Company Admin',
                'email' => 'admin2@precision.com',
                'role' => 'company_admin',
                'company_id' => $c2->id
            ],
            [
                'name' => 'David Shop Lead',
                'email' => 'shop@precision.com',
                'role' => 'shop',
                'company_id' => $c2->id
            ],
            [
                'name' => 'Emily Engineer',
                'email' => 'engineer@precision.com',
                'role' => 'engineer',
                'company_id' => $c2->id
            ],
            [
                'name' => 'Regular User 2',
                'email' => 'user2@precision.com',
                'role' => 'user',
                'company_id' => $c2->id
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name' => $u['name'],
                    'password' => Hash::make('password123'),
                    'role' => $u['role'],
                    'company_id' => $u['company_id'],
                ]
            );
        }

        $this->command->info('✅ Users seeded successfully!');
        $this->command->info('');
        $this->command->info('📋 TEST ACCOUNTS:');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('🔐 Super Admin: superadmin@cnc.com / password123');
        $this->command->info('');
        $this->command->info('🏢 COMPANY 1 (CNC):');
        $this->command->info('   Company Admin: admin1@cnc.com / password123');
        $this->command->info('   Shop Manager:  shop@cnc.com / password123');
        $this->command->info('   Engineer:      engineer@cnc.com / password123');
        $this->command->info('   Editor:        editor@cnc.com / password123');
        $this->command->info('   QC Inspector:  qc@cnc.com / password123');
        $this->command->info('   Checker:       checker@cnc.com / password123');
        $this->command->info('   User:          user1@cnc.com / password123');
        $this->command->info('');
        $this->command->info('🏢 COMPANY 2 (Precision):');
        $this->command->info('   Company Admin: admin2@precision.com / password123');
        $this->command->info('   Shop Lead:     shop@precision.com / password123');
        $this->command->info('   Engineer:      engineer@precision.com / password123');
        $this->command->info('   User:          user2@precision.com / password123');
        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
    }
}
