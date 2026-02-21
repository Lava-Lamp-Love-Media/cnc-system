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
        'status',       // ← added
    ];

    protected $casts = [
        'is_inventory' => 'boolean',
        'is_taxable'   => 'boolean',
        'cost_price'   => 'decimal:2',
        'sell_price'   => 'decimal:2',
        'count'        => 'integer',
        'stock_min'    => 'integer',
        'reorder_level' => 'integer',
        'current_stock' => 'integer',
    ];

    // ── Relationships ──────────────────────────────────────

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

    // ── Scopes ─────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // ── Accessors ──────────────────────────────────────────

    public function getImageUrlAttribute(): string
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }

        if (file_exists(public_path('images/no-image.png'))) {
            return asset('images/no-image.png');
        }

        return $this->getDefaultImage();
    }

    public function getDefaultImage(): string
    {
        $map = [
            'tooling'     => 'https://ui-avatars.com/api/?name=Tooling&size=200&background=17a2b8&color=fff&bold=true',
            'sellable'    => 'https://ui-avatars.com/api/?name=Sellable&size=200&background=28a745&color=fff&bold=true',
            'raw_stock'   => 'https://ui-avatars.com/api/?name=Raw+Stock&size=200&background=ffc107&color=000&bold=true',
            'consommable' => 'https://ui-avatars.com/api/?name=Consumable&size=200&background=007bff&color=fff&bold=true',
        ];

        return $map[$this->class] ?? 'https://ui-avatars.com/api/?name=Item&size=200&background=6c757d&color=fff&bold=true';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'active'       => '<span class="badge badge-success">Active</span>',
            'inactive'     => '<span class="badge badge-secondary">Inactive</span>',
            'discontinued' => '<span class="badge badge-danger">Discontinued</span>',
            default        => '<span class="badge badge-light">' . ucfirst($this->status) . '</span>',
        };
    }

    // ── Methods ────────────────────────────────────────────

    public function updateStock(int $quantity, string $type = 'add'): void
    {
        if ($type === 'add') {
            $this->increment('current_stock', $quantity);
        } else {
            $this->decrement('current_stock', $quantity);
        }
    }

    public function isLowStock(): bool
    {
        return $this->current_stock <= $this->reorder_level;
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
