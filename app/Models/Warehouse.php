<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'warehouse_code',
        'name',
        'location',
        'manager_name',
        'phone',
        'email',
        'storage_capacity',
        'capacity_unit',
        'warehouse_type',
        'status',
        'description',
        'address',
        'city',
        'state',
        'zip_code',
        'country',
    ];

    protected $casts = [
        'storage_capacity' => 'decimal:2',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Status badge
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'active' => '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>',
            'inactive' => '<span class="badge badge-secondary"><i class="fas fa-pause-circle"></i> Inactive</span>',
            'maintenance' => '<span class="badge badge-warning"><i class="fas fa-tools"></i> Maintenance</span>',
            default => '<span class="badge badge-light">Unknown</span>',
        };
    }

    // Type badge
    public function getTypeBadgeAttribute()
    {
        return match ($this->warehouse_type) {
            'main' => '<span class="badge badge-primary">Main</span>',
            'secondary' => '<span class="badge badge-info">Secondary</span>',
            'raw_material' => '<span class="badge badge-warning">Raw Material</span>',
            'finished_goods' => '<span class="badge badge-success">Finished Goods</span>',
            'tools' => '<span class="badge badge-dark">Tools</span>',
            default => '<span class="badge badge-light">-</span>',
        };
    }

    // Get full address
    public function getFullAddressAttribute()
    {
        $parts = array_filter([
            $this->address,
            $this->city,
            $this->state,
            $this->zip_code,
            $this->country,
        ]);

        return implode(', ', $parts);
    }
}
