<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'addressable_type',
        'addressable_id',
        'address_type',
        'is_default',
        'contact_person',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip_code',
        'country',
        'notes',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    // Polymorphic relationship
    public function addressable()
    {
        return $this->morphTo();
    }

    // Get full address
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->zip_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }

    // Get type badge
    public function getTypeBadgeAttribute()
    {
        return match ($this->address_type) {
            'billing' => '<span class="badge badge-primary">Billing</span>',
            'shipping' => '<span class="badge badge-success">Shipping</span>',
            'warehouse' => '<span class="badge badge-info">Warehouse</span>',
            'office' => '<span class="badge badge-warning">Office</span>',
            default => '<span class="badge badge-light">-</span>',
        };
    }
}
