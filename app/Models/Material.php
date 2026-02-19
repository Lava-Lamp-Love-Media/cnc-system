<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'type',
        'unit',
        'diameter_from',
        'diameter_to',
        'price',
        'adj',
        'adj_type',
        'real_price',
        'density',
        'code',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'diameter_from' => 'decimal:5',
        'diameter_to'   => 'decimal:5',
        'price'         => 'decimal:4',
        'adj'           => 'decimal:4',
        'real_price'    => 'decimal:4',
        'density'       => 'decimal:4',
        'is_active'     => 'boolean',
    ];

    // ── Relationships ─────────────────────────────────────
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // ── Computed ──────────────────────────────────────────
    public function getComputedRealPriceAttribute(): float
    {
        if ($this->adj_type === 'percent') {
            return round($this->price * (1 + $this->adj / 100), 4);
        }
        return round($this->price + $this->adj, 4);
    }

    public function getTypeBadgeAttribute(): string
    {
        $map = [
            'metal_alloy' => '<span class="badge" style="background:#17a2b8;color:#fff;font-size:11px;">Metal / Alloy</span>',
            'plastic'     => '<span class="badge badge-warning">Plastic</span>',
            'composite'   => '<span class="badge badge-secondary">Composite</span>',
            'other'       => '<span class="badge badge-light border">Other</span>',
        ];
        return $map[$this->type] ?? '<span class="badge badge-light">' . $this->type . '</span>';
    }

    public function getAdjTypeBadgeAttribute(): string
    {
        return $this->adj_type === 'percent'
            ? '<span class="badge badge-info px-2">Percent</span>'
            : '<span class="badge badge-primary px-2">Amount</span>';
    }

    public function getUnitBadgeAttribute(): string
    {
        return '<span class="badge badge-secondary" style="font-size:10px;">' . $this->unit . '</span>';
    }

    // ── Scopes ────────────────────────────────────────────
    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ── Boot: auto compute real_price before save ─────────
    protected static function booted()
    {
        static::saving(function (Material $m) {
            if ($m->adj_type === 'percent') {
                $m->real_price = round($m->price * (1 + $m->adj / 100), 4);
            } else {
                $m->real_price = round($m->price + $m->adj, 4);
            }
        });
    }
}
