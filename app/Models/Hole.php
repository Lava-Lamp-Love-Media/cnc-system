<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hole extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'hole_code',
        'name',
        'size',
        'hole_type',
        'unit_price',
        'description',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'size' => 'decimal:3',
        'unit_price' => 'decimal:2',
        'sort_order' => 'integer'
    ];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    // Accessors
    public function getTypeBadgeAttribute()
    {
        $colors = [
            'through' => 'primary',
            'blind' => 'success',
            'countersink' => 'warning',
            'counterbore' => 'info'
        ];

        $color = $colors[$this->hole_type] ?? 'secondary';
        $label = ucfirst(str_replace('_', ' ', $this->hole_type));

        return "<span class='badge badge-{$color}'>{$label}</span>";
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active'
            ? "<span class='badge badge-success'>Active</span>"
            : "<span class='badge badge-secondary'>Inactive</span>";
    }
}
