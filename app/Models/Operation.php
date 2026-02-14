<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'operation_code',
        'name',
        'description',
        'hourly_rate',
        'status',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
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
            default => '<span class="badge badge-light">Unknown</span>',
        };
    }
}
