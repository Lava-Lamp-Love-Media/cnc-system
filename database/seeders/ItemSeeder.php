<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Company;
use App\Models\Warehouse;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            if (Item::where('company_id', $company->id)->exists()) {
                $this->command->warn("Company {$company->name} already has items. Skipping...");
                continue;
            }

            $warehouses  = Warehouse::where('company_id', $company->id)->pluck('id')->toArray();
            $warehouseId = !empty($warehouses) ? $warehouses[0] : null;
            $pfx         = strtoupper(substr($company->slug ?? $company->name, 0, 3));

            // ── Tooling ────────────────────────────────────────
            $toolingItems = [
                [
                    'name'          => 'End Mill 1/4"',
                    'description'   => 'Carbide end mill for precision machining',
                    'sku'           => "{$pfx}-TOOL-EM-001",
                    'class'         => 'tooling',
                    'unit'          => 'each',
                    'count'         => 25,
                    'cost_price'    => 45.00,
                    'sell_price'    => 65.00,
                    'stock_min'     => 5,
                    'reorder_level' => 10,
                    'current_stock' => 25,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Drill Bit Set HSS',
                    'description'   => 'High-speed steel drill bit set 1/16" to 1/2"',
                    'sku'           => "{$pfx}-TOOL-DB-002",
                    'class'         => 'tooling',
                    'unit'          => 'each',
                    'count'         => 15,
                    'cost_price'    => 120.00,
                    'sell_price'    => 180.00,
                    'stock_min'     => 3,
                    'reorder_level' => 5,
                    'current_stock' => 15,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Tap Set M6',
                    'description'   => 'M6 metric tap set — plug, taper, bottoming',
                    'sku'           => "{$pfx}-TOOL-TAP-003",
                    'class'         => 'tooling',
                    'unit'          => 'each',
                    'count'         => 8,
                    'cost_price'    => 35.00,
                    'sell_price'    => 55.00,
                    'stock_min'     => 2,
                    'reorder_level' => 4,
                    'current_stock' => 8,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Collet ER32 1/2"',
                    'description'   => 'ER32 precision collet 1/2 inch',
                    'sku'           => "{$pfx}-TOOL-COL-004",
                    'class'         => 'tooling',
                    'unit'          => 'each',
                    'count'         => 12,
                    'cost_price'    => 18.00,
                    'sell_price'    => 28.00,
                    'stock_min'     => 3,
                    'reorder_level' => 6,
                    'current_stock' => 12,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Face Mill 3" Insert',
                    'description'   => '3-inch face mill with carbide inserts',
                    'sku'           => "{$pfx}-TOOL-FM-005",
                    'class'         => 'tooling',
                    'unit'          => 'each',
                    'count'         => 4,
                    'cost_price'    => 185.00,
                    'sell_price'    => 280.00,
                    'stock_min'     => 1,
                    'reorder_level' => 2,
                    'current_stock' => 4,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Boring Bar 1" Shank',
                    'description'   => 'Carbide tipped boring bar — discontinued line',
                    'sku'           => "{$pfx}-TOOL-BB-006",
                    'class'         => 'tooling',
                    'unit'          => 'each',
                    'count'         => 2,
                    'cost_price'    => 95.00,
                    'sell_price'    => 140.00,
                    'stock_min'     => 1,
                    'reorder_level' => 1,
                    'current_stock' => 2,
                    'status'        => 'discontinued', // ← discontinued example
                ],
            ];

            // ── Raw Stock ──────────────────────────────────────
            $rawStockItems = [
                [
                    'name'          => 'Aluminum 6061 Bar 1" × 12"',
                    'description'   => '6061-T6 aluminum bar stock',
                    'sku'           => "{$pfx}-RAW-AL-001",
                    'class'         => 'raw_stock',
                    'unit'          => 'foot',
                    'count'         => 50,
                    'cost_price'    => 8.50,
                    'sell_price'    => 15.00,
                    'stock_min'     => 10,
                    'reorder_level' => 20,
                    'current_stock' => 50,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Steel 4140 Round Bar 2"',
                    'description'   => '4140 alloy steel round bar',
                    'sku'           => "{$pfx}-RAW-ST-002",
                    'class'         => 'raw_stock',
                    'unit'          => 'foot',
                    'count'         => 30,
                    'cost_price'    => 12.00,
                    'sell_price'    => 22.00,
                    'stock_min'     => 8,
                    'reorder_level' => 15,
                    'current_stock' => 30,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Brass C360 Hex Bar 1"',
                    'description'   => 'Free-cutting brass hex bar',
                    'sku'           => "{$pfx}-RAW-BR-003",
                    'class'         => 'raw_stock',
                    'unit'          => 'foot',
                    'count'         => 20,
                    'cost_price'    => 15.00,
                    'sell_price'    => 28.00,
                    'stock_min'     => 5,
                    'reorder_level' => 10,
                    'current_stock' => 20,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Stainless 316 Plate 1/4"',
                    'description'   => '316 stainless steel plate 12" × 12"',
                    'sku'           => "{$pfx}-RAW-SS-004",
                    'class'         => 'raw_stock',
                    'unit'          => 'each',
                    'count'         => 15,
                    'cost_price'    => 45.00,
                    'sell_price'    => 75.00,
                    'stock_min'     => 3,
                    'reorder_level' => 8,
                    'current_stock' => 15,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Titanium Grade 5 Bar 1"',
                    'description'   => 'Ti-6Al-4V round bar — inactive pending supplier',
                    'sku'           => "{$pfx}-RAW-TI-005",
                    'class'         => 'raw_stock',
                    'unit'          => 'foot',
                    'count'         => 0,
                    'cost_price'    => 110.00,
                    'sell_price'    => 185.00,
                    'stock_min'     => 2,
                    'reorder_level' => 5,
                    'current_stock' => 0,
                    'status'        => 'inactive', // ← inactive example
                ],
            ];

            // ── Consumables ────────────────────────────────────
            $consumableItems = [
                [
                    'name'          => 'Cutting Fluid 5L',
                    'description'   => 'Water-soluble cutting fluid',
                    'sku'           => "{$pfx}-CONS-CF-001",
                    'class'         => 'consommable',
                    'unit'          => 'liter',
                    'count'         => 40,
                    'cost_price'    => 25.00,
                    'sell_price'    => 45.00,
                    'stock_min'     => 10,
                    'reorder_level' => 20,
                    'current_stock' => 40,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Shop Towels (Box)',
                    'description'   => 'Industrial shop towels — 200 count',
                    'sku'           => "{$pfx}-CONS-ST-002",
                    'class'         => 'consommable',
                    'unit'          => 'each',
                    'count'         => 25,
                    'cost_price'    => 12.00,
                    'sell_price'    => 20.00,
                    'stock_min'     => 5,
                    'reorder_level' => 10,
                    'current_stock' => 25,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Safety Gloves (Pair)',
                    'description'   => 'Cut-resistant safety gloves',
                    'sku'           => "{$pfx}-CONS-SG-003",
                    'class'         => 'consommable',
                    'unit'          => 'each',
                    'count'         => 50,
                    'cost_price'    => 8.00,
                    'sell_price'    => 15.00,
                    'stock_min'     => 15,
                    'reorder_level' => 30,
                    'current_stock' => 50,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Sandpaper Assortment',
                    'description'   => 'Assorted grit sandpaper pack',
                    'sku'           => "{$pfx}-CONS-SA-004",
                    'class'         => 'consommable',
                    'unit'          => 'each',
                    'count'         => 30,
                    'cost_price'    => 15.00,
                    'sell_price'    => 25.00,
                    'stock_min'     => 8,
                    'reorder_level' => 15,
                    'current_stock' => 30,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Coolant Concentrate 20L',
                    'description'   => 'Semi-synthetic coolant concentrate',
                    'sku'           => "{$pfx}-CONS-CC-005",
                    'class'         => 'consommable',
                    'unit'          => 'liter',
                    'count'         => 60,
                    'cost_price'    => 42.00,
                    'sell_price'    => 68.00,
                    'stock_min'     => 20,
                    'reorder_level' => 40,
                    'current_stock' => 60,
                    'status'        => 'active',
                ],
            ];

            // ── Sellable ───────────────────────────────────────
            $sellableItems = [
                [
                    'name'          => 'Custom Machined Bushing',
                    'description'   => 'Precision machined brass bushing',
                    'sku'           => "{$pfx}-SELL-BU-001",
                    'class'         => 'sellable',
                    'unit'          => 'each',
                    'count'         => 100,
                    'cost_price'    => 5.50,
                    'sell_price'    => 12.00,
                    'stock_min'     => 20,
                    'reorder_level' => 50,
                    'current_stock' => 100,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Aluminum Spacer 1/2"',
                    'description'   => 'CNC machined aluminum spacer',
                    'sku'           => "{$pfx}-SELL-SP-002",
                    'class'         => 'sellable',
                    'unit'          => 'each',
                    'count'         => 200,
                    'cost_price'    => 2.50,
                    'sell_price'    => 6.00,
                    'stock_min'     => 50,
                    'reorder_level' => 100,
                    'current_stock' => 200,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Steel Pin 1/4" × 2"',
                    'description'   => 'Hardened steel dowel pin',
                    'sku'           => "{$pfx}-SELL-PIN-003",
                    'class'         => 'sellable',
                    'unit'          => 'each',
                    'count'         => 500,
                    'cost_price'    => 0.75,
                    'sell_price'    => 1.50,
                    'stock_min'     => 100,
                    'reorder_level' => 250,
                    'current_stock' => 500,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Custom Bracket Assembly',
                    'description'   => 'Welded steel bracket with powder coat',
                    'sku'           => "{$pfx}-SELL-BRK-004",
                    'class'         => 'sellable',
                    'unit'          => 'each',
                    'count'         => 75,
                    'cost_price'    => 18.00,
                    'sell_price'    => 35.00,
                    'stock_min'     => 15,
                    'reorder_level' => 30,
                    'current_stock' => 75,
                    'status'        => 'active',
                ],
                [
                    'name'          => 'Stainless Shaft 12mm × 300mm',
                    'description'   => '316 stainless precision ground shaft',
                    'sku'           => "{$pfx}-SELL-SH-005",
                    'class'         => 'sellable',
                    'unit'          => 'each',
                    'count'         => 40,
                    'cost_price'    => 22.00,
                    'sell_price'    => 42.00,
                    'stock_min'     => 10,
                    'reorder_level' => 20,
                    'current_stock' => 40,
                    'status'        => 'active',
                ],
            ];

            // ── Low stock items (for alert testing) ────────────
            $lowStockItems = [
                [
                    'name'          => 'Cutting Oil Premium',
                    'description'   => 'Premium synthetic cutting oil',
                    'sku'           => "{$pfx}-CONS-CO-LOW1",
                    'class'         => 'consommable',
                    'unit'          => 'liter',
                    'count'         => 3,
                    'cost_price'    => 35.00,
                    'sell_price'    => 55.00,
                    'stock_min'     => 10,
                    'reorder_level' => 15,
                    'current_stock' => 3,   // LOW STOCK
                    'status'        => 'active',
                ],
                [
                    'name'          => 'End Mill 1/8" Carbide',
                    'description'   => 'Carbide end mill for precision work',
                    'sku'           => "{$pfx}-TOOL-EM-LOW2",
                    'class'         => 'tooling',
                    'unit'          => 'each',
                    'count'         => 2,
                    'cost_price'    => 38.00,
                    'sell_price'    => 58.00,
                    'stock_min'     => 5,
                    'reorder_level' => 8,
                    'current_stock' => 2,   // LOW STOCK
                    'status'        => 'active',
                ],
            ];

            // ── Merge and create ───────────────────────────────
            $allItems = array_merge(
                $toolingItems,
                $rawStockItems,
                $consumableItems,
                $sellableItems,
                $lowStockItems
            );

            foreach ($allItems as $itemData) {
                Item::create(array_merge($itemData, [
                    'company_id'   => $company->id,
                    'warehouse_id' => $warehouseId,
                    'is_inventory' => true,
                    'is_taxable'   => true,
                ]));
            }

            $count = count($allItems);
            $this->command->info("✓ Created {$count} items for {$company->name}");
        }

        $this->command->info('✅ ItemSeeder complete.');
    }
}
