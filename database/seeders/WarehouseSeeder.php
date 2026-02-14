<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warehouse;
use App\Models\Company;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->warn('No companies found.');
            return;
        }

        $warehouseTypes = ['main', 'secondary', 'raw_material', 'finished_goods', 'tools'];
        $cities = ['Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia', 'San Antonio'];
        $states = ['CA', 'IL', 'TX', 'AZ', 'PA', 'TX'];

        $globalCounter = 1;

        foreach ($companies as $company) {
            $count = rand(2, 4);

            for ($i = 0; $i < $count; $i++) {
                $cityIndex = array_rand($cities);
                $type = $warehouseTypes[$i] ?? $warehouseTypes[array_rand($warehouseTypes)];

                $typeNames = [
                    'main' => 'Main Warehouse',
                    'secondary' => 'Secondary Storage',
                    'raw_material' => 'Raw Materials Depot',
                    'finished_goods' => 'Finished Goods Storage',
                    'tools' => 'Tools & Equipment',
                ];

                Warehouse::create([
                    'company_id' => $company->id,
                    'warehouse_code' => 'WH-' . str_pad($globalCounter, 3, '0', STR_PAD_LEFT),
                    'name' => $typeNames[$type] . ($i > 0 ? ' ' . ($i + 1) : ''),
                    'location' => $cities[$cityIndex] . ', ' . $states[$cityIndex],
                    'manager_name' => 'Manager ' . chr(65 + $i),
                    'phone' => '+1 ' . rand(200, 999) . ' ' . rand(100, 999) . ' ' . rand(1000, 9999),
                    'email' => 'warehouse' . ($i + 1) . '@' . str_replace(' ', '', strtolower($company->name)) . '.com',
                    'storage_capacity' => rand(500, 5000),
                    'capacity_unit' => ['sqm', 'cbm'][array_rand(['sqm', 'cbm'])],
                    'warehouse_type' => $type,
                    'status' => 'active',
                    'description' => 'Storage facility for ' . strtolower(str_replace('_', ' ', $type)),
                    'address' => rand(100, 9999) . ' Industrial Blvd',
                    'city' => $cities[$cityIndex],
                    'state' => $states[$cityIndex],
                    'zip_code' => rand(10000, 99999),
                    'country' => 'USA',
                ]);

                $globalCounter++;
            }

            $this->command->info("✅ Created {$count} warehouses for {$company->name}");
        }
    }
}
