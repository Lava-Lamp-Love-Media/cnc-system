<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::updateOrCreate(['slug' => 'free'], [
            'name' => 'Free',
            'price' => 0,
            'billing_cycle' => 'monthly',
            'is_active' => true
        ]);

        Plan::updateOrCreate(['slug' => 'starter'], [
            'name' => 'Starter',
            'price' => 19.99,
            'billing_cycle' => 'monthly',
            'is_active' => true
        ]);

        Plan::updateOrCreate(['slug' => 'pro'], [
            'name' => 'Pro',
            'price' => 49.99,
            'billing_cycle' => 'monthly',
            'is_active' => true
        ]);

        Plan::updateOrCreate(['slug' => 'enterprise'], [
            'name' => 'Enterprise',
            'price' => 199.99,
            'billing_cycle' => 'monthly',
            'is_active' => true
        ]);
    }
}
