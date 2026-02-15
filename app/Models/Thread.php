<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thread extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'thread_code',
        'name',
        'thread_type',
        'diameter',
        'pitch',
        'thread_standard',
        'thread_class',
        'direction',
        'thread_sizes',
        'thread_options',
        'thread_price',
        'option_price',
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
        'thread_price' => 'decimal:2',
        'option_price' => 'decimal:2',
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

    public function scopeExternal($query)
    {
        return $query->where('thread_type', 'external');
    }

    public function scopeInternal($query)
    {
        return $query->where('thread_type', 'internal');
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

    public function getTypeBadgeAttribute()
    {
        return $this->thread_type === 'external'
            ? "<span class='badge badge-primary'><i class='fas fa-arrow-right'></i> External</span>"
            : "<span class='badge badge-success'><i class='fas fa-arrow-left'></i> Internal</span>";
    }

    public function getDirectionBadgeAttribute()
    {
        return $this->direction === 'right'
            ? "<span class='badge badge-info'>Right-Hand</span>"
            : "<span class='badge badge-warning'>Left-Hand</span>";
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
