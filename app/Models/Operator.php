<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operator extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'operator_code',
        'name',
        'email',
        'phone',
        'skill_level',
        'status',
        'notes',
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

    // Skill level badge
    public function getSkillBadgeAttribute()
    {
        return match ($this->skill_level) {
            'trainee' => '<span class="badge badge-info">Trainee</span>',
            'junior' => '<span class="badge badge-primary">Junior</span>',
            'senior' => '<span class="badge badge-warning">Senior</span>',
            'expert' => '<span class="badge badge-danger">Expert</span>',
            default => '<span class="badge badge-light">-</span>',
        };
    }
}
