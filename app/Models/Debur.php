<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debur extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'debur_code',
        'name',
        'size',
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
    public function getStatusBadgeAttribute()
    {
        return $this->status === 'active'
            ? "<span class='badge badge-success'>Active</span>"
            : "<span class='badge badge-secondary'>Inactive</span>";
    }

    public function getFormattedSizeAttribute()
    {
        if ($this->size) {
            return number_format($this->size, 2) . 'mm';
        }
        return 'Standard';
    }
}
