<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'description',
        'sku',
        'class',
        'unit',
        'count',
        'cost_price',
        'sell_price',
        'stock_min',
        'reorder_level',
        'current_stock',
        'warehouse_id',
        'image',
        'is_inventory',
        'is_taxable',
        'notes',
    ];

    protected $casts = [
        'is_inventory' => 'boolean',
        'is_taxable' => 'boolean',
        'cost_price' => 'decimal:2',
        'sell_price' => 'decimal:2',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function inventoryTransactions()
    {
        return $this->hasMany(InventoryTransaction::class);
    }

    public function purchaseOrderItems()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    // Accessors
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        // Check if local default exists
        if (file_exists(public_path('images/no-image.png'))) {
            return asset('images/no-image.png');
        }

        // Fallback to UI Avatars API
        return $this->getDefaultImage();
    }

    // Get default image based on item class
    public function getDefaultImage()
    {
        $defaultImages = [
            'tooling' => 'https://ui-avatars.com/api/?name=Tooling&size=200&background=17a2b8&color=fff&bold=true',
            'sellable' => 'https://ui-avatars.com/api/?name=Sellable&size=200&background=28a745&color=fff&bold=true',
            'raw_stock' => 'https://ui-avatars.com/api/?name=Raw+Stock&size=200&background=ffc107&color=000&bold=true',
            'consommable' => 'https://ui-avatars.com/api/?name=Consumable&size=200&background=007bff&color=fff&bold=true',
        ];

        return $defaultImages[$this->class] ?? 'https://ui-avatars.com/api/?name=Item&size=200&background=6c757d&color=fff&bold=true';
    }

    // Methods
    public function updateStock($quantity, $type = 'add')
    {
        if ($type === 'add') {
            $this->increment('current_stock', $quantity);
        } else {
            $this->decrement('current_stock', $quantity);
        }
    }

    public function isLowStock()
    {
        return $this->current_stock <= $this->reorder_level;
    }
}
