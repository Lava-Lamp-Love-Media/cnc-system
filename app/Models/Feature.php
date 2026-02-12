<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'icon', 'description', 'is_active'];

    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_feature')->withTimestamps();
    }
}
