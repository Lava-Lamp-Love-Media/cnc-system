<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chamfer;
use App\Models\Company;

class ChamferSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // Check if chamfers already exist for this company
            $existingCount = Chamfer::where('company_id', $company->id)->count();

            if ($existingCount > 0) {
                $this->command->warn("⚠️  Chamfers already exist for company: {$company->name}. Skipping...");
                continue;
            }

            $chamfers = [
                // Standard 45° Chamfers
                [
                    'chamfer_code' => "CHMF-0.3-45-{$company->id}",
                    'name' => '0.3mm × 45°',
                    'size' => 0.30,
                    'angle' => 45.00,
                    'unit_price' => 1.00,
                    'description' => 'Small chamfer for edge breaking',
                    'sort_order' => 1
                ],
                [
                    'chamfer_code' => "CHMF-0.5-45-{$company->id}",
                    'name' => '0.5mm × 45°',
                    'size' => 0.50,
                    'angle' => 45.00,
                    'unit_price' => 1.50,
                    'description' => 'Standard chamfer for most applications',
                    'sort_order' => 2
                ],
                [
                    'chamfer_code' => "CHMF-0.8-45-{$company->id}",
                    'name' => '0.8mm × 45°',
                    'size' => 0.80,
                    'angle' => 45.00,
                    'unit_price' => 2.00,
                    'description' => 'Medium chamfer',
                    'sort_order' => 3
                ],
                [
                    'chamfer_code' => "CHMF-1.0-45-{$company->id}",
                    'name' => '1.0mm × 45°',
                    'size' => 1.00,
                    'angle' => 45.00,
                    'unit_price' => 2.50,
                    'description' => 'Large chamfer for easy bolt insertion',
                    'sort_order' => 4
                ],
                [
                    'chamfer_code' => "CHMF-1.5-45-{$company->id}",
                    'name' => '1.5mm × 45°',
                    'size' => 1.50,
                    'angle' => 45.00,
                    'unit_price' => 3.00,
                    'description' => 'Extra large chamfer',
                    'sort_order' => 5
                ],
                [
                    'chamfer_code' => "CHMF-2.0-45-{$company->id}",
                    'name' => '2.0mm × 45°',
                    'size' => 2.00,
                    'angle' => 45.00,
                    'unit_price' => 3.50,
                    'description' => 'Very large chamfer for heavy parts',
                    'sort_order' => 6
                ],

                // 30° Chamfers
                [
                    'chamfer_code' => "CHMF-0.5-30-{$company->id}",
                    'name' => '0.5mm × 30°',
                    'size' => 0.50,
                    'angle' => 30.00,
                    'unit_price' => 2.00,
                    'description' => 'Shallow angle chamfer',
                    'sort_order' => 7
                ],
                [
                    'chamfer_code' => "CHMF-1.0-30-{$company->id}",
                    'name' => '1.0mm × 30°',
                    'size' => 1.00,
                    'angle' => 30.00,
                    'unit_price' => 2.75,
                    'description' => 'Shallow angle chamfer - medium',
                    'sort_order' => 8
                ],

                // 60° Chamfers
                [
                    'chamfer_code' => "CHMF-0.5-60-{$company->id}",
                    'name' => '0.5mm × 60°',
                    'size' => 0.50,
                    'angle' => 60.00,
                    'unit_price' => 2.25,
                    'description' => 'Steep angle chamfer',
                    'sort_order' => 9
                ],
                [
                    'chamfer_code' => "CHMF-1.0-60-{$company->id}",
                    'name' => '1.0mm × 60°',
                    'size' => 1.00,
                    'angle' => 60.00,
                    'unit_price' => 3.25,
                    'description' => 'Steep angle chamfer - medium',
                    'sort_order' => 10
                ],

                // Special Chamfers
                [
                    'chamfer_code' => "CHMF-BREAK-{$company->id}",
                    'name' => 'Edge Break (0.2mm)',
                    'size' => 0.20,
                    'angle' => null,
                    'unit_price' => 0.75,
                    'description' => 'Minimal edge break for sharp edge removal',
                    'sort_order' => 11
                ],
            ];

            foreach ($chamfers as $chamfer) {
                Chamfer::create(array_merge($chamfer, [
                    'company_id' => $company->id,
                    'status' => 'active'
                ]));
            }

            $this->command->info("✅ Chamfers seeded for company: {$company->name}");
        }
    }
}
