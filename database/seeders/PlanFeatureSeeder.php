<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\Feature;

class PlanFeatureSeeder extends Seeder
{
    public function run(): void
    {
        $map = [
            'free' => ['quote'],
            'starter' => ['quote', 'order'],
            'pro' => ['quote', 'order', 'invoice', 'inventory'],
            'enterprise' => ['quote', 'order', 'invoice', 'manufacture', 'inventory'],
        ];

        foreach ($map as $planSlug => $featureSlugs) {
            $plan = Plan::where('slug', $planSlug)->firstOrFail();
            $featureIds = Feature::whereIn('slug', $featureSlugs)->pluck('id')->toArray();
            $plan->features()->syncWithoutDetaching($featureIds);
        }
    }
}
