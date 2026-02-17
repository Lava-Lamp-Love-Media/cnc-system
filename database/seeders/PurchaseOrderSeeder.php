<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Company;
use App\Models\Vendor;
use App\Models\Item;
use App\Models\Warehouse;
use Carbon\Carbon;

class PurchaseOrderSeeder extends Seeder
{
    public function run(): void
    {
        $companies = Company::all();

        foreach ($companies as $company) {
            $vendors = Vendor::where('company_id', $company->id)->get();
            $items = Item::where('company_id', $company->id)->get();
            $warehouse = Warehouse::where('company_id', $company->id)->first();

            if ($vendors->isEmpty() || $items->isEmpty()) {
                $this->command->warn("Skipping company {$company->name} - missing vendors or items");
                continue;
            }

            // Create 10 Purchase Orders per company
            for ($i = 1; $i <= 10; $i++) {
                $vendor = $vendors->random();
                $orderDate = Carbon::now()->subDays(rand(1, 90));
                $expectedDate = (clone $orderDate)->addDays(rand(7, 30));

                // Generate PO Number
                $poNumber = 'PO' . $orderDate->format('Ymd') . str_pad($i, 4, '0', STR_PAD_LEFT);

                // Determine status based on order date
                $daysSinceOrder = Carbon::now()->diffInDays($orderDate);
                if ($daysSinceOrder > 45) {
                    $status = 'received';
                } elseif ($daysSinceOrder > 30) {
                    $status = 'approved';
                } elseif ($daysSinceOrder > 15) {
                    $status = 'pending';
                } else {
                    $status = 'draft';
                }

                // Determine type
                $types = ['draft', 'first_article', 'production'];
                $type = $types[array_rand($types)];

                // Create Purchase Order
                $po = PurchaseOrder::create([
                    'company_id' => $company->id,
                    'vendor_id' => $vendor->id,
                    'po_number' => $poNumber,
                    'type' => $type,
                    'order_date' => $orderDate,
                    'expected_received_date' => $expectedDate,
                    'payment_terms' => ['net_15', 'net_30', 'net_45', 'net_60', 'due_on_receipt'][array_rand(['net_15', 'net_30', 'net_45', 'net_60', 'due_on_receipt'])],
                    'ship_to' => $company->name . "\n123 Main Street\nCity, State 12345",
                    'warehouse_id' => $warehouse?->id,
                    'cage_number' => 'CAGE' . rand(1000, 9999),
                    'discount_type' => rand(0, 1) ? 'flat' : 'percentage',
                    'discount' => rand(0, 1) ? rand(0, 100) : 0,
                    'tax' => rand(0, 10),
                    'description' => 'Purchase order for ' . $vendor->name,
                    'additional_notes' => 'Please deliver between 8 AM - 5 PM',
                    'status' => $status,
                ]);

                // Add 2-5 items to each PO
                $itemCount = rand(2, 5);
                $selectedItems = $items->random($itemCount);

                foreach ($selectedItems as $item) {
                    $quantity = rand(5, 50);
                    $unitPrice = $item->cost_price * rand(90, 110) / 100; // Vary price slightly

                    $poItem = PurchaseOrderItem::create([
                        'purchase_order_id' => $po->id,
                        'item_id' => $item->id,
                        'item_sku' => $item->sku,
                        'count_of' => 1,
                        'unit' => $item->unit,
                        'count_price' => 0,
                        'unit_price' => $unitPrice,
                        'quantity' => $quantity,
                        'notes' => null,
                        'discount_type' => 'flat',
                        'discount' => 0,
                        'taxable' => true,
                        'inventory' => true,
                        'receiving_status' => $status === 'received' ? 'received' : 'pending',
                        'commodity_class' => $item->class,
                    ]);

                    // Calculate item total
                    $poItem->calculateTotal();
                }

                // Calculate PO totals
                $po->calculateTotals();

                $this->command->info("Created PO: {$poNumber} for {$company->name} - Status: {$status}");
            }
        }

        $this->command->info('Purchase Orders seeded successfully!');
    }
}
