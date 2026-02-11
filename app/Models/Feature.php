<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'description', 'is_active'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_feature')->withTimestamps();
    }
}
