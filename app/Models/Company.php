<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'plan_id',
        'name',
        'email',
        'phone',
        'address',
        'logo',
        'status',
        'subscription_start',
        'subscription_end'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function featureOverrides()
    {
        return $this->belongsToMany(Feature::class, 'company_feature_overrides')
            ->withPivot('is_enabled')
            ->withTimestamps();
    }

    public function hasFeature(string $slug): bool
    {
        $feature = Feature::where('slug', $slug)->first();

        if (!$feature) {
            return false;
        }

        // 1️⃣ Check override first
        $override = $this->featureOverrides()
            ->where('feature_id', $feature->id)
            ->first();

        if ($override) {
            return (bool) $override->pivot->is_enabled;
        }

        // 2️⃣ Otherwise check plan
        return $this->plan
            ? $this->plan->features()->where('slug', $slug)->exists()
            : false;
    }
}
