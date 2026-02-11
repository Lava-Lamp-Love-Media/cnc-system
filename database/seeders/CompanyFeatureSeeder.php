<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanyFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $companyFeatures = [
            // Company 1 has all features
            ['company_id' => 1, 'feature_id' => 1],
            ['company_id' => 1, 'feature_id' => 2],
            ['company_id' => 1, 'feature_id' => 3],
            ['company_id' => 1, 'feature_id' => 4],
            ['company_id' => 1, 'feature_id' => 5],

            // Company 2 has limited features
            ['company_id' => 2, 'feature_id' => 1],
            ['company_id' => 2, 'feature_id' => 2],
        ];

        foreach ($companyFeatures as $data) {
            DB::table('company_feature')->insert([
                'company_id' => $data['company_id'],
                'feature_id' => $data['feature_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
