<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'vendor_id',
        'po_number',
        'type',
        'order_date',
        'expected_received_date',
        'payment_terms',
        'ship_to',
        'warehouse_id',
        'cage_number',
        'subtotal',
        'discount_type',
        'discount',
        'tax',
        'grand_total',
        'description',
        'additional_notes',
        'current_stock_level',
        'purchase_level',
        'status',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_received_date' => 'date',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'tax' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function attachments()
    {
        return $this->hasMany(PurchaseOrderAttachment::class);
    }

    // Methods
    public function calculateTotals()
    {
        $subtotal = $this->items->sum('total');

        $discountAmount = 0;
        if ($this->discount > 0) {
            if ($this->discount_type === 'percentage') {
                $discountAmount = ($subtotal * $this->discount) / 100;
            } else {
                $discountAmount = $this->discount;
            }
        }

        $afterDiscount = $subtotal - $discountAmount;
        $taxAmount = ($afterDiscount * $this->tax) / 100;
        $grandTotal = $afterDiscount + $taxAmount;

        $this->update([
            'subtotal' => $subtotal,
            'grand_total' => $grandTotal,
        ]);
    }

    public static function generatePONumber($companyId)
    {
        $prefix = 'PO';
        $date = date('Ymd');
        $lastPO = self::where('company_id', $companyId)
            ->whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->first();

        $number = 1;
        if ($lastPO) {
            $lastNumber = (int) substr($lastPO->po_number, -4);
            $number = $lastNumber + 1;
        }

        return $prefix . $date . str_pad($number, 4, '0', STR_PAD_LEFT);
    }
}
