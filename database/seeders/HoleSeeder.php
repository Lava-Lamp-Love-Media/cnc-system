<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hole;
use App\Models\Company;

class HoleSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // ✅ Check if holes already exist for this company
            $existingCount = Hole::where('company_id', $company->id)->count();

            if ($existingCount > 0) {
                $this->command->warn("⚠️  Holes already exist for company: {$company->name}. Skipping...");
                continue;
            }

            $holes = [
                // Through Holes - Common Sizes
                [
                    'hole_code' => "HOLE-3.0-THRU-{$company->id}",
                    'name' => 'Ø3.0mm Through Hole',
                    'size' => 3.00,
                    'hole_type' => 'through',
                    'unit_price' => 2.50,
                    'description' => 'Standard through hole for M3 clearance',
                    'sort_order' => 1
                ],
                [
                    'hole_code' => "HOLE-4.0-THRU-{$company->id}",
                    'name' => 'Ø4.0mm Through Hole',
                    'size' => 4.00,
                    'hole_type' => 'through',
                    'unit_price' => 3.00,
                    'description' => 'Through hole for M4 clearance',
                    'sort_order' => 2
                ],
                [
                    'hole_code' => "HOLE-5.0-THRU-{$company->id}",
                    'name' => 'Ø5.0mm Through Hole',
                    'size' => 5.00,
                    'hole_type' => 'through',
                    'unit_price' => 3.50,
                    'description' => 'Through hole for M5 clearance',
                    'sort_order' => 3
                ],
                [
                    'hole_code' => "HOLE-6.0-THRU-{$company->id}",
                    'name' => 'Ø6.0mm Through Hole',
                    'size' => 6.00,
                    'hole_type' => 'through',
                    'unit_price' => 3.75,
                    'description' => 'Through hole for M6 clearance',
                    'sort_order' => 4
                ],
                [
                    'hole_code' => "HOLE-6.8-THRU-{$company->id}",
                    'name' => 'Ø6.8mm Through Hole',
                    'size' => 6.80,
                    'hole_type' => 'through',
                    'unit_price' => 4.00,
                    'description' => 'Pilot hole for M8 tap',
                    'sort_order' => 5
                ],
                [
                    'hole_code' => "HOLE-8.0-THRU-{$company->id}",
                    'name' => 'Ø8.0mm Through Hole',
                    'size' => 8.00,
                    'hole_type' => 'through',
                    'unit_price' => 4.50,
                    'description' => 'Standard 8mm through hole',
                    'sort_order' => 6
                ],
                [
                    'hole_code' => "HOLE-8.5-THRU-{$company->id}",
                    'name' => 'Ø8.5mm Through Hole',
                    'size' => 8.50,
                    'hole_type' => 'through',
                    'unit_price' => 5.00,
                    'description' => 'Clearance hole for M10 bolt',
                    'sort_order' => 7
                ],
                [
                    'hole_code' => "HOLE-10.0-THRU-{$company->id}",
                    'name' => 'Ø10.0mm Through Hole',
                    'size' => 10.00,
                    'hole_type' => 'through',
                    'unit_price' => 6.00,
                    'description' => 'Standard 10mm through hole',
                    'sort_order' => 8
                ],
                [
                    'hole_code' => "HOLE-10.2-THRU-{$company->id}",
                    'name' => 'Ø10.2mm Through Hole',
                    'size' => 10.20,
                    'hole_type' => 'through',
                    'unit_price' => 6.25,
                    'description' => 'Pilot hole for M12 tap',
                    'sort_order' => 9
                ],
                [
                    'hole_code' => "HOLE-12.0-THRU-{$company->id}",
                    'name' => 'Ø12.0mm Through Hole',
                    'size' => 12.00,
                    'hole_type' => 'through',
                    'unit_price' => 7.50,
                    'description' => 'Large through hole',
                    'sort_order' => 10
                ],

                // Blind Holes
                [
                    'hole_code' => "HOLE-5.0-BLIND-{$company->id}",
                    'name' => 'Ø5.0mm × 15mm Blind Hole',
                    'size' => 5.00,
                    'hole_type' => 'blind',
                    'unit_price' => 4.50,
                    'description' => 'Blind hole 15mm deep for M6 tap',
                    'sort_order' => 11
                ],
                [
                    'hole_code' => "HOLE-6.8-BLIND-{$company->id}",
                    'name' => 'Ø6.8mm × 20mm Blind Hole',
                    'size' => 6.80,
                    'hole_type' => 'blind',
                    'unit_price' => 5.50,
                    'description' => 'Pilot hole for M8 tap (blind) 20mm deep',
                    'sort_order' => 12
                ],
                [
                    'hole_code' => "HOLE-8.5-BLIND-{$company->id}",
                    'name' => 'Ø8.5mm × 25mm Blind Hole',
                    'size' => 8.50,
                    'hole_type' => 'blind',
                    'unit_price' => 6.50,
                    'description' => 'Pilot hole for M10 tap (blind) 25mm deep',
                    'sort_order' => 13
                ],

                // Countersink Holes
                [
                    'hole_code' => "HOLE-5.0-CSK-{$company->id}",
                    'name' => 'Ø5.0mm with 90° Countersink',
                    'size' => 5.00,
                    'hole_type' => 'countersink',
                    'unit_price' => 5.50,
                    'description' => 'For M5 flat head screws',
                    'sort_order' => 14
                ],
                [
                    'hole_code' => "HOLE-8.0-CSK-{$company->id}",
                    'name' => 'Ø8.0mm with 90° Countersink',
                    'size' => 8.00,
                    'hole_type' => 'countersink',
                    'unit_price' => 7.00,
                    'description' => 'For M8 flat head screws',
                    'sort_order' => 15
                ],

                // Counterbore Holes
                [
                    'hole_code' => "HOLE-6.0-CBORE-{$company->id}",
                    'name' => 'Ø6.0mm with Counterbore',
                    'size' => 6.00,
                    'hole_type' => 'counterbore',
                    'unit_price' => 6.50,
                    'description' => 'For M6 socket head cap screws',
                    'sort_order' => 16
                ],
                [
                    'hole_code' => "HOLE-8.0-CBORE-{$company->id}",
                    'name' => 'Ø8.0mm with Counterbore',
                    'size' => 8.00,
                    'hole_type' => 'counterbore',
                    'unit_price' => 7.50,
                    'description' => 'For M8 socket head cap screws',
                    'sort_order' => 17
                ],
            ];

            foreach ($holes as $hole) {
                Hole::create(array_merge($hole, [
                    'company_id' => $company->id,
                    'status' => 'active'
                ]));
            }

            $this->command->info("✅ Holes seeded for company: {$company->name}");
        }
    }
}
