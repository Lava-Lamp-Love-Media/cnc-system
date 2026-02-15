<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tap extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'tap_code',
        'name',
        'diameter',
        'pitch',
        'thread_standard',
        'thread_class',
        'direction',
        'thread_sizes',
        'thread_options',
        'tap_price',
        'thread_option_price',
        'pitch_price',
        'class_price',
        'size_price',
        'description',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'diameter' => 'decimal:3',
        'pitch' => 'decimal:3',
        'tap_price' => 'decimal:2',
        'thread_option_price' => 'decimal:2',
        'pitch_price' => 'decimal:2',
        'class_price' => 'decimal:2',
        'size_price' => 'decimal:2',
        'thread_sizes' => 'array',
        'thread_options' => 'array',
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

    public function getThreadSpecAttribute()
    {
        return "Ø{$this->diameter}mm × {$this->pitch}mm pitch";
    }

    public function getDirectionBadgeAttribute()
    {
        return $this->direction === 'right'
            ? "<span class='badge badge-primary'>Right-Hand</span>"
            : "<span class='badge badge-danger'>Left-Hand</span>";
    }

    public function getStandardBadgeAttribute()
    {
        $colors = [
            'metric' => 'info',
            'UNC' => 'primary',
            'UNF' => 'success',
            'BSP' => 'warning',
            'NPT' => 'danger',
            'national_coarse' => 'secondary'
        ];

        $color = $colors[$this->thread_standard] ?? 'secondary';
        $label = strtoupper($this->thread_standard);

        return "<span class='badge badge-{$color}'>{$label}</span>";
    }
}
