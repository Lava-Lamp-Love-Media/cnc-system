<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Debur;
use App\Models\Company;

class DeburSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // Check if deburs already exist for this company
            $existingCount = Debur::where('company_id', $company->id)->count();

            if ($existingCount > 0) {
                $this->command->warn("⚠️  Deburs already exist for company: {$company->name}. Skipping...");
                continue;
            }

            $deburs = [
                // Standard Deburs
                [
                    'debur_code' => "DBR-LIGHT-{$company->id}",
                    'name' => 'Light Debur',
                    'size' => 0.10,
                    'unit_price' => 0.50,
                    'description' => 'Light edge break - removes minimal material (0.1mm)',
                    'sort_order' => 1
                ],
                [
                    'debur_code' => "DBR-STANDARD-{$company->id}",
                    'name' => 'Standard Debur',
                    'size' => 0.20,
                    'unit_price' => 0.75,
                    'description' => 'Standard edge break for most applications (0.2mm)',
                    'sort_order' => 2
                ],
                [
                    'debur_code' => "DBR-MEDIUM-{$company->id}",
                    'name' => 'Medium Debur',
                    'size' => 0.30,
                    'unit_price' => 1.00,
                    'description' => 'Medium edge break for heavier burrs (0.3mm)',
                    'sort_order' => 3
                ],
                [
                    'debur_code' => "DBR-HEAVY-{$company->id}",
                    'name' => 'Heavy Debur',
                    'size' => 0.50,
                    'unit_price' => 1.50,
                    'description' => 'Heavy edge break for large burrs (0.5mm)',
                    'sort_order' => 4
                ],

                // Special Deburs
                [
                    'debur_code' => "DBR-FINE-{$company->id}",
                    'name' => 'Fine Debur',
                    'size' => 0.05,
                    'unit_price' => 0.75,
                    'description' => 'Very fine edge break for precision parts (0.05mm)',
                    'sort_order' => 5
                ],
                [
                    'debur_code' => "DBR-MANUAL-{$company->id}",
                    'name' => 'Manual Debur',
                    'size' => null,
                    'unit_price' => 1.25,
                    'description' => 'Hand deburring for complex geometries',
                    'sort_order' => 6
                ],
                [
                    'debur_code' => "DBR-TUMBLE-{$company->id}",
                    'name' => 'Tumble Debur',
                    'size' => null,
                    'unit_price' => 2.00,
                    'description' => 'Mass finishing / tumbling process',
                    'sort_order' => 7
                ],
                [
                    'debur_code' => "DBR-VIBRATORY-{$company->id}",
                    'name' => 'Vibratory Debur',
                    'size' => null,
                    'unit_price' => 2.50,
                    'description' => 'Vibratory finishing for consistent results',
                    'sort_order' => 8
                ],

                // Thread Deburs
                [
                    'debur_code' => "DBR-THREAD-{$company->id}",
                    'name' => 'Thread Debur',
                    'size' => 0.15,
                    'unit_price' => 1.00,
                    'description' => 'Deburring tapped holes and threads',
                    'sort_order' => 9
                ],

                // All Edges
                [
                    'debur_code' => "DBR-ALL-EDGES-{$company->id}",
                    'name' => 'All Edges Debur',
                    'size' => 0.20,
                    'unit_price' => 3.00,
                    'description' => 'Debur all edges on the part (comprehensive)',
                    'sort_order' => 10
                ],
            ];

            foreach ($deburs as $debur) {
                Debur::create(array_merge($debur, [
                    'company_id' => $company->id,
                    'status' => 'active'
                ]));
            }

            $this->command->info("✅ Deburs seeded for company: {$company->name}");
        }
    }
}
