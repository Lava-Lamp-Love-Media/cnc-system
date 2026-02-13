<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Machine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'machine_code',
        'manufacturer',
        'model',
        'serial_number',
        'year_of_manufacture',
        'purchase_date',
        'purchase_price',
        'status',
        'description',
        'specifications',
        'location',
        'operating_hours',
        'last_maintenance_date',
        'next_maintenance_date',
        'image',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'last_maintenance_date' => 'date',
        'next_maintenance_date' => 'date',
        'purchase_price' => 'decimal:2',
        'operating_hours' => 'integer',
        'year_of_manufacture' => 'integer',
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Helper methods
    public function isActive()
    {
        return $this->status === 'active';
    }

    public function needsMaintenance()
    {
        if (!$this->next_maintenance_date) {
            return false;
        }
        return $this->next_maintenance_date <= now()->addDays(7);
    }

    public function isOverdue()
    {
        if (!$this->next_maintenance_date) {
            return false;
        }
        return $this->next_maintenance_date < now();
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'active' => '<span class="badge badge-success"><i class="fas fa-check-circle"></i> Active</span>',
            'maintenance' => '<span class="badge badge-warning"><i class="fas fa-tools"></i> Maintenance</span>',
            'inactive' => '<span class="badge badge-secondary"><i class="fas fa-pause-circle"></i> Inactive</span>',
            'broken' => '<span class="badge badge-danger"><i class="fas fa-times-circle"></i> Broken</span>',
            default => '<span class="badge badge-light">Unknown</span>',
        };
    }

    public function getAgeAttribute()
    {
        if (!$this->year_of_manufacture) {
            return null;
        }
        return now()->year - $this->year_of_manufacture;
    }
}
