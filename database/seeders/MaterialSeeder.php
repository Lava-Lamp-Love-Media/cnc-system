<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Material;
use App\Models\Company;

class MaterialSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            // Check if materials already exist for this company
            $existingCount = Material::where('company_id', $company->id)->count();

            if ($existingCount > 0) {
                $this->command->warn("⚠️  Materials already exist for company: {$company->name}. Skipping...");
                continue;
            }

            $materials = [

                // ── Carbon Steel ──────────────────────────────────────────
                [
                    'material_code' => "MAT-1018-S-{$company->id}",
                    'name'          => '1018-1022',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 1.60000,
                    'diameter_to'   => 3.50000,
                    'price'         => 4.00,
                    'adj'           => 2.50,
                    'adj_type'      => 'amount',
                    'density'       => 7930.00,
                    'code'          => 'V',
                    'sort_order'    => 1,
                    'notes'         => '1018-1022 grade carbon steel, small diameter range',
                ],
                [
                    'material_code' => "MAT-1018-M-{$company->id}",
                    'name'          => '1018-1022',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 3.60000,
                    'diameter_to'   => 4.10000,
                    'price'         => 4.00,
                    'adj'           => 2.50,
                    'adj_type'      => 'amount',
                    'density'       => 7930.00,
                    'code'          => 'V',
                    'sort_order'    => 2,
                    'notes'         => '1018-1022 grade carbon steel, medium diameter range',
                ],
                [
                    'material_code' => "MAT-1018-L-{$company->id}",
                    'name'          => '1018-1022',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 27.20000,
                    'diameter_to'   => 39.00000,
                    'price'         => 4.00,
                    'adj'           => 2.50,
                    'adj_type'      => 'amount',
                    'density'       => 7930.00,
                    'code'          => 'V',
                    'sort_order'    => 3,
                    'notes'         => '1018-1022 grade carbon steel, large diameter range',
                ],
                [
                    'material_code' => "MAT-4140-S-{$company->id}",
                    'name'          => '4140 Chrome Moly Steel',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 1.00000,
                    'diameter_to'   => 25.00000,
                    'price'         => 5.50,
                    'adj'           => 3.00,
                    'adj_type'      => 'amount',
                    'density'       => 7850.00,
                    'code'          => 'CM',
                    'sort_order'    => 4,
                    'notes'         => 'High-strength chrome moly steel for demanding applications',
                ],
                [
                    'material_code' => "MAT-4140-L-{$company->id}",
                    'name'          => '4140 Chrome Moly Steel',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 25.00001,
                    'diameter_to'   => 100.00000,
                    'price'         => 5.00,
                    'adj'           => 2.50,
                    'adj_type'      => 'amount',
                    'density'       => 7850.00,
                    'code'          => 'CM',
                    'sort_order'    => 5,
                    'notes'         => '4140 chrome moly steel, large diameter range',
                ],

                // ── Stainless Steel ───────────────────────────────────────
                [
                    'material_code' => "MAT-303SS-S-{$company->id}",
                    'name'          => '303 Stainless Steel',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 1.00000,
                    'diameter_to'   => 20.00000,
                    'price'         => 9.50,
                    'adj'           => 4.00,
                    'adj_type'      => 'amount',
                    'density'       => 8000.00,
                    'code'          => 'SS',
                    'sort_order'    => 6,
                    'notes'         => '303 free-machining stainless, excellent for turned parts',
                ],
                [
                    'material_code' => "MAT-304SS-{$company->id}",
                    'name'          => '304 Stainless Steel',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 1.00000,
                    'diameter_to'   => 50.00000,
                    'price'         => 10.00,
                    'adj'           => 4.50,
                    'adj_type'      => 'amount',
                    'density'       => 8000.00,
                    'code'          => 'SS',
                    'sort_order'    => 7,
                    'notes'         => '304 austenitic stainless steel, general purpose',
                ],
                [
                    'material_code' => "MAT-316SS-{$company->id}",
                    'name'          => '316 Stainless Steel',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 1.00000,
                    'diameter_to'   => 50.00000,
                    'price'         => 13.00,
                    'adj'           => 5.00,
                    'adj_type'      => 'amount',
                    'density'       => 8000.00,
                    'code'          => 'SS',
                    'sort_order'    => 8,
                    'notes'         => '316 marine grade stainless, corrosion resistant',
                ],

                // ── Aluminum ──────────────────────────────────────────────
                [
                    'material_code' => "MAT-6061-S-{$company->id}",
                    'name'          => '6061 Aluminum',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 1.00000,
                    'diameter_to'   => 30.00000,
                    'price'         => 6.50,
                    'adj'           => 2.00,
                    'adj_type'      => 'amount',
                    'density'       => 2700.00,
                    'code'          => 'AL',
                    'sort_order'    => 9,
                    'notes'         => '6061-T6 aluminum, most common alloy for machining',
                ],
                [
                    'material_code' => "MAT-7075-{$company->id}",
                    'name'          => '7075 Aluminum',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 1.00000,
                    'diameter_to'   => 50.00000,
                    'price'         => 12.00,
                    'adj'           => 3.50,
                    'adj_type'      => 'amount',
                    'density'       => 2810.00,
                    'code'          => 'AL',
                    'sort_order'    => 10,
                    'notes'         => '7075 high-strength aerospace aluminum',
                ],

                // ── Brass ─────────────────────────────────────────────────
                [
                    'material_code' => "MAT-C360-{$company->id}",
                    'name'          => 'C360 Brass',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 1.00000,
                    'diameter_to'   => 40.00000,
                    'price'         => 11.00,
                    'adj'           => 4.00,
                    'adj_type'      => 'amount',
                    'density'       => 8520.00,
                    'code'          => 'BR',
                    'sort_order'    => 11,
                    'notes'         => 'C360 free-cutting brass, excellent machinability',
                ],

                // ── Titanium ──────────────────────────────────────────────
                [
                    'material_code' => "MAT-TI6AL-{$company->id}",
                    'name'          => 'Ti-6Al-4V Titanium',
                    'type'          => 'metal_alloy',
                    'unit'          => 'mm',
                    'diameter_from' => 1.00000,
                    'diameter_to'   => 30.00000,
                    'price'         => 65.00,
                    'adj'           => 10.00,
                    'adj_type'      => 'amount',
                    'density'       => 4430.00,
                    'code'          => 'TI',
                    'sort_order'    => 12,
                    'notes'         => 'Grade 5 titanium alloy, aerospace and medical grade',
                ],

                // ── Inch units ────────────────────────────────────────────
                [
                    'material_code' => "MAT-1018-IN-S-{$company->id}",
                    'name'          => '1018-1022 Steel (Inch)',
                    'type'          => 'metal_alloy',
                    'unit'          => 'inch',
                    'diameter_from' => 0.06250,
                    'diameter_to'   => 0.50000,
                    'price'         => 4.00,
                    'adj'           => 2.50,
                    'adj_type'      => 'amount',
                    'density'       => 0.28400,
                    'code'          => 'V',
                    'sort_order'    => 13,
                    'notes'         => '1018 carbon steel, inch units, small diameter',
                ],
                [
                    'material_code' => "MAT-1018-IN-L-{$company->id}",
                    'name'          => '1018-1022 Steel (Inch)',
                    'type'          => 'metal_alloy',
                    'unit'          => 'inch',
                    'diameter_from' => 0.50001,
                    'diameter_to'   => 2.00000,
                    'price'         => 3.80,
                    'adj'           => 2.00,
                    'adj_type'      => 'amount',
                    'density'       => 0.28400,
                    'code'          => 'V',
                    'sort_order'    => 14,
                    'notes'         => '1018 carbon steel, inch units, larger diameter',
                ],
                [
                    'material_code' => "MAT-6061-IN-{$company->id}",
                    'name'          => '6061 Aluminum (Inch)',
                    'type'          => 'metal_alloy',
                    'unit'          => 'inch',
                    'diameter_from' => 0.06250,
                    'diameter_to'   => 2.00000,
                    'price'         => 6.20,
                    'adj'           => 2.00,
                    'adj_type'      => 'amount',
                    'density'       => 0.09800,
                    'code'          => 'AL',
                    'sort_order'    => 15,
                    'notes'         => '6061-T6 aluminum, inch units',
                ],
            ];

            foreach ($materials as $material) {
                Material::create(array_merge($material, [
                    'company_id' => $company->id,
                    'status'     => 'active',
                ]));
            }

            $this->command->info("✅ Materials seeded for company: {$company->name} (" . count($materials) . " records)");
        }
    }
}
