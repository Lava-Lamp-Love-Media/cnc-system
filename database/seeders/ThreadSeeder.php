<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Thread;
use App\Models\Company;

class ThreadSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // Check if threads already exist for this company
            $existingCount = Thread::where('company_id', $company->id)->count();

            if ($existingCount > 0) {
                $this->command->warn("⚠️  Threads already exist for company: {$company->name}. Skipping...");
                continue;
            }

            $threads = [
                // ========== METRIC EXTERNAL THREADS ==========

                // M6 External
                [
                    'thread_code' => "THR-M6-1.0-EXT-{$company->id}",
                    'name' => 'M6×1.0 External Thread',
                    'thread_type' => 'external',
                    'diameter' => 6.00,
                    'pitch' => 1.00,
                    'thread_standard' => 'metric',
                    'thread_class' => '6g',
                    'direction' => 'right',
                    'thread_sizes' => ['M6×1.0'],
                    'thread_options' => ['standard', 'fine'],
                    'thread_price' => 5.00,
                    'option_price' => 1.00,
                    'pitch_price' => 1.00,
                    'class_price' => 0.50,
                    'size_price' => 0.50,
                    'description' => 'M6 external thread for bolts and screws',
                    'sort_order' => 1
                ],

                // M8 External
                [
                    'thread_code' => "THR-M8-1.25-EXT-{$company->id}",
                    'name' => 'M8×1.25 External Thread',
                    'thread_type' => 'external',
                    'diameter' => 8.00,
                    'pitch' => 1.25,
                    'thread_standard' => 'metric',
                    'thread_class' => '6g',
                    'direction' => 'right',
                    'thread_sizes' => ['M8×1.25', 'M8×1.0'],
                    'thread_options' => ['coarse', 'fine'],
                    'thread_price' => 6.00,
                    'option_price' => 1.50,
                    'pitch_price' => 1.50,
                    'class_price' => 1.00,
                    'size_price' => 0.75,
                    'description' => 'M8 coarse pitch external thread - very common',
                    'sort_order' => 2
                ],

                // M10 External
                [
                    'thread_code' => "THR-M10-1.5-EXT-{$company->id}",
                    'name' => 'M10×1.5 External Thread',
                    'thread_type' => 'external',
                    'diameter' => 10.00,
                    'pitch' => 1.50,
                    'thread_standard' => 'metric',
                    'thread_class' => '6g',
                    'direction' => 'right',
                    'thread_sizes' => ['M10×1.5', 'M10×1.25'],
                    'thread_options' => ['coarse', 'fine'],
                    'thread_price' => 7.00,
                    'option_price' => 2.00,
                    'pitch_price' => 2.00,
                    'class_price' => 1.50,
                    'size_price' => 1.00,
                    'description' => 'M10 coarse pitch external thread',
                    'sort_order' => 3
                ],

                // M12 External
                [
                    'thread_code' => "THR-M12-1.75-EXT-{$company->id}",
                    'name' => 'M12×1.75 External Thread',
                    'thread_type' => 'external',
                    'diameter' => 12.00,
                    'pitch' => 1.75,
                    'thread_standard' => 'metric',
                    'thread_class' => '6g',
                    'direction' => 'right',
                    'thread_sizes' => ['M12×1.75', 'M12×1.5'],
                    'thread_options' => ['coarse', 'fine'],
                    'thread_price' => 8.00,
                    'option_price' => 2.50,
                    'pitch_price' => 2.50,
                    'class_price' => 2.00,
                    'size_price' => 1.25,
                    'description' => 'M12 coarse pitch external thread',
                    'sort_order' => 4
                ],

                // ========== METRIC INTERNAL THREADS ==========

                // M6 Internal
                [
                    'thread_code' => "THR-M6-1.0-INT-{$company->id}",
                    'name' => 'M6×1.0 Internal Thread',
                    'thread_type' => 'internal',
                    'diameter' => 6.00,
                    'pitch' => 1.00,
                    'thread_standard' => 'metric',
                    'thread_class' => '6H',
                    'direction' => 'right',
                    'thread_sizes' => ['M6×1.0'],
                    'thread_options' => ['standard'],
                    'thread_price' => 6.00,
                    'option_price' => 1.50,
                    'pitch_price' => 1.50,
                    'class_price' => 1.00,
                    'size_price' => 0.75,
                    'description' => 'M6 internal thread for nuts and tapped holes',
                    'sort_order' => 5
                ],

                // M8 Internal
                [
                    'thread_code' => "THR-M8-1.25-INT-{$company->id}",
                    'name' => 'M8×1.25 Internal Thread',
                    'thread_type' => 'internal',
                    'diameter' => 8.00,
                    'pitch' => 1.25,
                    'thread_standard' => 'metric',
                    'thread_class' => '6H',
                    'direction' => 'right',
                    'thread_sizes' => ['M8×1.25', 'M8×1.0'],
                    'thread_options' => ['coarse', 'fine'],
                    'thread_price' => 7.00,
                    'option_price' => 2.00,
                    'pitch_price' => 2.00,
                    'class_price' => 1.50,
                    'size_price' => 1.00,
                    'description' => 'M8 internal thread - matches M8 taps',
                    'sort_order' => 6
                ],

                // M10 Internal
                [
                    'thread_code' => "THR-M10-1.5-INT-{$company->id}",
                    'name' => 'M10×1.5 Internal Thread',
                    'thread_type' => 'internal',
                    'diameter' => 10.00,
                    'pitch' => 1.50,
                    'thread_standard' => 'metric',
                    'thread_class' => '6H',
                    'direction' => 'right',
                    'thread_sizes' => ['M10×1.5', 'M10×1.25'],
                    'thread_options' => ['coarse', 'fine'],
                    'thread_price' => 8.50,
                    'option_price' => 2.50,
                    'pitch_price' => 2.50,
                    'class_price' => 2.00,
                    'size_price' => 1.25,
                    'description' => 'M10 internal thread',
                    'sort_order' => 7
                ],

                // ========== IMPERIAL EXTERNAL THREADS (UNC) ==========

                // 1/4-20 UNC External
                [
                    'thread_code' => "THR-1/4-20-UNC-EXT-{$company->id}",
                    'name' => '1/4-20 UNC External Thread',
                    'thread_type' => 'external',
                    'diameter' => 6.35,
                    'pitch' => 1.27,
                    'thread_standard' => 'UNC',
                    'thread_class' => '2A',
                    'direction' => 'right',
                    'thread_sizes' => ['1/4-20'],
                    'thread_options' => ['standard'],
                    'thread_price' => 6.50,
                    'option_price' => 1.50,
                    'pitch_price' => 1.50,
                    'class_price' => 1.00,
                    'size_price' => 1.00,
                    'description' => '1/4 inch - 20 TPI external (UNC)',
                    'sort_order' => 8
                ],

                // 5/16-18 UNC External
                [
                    'thread_code' => "THR-5/16-18-UNC-EXT-{$company->id}",
                    'name' => '5/16-18 UNC External Thread',
                    'thread_type' => 'external',
                    'diameter' => 7.94,
                    'pitch' => 1.41,
                    'thread_standard' => 'UNC',
                    'thread_class' => '2A',
                    'direction' => 'right',
                    'thread_sizes' => ['5/16-18'],
                    'thread_options' => ['standard'],
                    'thread_price' => 7.50,
                    'option_price' => 2.00,
                    'pitch_price' => 2.00,
                    'class_price' => 1.50,
                    'size_price' => 1.25,
                    'description' => '5/16 inch - 18 TPI external (UNC)',
                    'sort_order' => 9
                ],

                // ========== IMPERIAL INTERNAL THREADS (UNC) ==========

                // 1/4-20 UNC Internal
                [
                    'thread_code' => "THR-1/4-20-UNC-INT-{$company->id}",
                    'name' => '1/4-20 UNC Internal Thread',
                    'thread_type' => 'internal',
                    'diameter' => 6.35,
                    'pitch' => 1.27,
                    'thread_standard' => 'UNC',
                    'thread_class' => '2B',
                    'direction' => 'right',
                    'thread_sizes' => ['1/4-20'],
                    'thread_options' => ['standard'],
                    'thread_price' => 7.00,
                    'option_price' => 2.00,
                    'pitch_price' => 2.00,
                    'class_price' => 1.50,
                    'size_price' => 1.25,
                    'description' => '1/4 inch - 20 TPI internal (UNC)',
                    'sort_order' => 10
                ],

                // ========== SPECIAL THREADS ==========

                // Debur Thread (for cleanup)
                [
                    'thread_code' => "THR-DEBUR-{$company->id}",
                    'name' => 'Thread Debur',
                    'thread_type' => 'internal',
                    'diameter' => 0.00,
                    'pitch' => 0.00,
                    'thread_standard' => 'metric',
                    'thread_class' => null,
                    'direction' => 'right',
                    'thread_sizes' => null,
                    'thread_options' => ['cleanup', 'finish'],
                    'thread_price' => 3.00,
                    'option_price' => 1.00,
                    'pitch_price' => 0.00,
                    'class_price' => 0.00,
                    'size_price' => 0.00,
                    'description' => 'Thread cleanup and deburring operation',
                    'sort_order' => 11
                ],
            ];

            foreach ($threads as $thread) {
                Thread::create(array_merge($thread, [
                    'company_id' => $company->id,
                    'status' => 'active'
                ]));
            }

            $this->command->info("✅ Threads seeded for company: {$company->name}");
        }
    }
}
