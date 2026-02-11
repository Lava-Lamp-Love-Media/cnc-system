<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Plan;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $pro = Plan::where('slug', 'pro')->firstOrFail();
        $starter = Plan::where('slug', 'starter')->firstOrFail();

        Company::updateOrCreate(['email' => 'info@cnc.com'], [
            'plan_id' => $pro->id,
            'name' => 'CNC Manufacturing Ltd',
            'phone' => '1234567890',
            'address' => 'SFO3',
            'status' => 'active',
            'subscription_start' => now()->toDateString(),
            'subscription_end' => now()->addYear()->toDateString(),
        ]);

        Company::updateOrCreate(['email' => 'contact@precision.com'], [
            'plan_id' => $starter->id,
            'name' => 'Precision Tools Inc',
            'phone' => '9876543210',
            'address' => 'California',
            'status' => 'trial',
            'subscription_start' => now()->toDateString(),
            'subscription_end' => now()->addDays(30)->toDateString(),
        ]);
    }
}
