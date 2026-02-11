<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Feature;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['name' => 'Quote', 'slug' => 'quote', 'icon' => 'fas fa-file-alt'],
            ['name' => 'Order', 'slug' => 'order', 'icon' => 'fas fa-shopping-cart'],
            ['name' => 'Invoice', 'slug' => 'invoice', 'icon' => 'fas fa-file-invoice'],
            ['name' => 'Manufacture', 'slug' => 'manufacture', 'icon' => 'fas fa-industry'],
            ['name' => 'Inventory', 'slug' => 'inventory', 'icon' => 'fas fa-box'],
        ];

        foreach ($features as $f) {
            Feature::updateOrCreate(['slug' => $f['slug']], [
                'name' => $f['name'],
                'icon' => $f['icon'],
                'description' => $f['name'] . ' Module',
                'is_active' => true,
            ]);
        }
    }
}
