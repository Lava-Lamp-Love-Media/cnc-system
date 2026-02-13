<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Operator;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->warn('No companies found.');
            return;
        }

        $skillLevels = ['trainee', 'junior', 'senior', 'expert'];
        $firstNames = ['John', 'Mike', 'David', 'James', 'Robert', 'William', 'Tom', 'Chris'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis'];

        foreach ($companies as $company) {
            $count = rand(5, 12);

            for ($i = 1; $i <= $count; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                $name = $firstName . ' ' . $lastName;

                Operator::create([
                    'company_id' => $company->id,
                    'operator_code' => 'OPC-' . Str::random(10),
                    'name' => $name,
                    'email' => strtolower($firstName . '.' . $lastName . '@' . str_replace(' ', '', $company->name) . '.com'),
                    'phone' => '+1 ' . rand(200, 999) . ' ' . rand(100, 999) . ' ' . rand(1000, 9999),
                    'skill_level' => $skillLevels[array_rand($skillLevels)],
                    'status' => 'active',
                    'notes' => 'Experienced operator with ' . rand(1, 15) . ' years of experience.',
                ]);
            }

            $this->command->info("✅ Created {$count} operators for {$company->name}");
        }
    }
}
