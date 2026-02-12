<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use SoftDeletes;
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

    protected $casts = [
        'subscription_start' => 'date',
        'subscription_end' => 'date',
    ];

    // ✅ RELATIONSHIPS
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function featureOverrides()
    {
        return $this->belongsToMany(Feature::class, 'company_feature_overrides')
            ->withPivot('is_enabled')
            ->withTimestamps();
    }

    // ✅ FEATURE CHECKING
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

    // ✅ HELPER METHODS

    // Get company admin user
    public function admin()
    {
        return $this->users()->where('role', 'company_admin')->first();
    }

    // Get only regular company users (not admin)
    public function companyUsers()
    {
        return $this->users()->where('role', 'user');
    }

    // Subscription status helpers
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isTrial(): bool
    {
        return $this->status === 'trial';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    // Check if subscription is still valid
    public function isSubscriptionActive(): bool
    {
        return in_array($this->status, ['active', 'trial'])
            && $this->subscription_end >= now();
    }

    // Days until subscription expires
    public function daysUntilExpiry(): int
    {
        if (!$this->subscription_end) {
            return 0;
        }
        return now()->diffInDays($this->subscription_end, false);
    }

    // Check if subscription is expiring soon (within 7 days)
    public function isExpiringSoon(): bool
    {
        if (!$this->subscription_end) {
            return false;
        }
        return $this->daysUntilExpiry() <= 7 && $this->daysUntilExpiry() > 0;
    }

    // Check if subscription has expired
    public function isExpired(): bool
    {
        if (!$this->subscription_end) {
            return false;
        }
        return $this->subscription_end < now();
    }
}
