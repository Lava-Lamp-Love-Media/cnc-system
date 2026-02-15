<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tap;
use App\Models\Company;

class TapSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // Check if taps already exist for this company
            $existingCount = Tap::where('company_id', $company->id)->count();

            if ($existingCount > 0) {
                $this->command->warn("⚠️  Taps already exist for company: {$company->name}. Skipping...");
                continue;
            }

            $taps = [
                // ========== METRIC TAPS ==========

                // M3 Tap
                [
                    'tap_code' => "TAP-M3-0.5-{$company->id}",
                    'name' => 'M3×0.5 Tap',
                    'diameter' => 3.00,
                    'pitch' => 0.50,
                    'thread_standard' => 'metric',
                    'thread_class' => '6H',
                    'direction' => 'right',
                    'thread_sizes' => ['M3×0.5'],
                    'thread_options' => ['internal'],
                    'tap_price' => 8.00,
                    'thread_option_price' => 2.00,
                    'pitch_price' => 1.50,
                    'class_price' => 1.00,
                    'size_price' => 0.50,
                    'description' => 'Fine pitch metric tap for M3 threads',
                    'sort_order' => 1
                ],

                // M4 Tap
                [
                    'tap_code' => "TAP-M4-0.7-{$company->id}",
                    'name' => 'M4×0.7 Tap',
                    'diameter' => 4.00,
                    'pitch' => 0.70,
                    'thread_standard' => 'metric',
                    'thread_class' => '6H',
                    'direction' => 'right',
                    'thread_sizes' => ['M4×0.7'],
                    'thread_options' => ['internal'],
                    'tap_price' => 9.00,
                    'thread_option_price' => 2.00,
                    'pitch_price' => 1.50,
                    'class_price' => 1.00,
                    'size_price' => 0.50,
                    'description' => 'Standard M4 tap',
                    'sort_order' => 2
                ],

                // M5 Tap
                [
                    'tap_code' => "TAP-M5-0.8-{$company->id}",
                    'name' => 'M5×0.8 Tap',
                    'diameter' => 5.00,
                    'pitch' => 0.80,
                    'thread_standard' => 'metric',
                    'thread_class' => '6H',
                    'direction' => 'right',
                    'thread_sizes' => ['M5×0.8'],
                    'thread_options' => ['internal'],
                    'tap_price' => 10.00,
                    'thread_option_price' => 2.00,
                    'pitch_price' => 1.50,
                    'class_price' => 1.00,
                    'size_price' => 0.50,
                    'description' => 'Standard M5 tap',
                    'sort_order' => 3
                ],

                // M6 Tap
                [
                    'tap_code' => "TAP-M6-1.0-{$company->id}",
                    'name' => 'M6×1.0 Tap',
                    'diameter' => 6.00,
                    'pitch' => 1.00,
                    'thread_standard' => 'metric',
                    'thread_class' => '6H',
                    'direction' => 'right',
                    'thread_sizes' => ['M6×1.0'],
                    'thread_options' => ['internal'],
                    'tap_price' => 11.00,
                    'thread_option_price' => 2.50,
                    'pitch_price' => 2.00,
                    'class_price' => 1.50,
                    'size_price' => 0.75,
                    'description' => 'Standard M6 tap - most common',
                    'sort_order' => 4
                ],

                // M8 Tap (MOST COMMON)
                [
                    'tap_code' => "TAP-M8-1.25-{$company->id}",
                    'name' => 'M8×1.25 Tap',
                    'diameter' => 8.00,
                    'pitch' => 1.25,
                    'thread_standard' => 'metric',
                    'thread_class' => '6H',
                    'direction' => 'right',
                    'thread_sizes' => ['M8×1.25', 'M8×1.0'],
                    'thread_options' => ['internal'],
                    'tap_price' => 12.00,
                    'thread_option_price' => 3.00,
                    'pitch_price' => 2.50,
                    'class_price' => 2.00,
                    'size_price' => 1.00,
                    'description' => 'M8 coarse pitch tap - very common size',
                    'sort_order' => 5
                ],

                // M10 Tap
                [
                    'tap_code' => "TAP-M10-1.5-{$company->id}",
                    'name' => 'M10×1.5 Tap',
                    'diameter' => 10.00,
                    'pitch' => 1.50,
                    'thread_standard' => 'metric',
                    'thread_class' => '6H',
                    'direction' => 'right',
                    'thread_sizes' => ['M10×1.5', 'M10×1.25'],
                    'thread_options' => ['internal'],
                    'tap_price' => 14.00,
                    'thread_option_price' => 3.50,
                    'pitch_price' => 3.00,
                    'class_price' => 2.50,
                    'size_price' => 1.25,
                    'description' => 'M10 coarse pitch tap',
                    'sort_order' => 6
                ],

                // M12 Tap
                [
                    'tap_code' => "TAP-M12-1.75-{$company->id}",
                    'name' => 'M12×1.75 Tap',
                    'diameter' => 12.00,
                    'pitch' => 1.75,
                    'thread_standard' => 'metric',
                    'thread_class' => '6H',
                    'direction' => 'right',
                    'thread_sizes' => ['M12×1.75', 'M12×1.5'],
                    'thread_options' => ['internal'],
                    'tap_price' => 16.00,
                    'thread_option_price' => 4.00,
                    'pitch_price' => 3.50,
                    'class_price' => 3.00,
                    'size_price' => 1.50,
                    'description' => 'M12 coarse pitch tap',
                    'sort_order' => 7
                ],

                // M16 Tap
                [
                    'tap_code' => "TAP-M16-2.0-{$company->id}",
                    'name' => 'M16×2.0 Tap',
                    'diameter' => 16.00,
                    'pitch' => 2.00,
                    'thread_standard' => 'metric',
                    'thread_class' => '6H',
                    'direction' => 'right',
                    'thread_sizes' => ['M16×2.0'],
                    'thread_options' => ['internal'],
                    'tap_price' => 20.00,
                    'thread_option_price' => 5.00,
                    'pitch_price' => 4.00,
                    'class_price' => 3.50,
                    'size_price' => 2.00,
                    'description' => 'M16 coarse pitch tap',
                    'sort_order' => 8
                ],

                // ========== IMPERIAL TAPS (UNC - Unified National Coarse) ==========

                // 1/4-20 UNC
                [
                    'tap_code' => "TAP-1/4-20-UNC-{$company->id}",
                    'name' => '1/4-20 UNC Tap',
                    'diameter' => 6.35, // 1/4" in mm
                    'pitch' => 1.27, // 20 TPI converted
                    'thread_standard' => 'UNC',
                    'thread_class' => '2B',
                    'direction' => 'right',
                    'thread_sizes' => ['1/4-20', '#12-24'],
                    'thread_options' => ['internal'],
                    'tap_price' => 11.50,
                    'thread_option_price' => 2.50,
                    'pitch_price' => 2.00,
                    'class_price' => 1.50,
                    'size_price' => 1.00,
                    'description' => '1/4 inch - 20 threads per inch (UNC)',
                    'sort_order' => 9
                ],

                // 5/16-18 UNC
                [
                    'tap_code' => "TAP-5/16-18-UNC-{$company->id}",
                    'name' => '5/16-18 UNC Tap',
                    'diameter' => 7.94, // 5/16" in mm
                    'pitch' => 1.41, // 18 TPI
                    'thread_standard' => 'UNC',
                    'thread_class' => '2B',
                    'direction' => 'right',
                    'thread_sizes' => ['5/16-18'],
                    'thread_options' => ['internal'],
                    'tap_price' => 13.00,
                    'thread_option_price' => 3.00,
                    'pitch_price' => 2.50,
                    'class_price' => 2.00,
                    'size_price' => 1.25,
                    'description' => '5/16 inch - 18 TPI (UNC)',
                    'sort_order' => 10
                ],

                // 3/8-16 UNC
                [
                    'tap_code' => "TAP-3/8-16-UNC-{$company->id}",
                    'name' => '3/8-16 UNC Tap',
                    'diameter' => 9.53, // 3/8" in mm
                    'pitch' => 1.59, // 16 TPI
                    'thread_standard' => 'UNC',
                    'thread_class' => '2B',
                    'direction' => 'right',
                    'thread_sizes' => ['3/8-16'],
                    'thread_options' => ['internal'],
                    'tap_price' => 14.50,
                    'thread_option_price' => 3.50,
                    'pitch_price' => 3.00,
                    'class_price' => 2.50,
                    'size_price' => 1.50,
                    'description' => '3/8 inch - 16 TPI (UNC)',
                    'sort_order' => 11
                ],

                // ========== IMPERIAL TAPS (UNF - Unified National Fine) ==========

                // 1/4-28 UNF
                [
                    'tap_code' => "TAP-1/4-28-UNF-{$company->id}",
                    'name' => '1/4-28 UNF Tap',
                    'diameter' => 6.35,
                    'pitch' => 0.91, // 28 TPI
                    'thread_standard' => 'UNF',
                    'thread_class' => '2B',
                    'direction' => 'right',
                    'thread_sizes' => ['1/4-28'],
                    'thread_options' => ['internal'],
                    'tap_price' => 12.50,
                    'thread_option_price' => 3.00,
                    'pitch_price' => 2.50,
                    'class_price' => 2.00,
                    'size_price' => 1.25,
                    'description' => '1/4 inch - 28 TPI fine thread (UNF)',
                    'sort_order' => 12
                ],

                // ========== NATIONAL COARSE ==========

                // #10-24
                [
                    'tap_code' => "TAP-10-24-NC-{$company->id}",
                    'name' => '#10-24 Tap',
                    'diameter' => 4.83, // #10 size
                    'pitch' => 1.06, // 24 TPI
                    'thread_standard' => 'national_coarse',
                    'thread_class' => '2B',
                    'direction' => 'right',
                    'thread_sizes' => ['#10-24', '#10-32'],
                    'thread_options' => ['internal'],
                    'tap_price' => 10.00,
                    'thread_option_price' => 2.50,
                    'pitch_price' => 2.00,
                    'class_price' => 1.50,
                    'size_price' => 1.00,
                    'description' => 'Number 10 - 24 TPI National Coarse',
                    'sort_order' => 13
                ],
            ];

            foreach ($taps as $tap) {
                Tap::create(array_merge($tap, [
                    'company_id' => $company->id,
                    'status' => 'active'
                ]));
            }

            $this->command->info("✅ Taps seeded for company: {$company->name}");
        }
    }
}
