<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'customer_code',
        'name',
        'email',
        'phone',
        'customer_type',
        'credit_limit',
        'payment_terms_days',
        'tax_id',
        'status',
        'notes',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'payment_terms_days' => 'integer',
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

    public function shippingAddresses()
    {
        return $this->morphMany(Address::class, 'addressable')
            ->where('address_type', 'shipping');
    }

    public function defaultShippingAddress()
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

    public function documents()
    {
        return $this->morphMany(Media::class, 'mediable')
            ->whereIn('category', ['contract', 'certificate', 'tax_document']);
    }

    public function images()
    {
        return $this->morphMany(Media::class, 'mediable')
            ->where('file_type', 'image');
    }

    public function primaryImage()
    {
        return $this->morphOne(Media::class, 'mediable')
            ->where('is_primary', true)
            ->where('file_type', 'image');
    }


    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'active' => '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>',
            'inactive' => '<span class="badge badge-secondary"><i class="fas fa-pause-circle"></i> Inactive</span>',
            'suspended' => '<span class="badge badge-danger"><i class="fas fa-ban"></i> Suspended</span>',
            default => '<span class="badge badge-light">Unknown</span>',
        };
    }

    public function getTypeBadgeAttribute()
    {
        return match ($this->customer_type) {
            'individual' => '<span class="badge badge-info">Individual</span>',
            'company' => '<span class="badge badge-primary">Company</span>',
            default => '<span class="badge badge-light">-</span>',
        };
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return config('filesystems.disks.spaces.url') . '/' . $this->logo->file_path;
        }

        // Generate avatar with initials
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&size=200&background=667eea&color=ffffff&bold=true';
    }
}
