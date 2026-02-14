<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\Address;
use App\Models\Company;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->warn('No companies found.');
            return;
        }

        $vendorTypes = ['supplier', 'manufacturer', 'distributor', 'contractor'];
        $statuses = ['active', 'inactive'];
        $vendorNames = [
            'Steel Suppliers Inc',
            'Aluminum Depot',
            'Tool Masters Corp',
            'Raw Materials Ltd',
            'Industrial Supply Co',
            'Metal Works International',
            'Precision Components',
            'Quality Materials',
            'Expert Contractors',
        ];
        $cities = ['Detroit', 'Pittsburgh', 'Cleveland', 'Milwaukee', 'Indianapolis', 'Columbus'];
        $states = ['MI', 'PA', 'OH', 'WI', 'IN', 'OH'];

        $globalCounter = 1;

        foreach ($companies as $company) {
            $count = rand(5, 12);

            for ($i = 0; $i < $count; $i++) {
                $type = $vendorTypes[array_rand($vendorTypes)];

                $vendor = Vendor::create([
                    'company_id' => $company->id,
                    'vendor_code' => 'VEND-' . str_pad($globalCounter, 5, '0', STR_PAD_LEFT),
                    'name' => $vendorNames[array_rand($vendorNames)] . ' ' . rand(1, 999),
                    'email' => 'vendor' . $globalCounter . '@example.com',
                    'phone' => '+1 ' . rand(200, 999) . ' ' . rand(100, 999) . ' ' . rand(1000, 9999),
                    'vendor_type' => $type,
                    'payment_terms_days' => [30, 45, 60, 90][array_rand([30, 45, 60, 90])],
                    'lead_time_days' => rand(7, 30),
                    'tax_id' => rand(10, 99) . '-' . rand(1000000, 9999999),
                    'status' => $statuses[array_rand($statuses)],
                    'notes' => 'Reliable ' . $type . ' since ' . rand(2010, 2023),
                ]);

                // Create billing address
                $cityIndex = array_rand($cities);
                Address::create([
                    'addressable_type' => Vendor::class,
                    'addressable_id' => $vendor->id,
                    'address_type' => 'billing',
                    'is_default' => true,
                    'contact_person' => 'Accounts Payable',
                    'phone' => '+1 ' . rand(200, 999) . ' ' . rand(100, 999) . ' ' . rand(1000, 9999),
                    'address_line_1' => rand(100, 9999) . ' Commerce Drive',
                    'city' => $cities[$cityIndex],
                    'state' => $states[$cityIndex],
                    'zip_code' => rand(10000, 99999),
                    'country' => 'USA',
                ]);

                // Create shipping address (warehouse)
                $cityIndex = array_rand($cities);
                Address::create([
                    'addressable_type' => Vendor::class,
                    'addressable_id' => $vendor->id,
                    'address_type' => 'warehouse',
                    'is_default' => true,
                    'contact_person' => 'Warehouse Manager',
                    'phone' => '+1 ' . rand(200, 999) . ' ' . rand(100, 999) . ' ' . rand(1000, 9999),
                    'address_line_1' => rand(100, 9999) . ' Distribution Pkwy',
                    'city' => $cities[$cityIndex],
                    'state' => $states[$cityIndex],
                    'zip_code' => rand(10000, 99999),
                    'country' => 'USA',
                ]);

                $globalCounter++;
            }

            $this->command->info("✅ Created {$count} vendors for {$company->name}");
        }
    }
}
