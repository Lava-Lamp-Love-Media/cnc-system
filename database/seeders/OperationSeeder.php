<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Operation;
use App\Models\Company;

class OperationSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->warn('No companies found.');
            return;
        }

        $operations = [
            ['name' => 'CNC Milling', 'code' => 'MIL', 'rate' => 85.00, 'desc' => '3-axis and 5-axis CNC milling operations'],
            ['name' => 'CNC Turning', 'code' => 'TRN', 'rate' => 75.00, 'desc' => 'Precision turning on CNC lathes'],
            ['name' => 'Drilling', 'code' => 'DRL', 'rate' => 60.00, 'desc' => 'Precision hole drilling operations'],
            ['name' => 'Grinding', 'code' => 'GRN', 'rate' => 90.00, 'desc' => 'Surface and cylindrical grinding'],
            ['name' => 'EDM Wire Cutting', 'code' => 'EDM', 'rate' => 120.00, 'desc' => 'Wire electrical discharge machining'],
            ['name' => 'Welding', 'code' => 'WLD', 'rate' => 70.00, 'desc' => 'TIG, MIG, and arc welding services'],
            ['name' => 'Tapping', 'code' => 'TAP', 'rate' => 55.00, 'desc' => 'Internal thread cutting operations'],
            ['name' => 'Boring', 'code' => 'BOR', 'rate' => 80.00, 'desc' => 'Precision boring operations'],
            ['name' => 'Facing', 'code' => 'FAC', 'rate' => 65.00, 'desc' => 'Surface facing operations'],
            ['name' => 'Deburring', 'code' => 'DBR', 'rate' => 45.00, 'desc' => 'Edge deburring and finishing'],
        ];

        $globalCounter = 1; // ✅ Global counter for unique codes

        foreach ($companies as $companyIndex => $company) {
            foreach ($operations as $index => $op) {
                Operation::create([
                    'company_id' => $company->id,
                    'operation_code' => 'OPT-' . str_pad($globalCounter, 3, '0', STR_PAD_LEFT), // ✅ Unique across all companies
                    'name' => $op['name'],
                    'description' => $op['desc'],
                    'hourly_rate' => $op['rate'],
                    'status' => 'active',
                ]);

                $globalCounter++; // ✅ Increment for next operation
            }

            $this->command->info("✅ Created " . count($operations) . " operations for {$company->name}");
        }
    }
}
