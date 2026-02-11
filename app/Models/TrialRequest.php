<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrialRequest extends Model
{
    protected $fillable = [
        'company_name',
        'company_email',
        'contact_name',
        'contact_email',
        'phone',
        'preferred_plan_slug',
        'message',
        'status',
        'company_id',
        'approved_at',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
