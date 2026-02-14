<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Address;
use App\Models\Company;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        if ($companies->isEmpty()) {
            $this->command->warn('No companies found.');
            return;
        }

        $customerTypes = ['individual', 'company'];
        $statuses = ['active', 'inactive', 'suspended'];
        $companyNames = [
            'Acme Manufacturing',
            'Tech Solutions Inc',
            'Global Industries',
            'Precision Parts Co',
            'Industrial Supplies Ltd',
            'Quality Materials Corp',
            'Advanced Components',
            'Metro Fabrication',
            'Elite Engineering',
        ];
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'Philadelphia'];
        $states = ['NY', 'CA', 'IL', 'TX', 'AZ', 'PA'];

        $globalCounter = 1;

        foreach ($companies as $company) {
            $count = rand(10, 20);

            for ($i = 0; $i < $count; $i++) {
                $type = $customerTypes[array_rand($customerTypes)];
                $name = $type === 'company'
                    ? $companyNames[array_rand($companyNames)] . ' ' . rand(1, 999)
                    : 'Customer ' . $globalCounter;

                $customer = Customer::create([
                    'company_id' => $company->id,
                    'customer_code' => 'CUST-' . str_pad($globalCounter, 5, '0', STR_PAD_LEFT),
                    'name' => $name,
                    'email' => strtolower(str_replace(' ', '', $name)) . '@example.com',
                    'phone' => '+1 ' . rand(200, 999) . ' ' . rand(100, 999) . ' ' . rand(1000, 9999),
                    'customer_type' => $type,
                    'credit_limit' => rand(5000, 100000),
                    'payment_terms_days' => [15, 30, 45, 60][array_rand([15, 30, 45, 60])],
                    'tax_id' => rand(10, 99) . '-' . rand(1000000, 9999999),
                    'status' => $statuses[array_rand($statuses)],
                    'notes' => 'Valued customer since ' . rand(2015, 2024),
                ]);

                // Create billing address
                $cityIndex = array_rand($cities);
                Address::create([
                    'addressable_type' => Customer::class,
                    'addressable_id' => $customer->id,
                    'address_type' => 'billing',
                    'is_default' => true,
                    'contact_person' => 'Billing Manager',
                    'phone' => '+1 ' . rand(200, 999) . ' ' . rand(100, 999) . ' ' . rand(1000, 9999),
                    'address_line_1' => rand(100, 9999) . ' Main Street',
                    'address_line_2' => 'Suite ' . rand(100, 999),
                    'city' => $cities[$cityIndex],
                    'state' => $states[$cityIndex],
                    'zip_code' => rand(10000, 99999),
                    'country' => 'USA',
                ]);

                // Create 1-3 shipping addresses
                $shippingCount = rand(1, 3);
                for ($j = 0; $j < $shippingCount; $j++) {
                    $cityIndex = array_rand($cities);
                    Address::create([
                        'addressable_type' => Customer::class,
                        'addressable_id' => $customer->id,
                        'address_type' => 'shipping',
                        'is_default' => $j === 0,
                        'contact_person' => 'Shipping Contact ' . ($j + 1),
                        'phone' => '+1 ' . rand(200, 999) . ' ' . rand(100, 999) . ' ' . rand(1000, 9999),
                        'address_line_1' => rand(100, 9999) . ' Industrial Blvd',
                        'city' => $cities[$cityIndex],
                        'state' => $states[$cityIndex],
                        'zip_code' => rand(10000, 99999),
                        'country' => 'USA',
                    ]);
                }

                $globalCounter++;
            }

            $this->command->info("✅ Created {$count} customers for {$company->name}");
        }
    }
}
