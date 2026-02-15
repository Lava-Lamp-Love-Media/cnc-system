<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PlanSeeder::class,
            FeatureSeeder::class,
            PlanFeatureSeeder::class,
            CompanySeeder::class,
            UserSeeder::class,
            MachineSeeder::class,
            OperatorSeeder::class,
            OperationSeeder::class,
            WarehouseSeeder::class,
            CustomerSeeder::class,
            VendorSeeder::class,
            HoleSeeder::class,
            ChamferSeeder::class,
            DeburSeeder::class,
            TapSeeder::class,
        ]);
    }
}
