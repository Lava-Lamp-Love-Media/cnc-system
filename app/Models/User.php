<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ✅ RELATIONSHIPS
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    // ✅ ROLE CHECK METHODS
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }

    public function isCompanyAdmin()
    {
        return $this->role === 'company_admin';
    }

    public function isShop()
    {
        return $this->role === 'shop';
    }

    public function isEngineer()
    {
        return $this->role === 'engineer';
    }

    public function isEditor()
    {
        return $this->role === 'editor';
    }

    public function isQC()
    {
        return $this->role === 'qc';
    }

    public function isChecker()
    {
        return $this->role === 'checker';
    }

    public function isUser()
    {
        return $this->role === 'user';
    }

    // ✅ FEATURE ACCESS
    public function hasFeature(string $slug): bool
    {
        // Super admin can access everything
        if ($this->isSuperAdmin()) {
            return true;
        }

        if (!$this->company) {
            return false;
        }

        return $this->company->hasFeature($slug);
    }

    // ✅ HELPER METHODS
    public function getRoleNameAttribute()
    {
        return ucfirst(str_replace('_', ' ', $this->role));
    }

    public function getInitialsAttribute()
    {
        $words = explode(' ', $this->name);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name, 0, 2));
    }

    public function isActive()
    {
        return $this->email_verified_at !== null;
    }
}
