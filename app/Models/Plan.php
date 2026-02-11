<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $fillable = ['name', 'slug', 'price', 'billing_cycle', 'is_active'];

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'plan_feature')
            ->withTimestamps();
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
