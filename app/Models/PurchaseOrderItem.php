<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_order_id',
        'item_id',
        'item_sku',
        'count_of',
        'unit',
        'count_price',
        'unit_price',
        'quantity',
        'notes',
        'discount_type',
        'discount',
        'taxable',
        'total',
        'inventory',
        'receiving_status',
        'commodity_class',
    ];

    protected $casts = [
        'count_price' => 'decimal:2',
        'unit_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'taxable' => 'boolean',
        'inventory' => 'boolean',
    ];

    // Relationships
    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Methods
    public function calculateTotal()
    {
        $baseTotal = $this->unit_price * $this->quantity;

        $discountAmount = 0;
        if ($this->discount > 0) {
            if ($this->discount_type === 'percentage') {
                $discountAmount = ($baseTotal * $this->discount) / 100;
            } else {
                $discountAmount = $this->discount;
            }
        }

        $this->total = $baseTotal - $discountAmount;
        $this->save();
    }
}
