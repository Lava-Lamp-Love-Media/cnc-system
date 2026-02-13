<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Machine;
use App\Models\Company;
use Illuminate\Support\Str;

class MachineSeeder extends Seeder
{
    public function run(): void
    {
        // Get companies
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->warn('No companies found. Please run CompanySeeder first.');
            return;
        }

        $manufacturers = ['Haas', 'DMG MORI', 'Mazak', 'Okuma', 'Fanuc', 'Makino', 'Hurco'];
        $machineTypes = [
            'CNC Mill' => ['VF-2', 'VF-4', 'VM-3', 'EC-400'],
            'CNC Lathe' => ['ST-10', 'ST-20', 'TL-2', 'PUMA 2100'],
            'Vertical Machining Center' => ['VMC-500', 'VMC-750', 'VMC-1000'],
            'Horizontal Machining Center' => ['HMC-500', 'HMC-630'],
            'Wire EDM' => ['AP250L', 'CUT200'],
        ];
        $locations = ['Shop Floor A', 'Shop Floor B', 'Assembly Area', 'Production Zone 1', 'Production Zone 2'];

        foreach ($companies as $company) {
            $machineCount = rand(5, 15);

            for ($i = 1; $i <= $machineCount; $i++) {
                $type = array_rand($machineTypes);
                $models = $machineTypes[$type];
                $model = $models[array_rand($models)];
                $manufacturer = $manufacturers[array_rand($manufacturers)];
                $year = rand(2015, 2024);
                $status = ['active', 'active', 'active', 'maintenance', 'inactive'][rand(0, 4)];

                $purchaseDate = now()->subYears(rand(1, 8));
                $lastMaintenance = now()->subDays(rand(10, 90));
                $nextMaintenance = now()->addDays(rand(30, 180));

                Machine::create([
                    'company_id' => $company->id,
                    'name' => $type . ' - ' . $model,
                    'machine_code' => 'OPR-' . strtoupper(substr($type, 0, 3)) . '-' . strtoupper(Str::random(6)),
                    'manufacturer' => $manufacturer,
                    'model' => $model,
                    'serial_number' => strtoupper(Str::random(3)) . '-' . rand(10000, 99999),
                    'year_of_manufacture' => $year,
                    'purchase_date' => $purchaseDate,
                    'purchase_price' => rand(50000, 500000),
                    'status' => $status,
                    'description' => 'High-precision ' . strtolower($type) . ' for manufacturing operations.',
                    'specifications' => json_encode([
                        'Max RPM' => rand(8000, 15000),
                        'Power' => rand(10, 50) . ' kW',
                        'Work Area' => rand(500, 1500) . 'mm x ' . rand(400, 1000) . 'mm',
                        'Tool Capacity' => rand(20, 40) . ' tools',
                        'Accuracy' => '±' . rand(5, 15) . ' microns',
                    ]),
                    'location' => $locations[array_rand($locations)],
                    'operating_hours' => rand(1000, 15000),
                    'last_maintenance_date' => $lastMaintenance,
                    'next_maintenance_date' => $nextMaintenance,
                ]);
            }

            $this->command->info("✅ Created {$machineCount} machines for {$company->name}");
        }
    }
}
