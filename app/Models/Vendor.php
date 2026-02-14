<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'vendor_code',
        'name',
        'email',
        'phone',
        'vendor_type',
        'payment_terms_days',
        'lead_time_days',
        'tax_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'payment_terms_days' => 'integer',
        'lead_time_days' => 'integer',
    ];

    // Company relationship
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Addresses (Polymorphic)
    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable')->orderBy('is_default', 'desc');
    }

    public function billingAddress()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('address_type', 'billing')
            ->where('is_default', true);
    }

    public function shippingAddress()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('address_type', 'shipping')
            ->where('is_default', true);
    }

    // Media (Polymorphic)
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable')->orderBy('order');
    }

    public function logo()
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('category', 'logo')
            ->where('is_primary', true);
    }

    public function certificates()
    {
        return $this->morphMany(Media::class, 'mediable')
            ->where('category', 'certificate');
    }

    public function contracts()
    {
        return $this->morphMany(Media::class, 'mediable')
            ->where('category', 'contract');
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return config('filesystems.disks.spaces.url') . '/' . $this->logo->file_path;
        }
        // Generate avatar with initials
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=200&background=f39c12&color=ffffff&bold=true';
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'active' => '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>',
            'inactive' => '<span class="badge badge-secondary"><i class="fas fa-pause-circle"></i> Inactive</span>',
            'blacklisted' => '<span class="badge badge-danger"><i class="fas fa-ban"></i> Blacklisted</span>',
            default => '<span class="badge badge-light">Unknown</span>',
        };
    }

    public function getTypeBadgeAttribute()
    {
        return match ($this->vendor_type) {
            'supplier' => '<span class="badge badge-primary">Supplier</span>',
            'manufacturer' => '<span class="badge badge-success">Manufacturer</span>',
            'distributor' => '<span class="badge badge-info">Distributor</span>',
            'contractor' => '<span class="badge badge-warning">Contractor</span>',
            default => '<span class="badge badge-light">-</span>',
        };
    }
}
