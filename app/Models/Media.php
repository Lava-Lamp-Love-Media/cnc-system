<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'mediable_type',
        'mediable_id',
        'file_name',
        'file_path',
        'file_type',
        'mime_type',
        'file_size',
        'category',
        'title',
        'description',
        'is_primary',
        'order',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'order' => 'integer',
        'file_size' => 'integer',
    ];

    // Polymorphic relationship
    public function mediable()
    {
        return $this->morphTo();
    }

    // Get file URL
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }


    // Get human-readable file size
    public function getFileSizeHumanAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    // Check if file is image
    public function isImage()
    {
        return str_starts_with($this->mime_type, 'image/');
    }

    // Check if file is PDF
    public function isPdf()
    {
        return $this->mime_type === 'application/pdf';
    }

    // Get icon based on file type
    public function getIconAttribute()
    {
        if ($this->isImage()) {
            return 'fas fa-image text-primary';
        } elseif ($this->isPdf()) {
            return 'fas fa-file-pdf text-danger';
        } elseif (str_contains($this->mime_type, 'word')) {
            return 'fas fa-file-word text-primary';
        } elseif (str_contains($this->mime_type, 'excel') || str_contains($this->mime_type, 'spreadsheet')) {
            return 'fas fa-file-excel text-success';
        } else {
            return 'fas fa-file text-secondary';
        }
    }

    // Get category badge
    public function getCategoryBadgeAttribute()
    {
        return match ($this->category) {
            'logo' => '<span class="badge badge-primary">Logo</span>',
            'profile' => '<span class="badge badge-info">Profile</span>',
            'contract' => '<span class="badge badge-warning">Contract</span>',
            'certificate' => '<span class="badge badge-success">Certificate</span>',
            'invoice' => '<span class="badge badge-danger">Invoice</span>',
            'tax_document' => '<span class="badge badge-secondary">Tax Document</span>',
            'product_image' => '<span class="badge badge-primary">Product Image</span>',
            default => '<span class="badge badge-light">Other</span>',
        };
    }

    public function getFullUrlAttribute()
    {
        // For DigitalOcean Spaces
        if (config('filesystems.default') === 'spaces') {
            return config('filesystems.disks.spaces.url') . '/' . $this->file_path;
        }

        // For local storage
        return asset('storage/' . $this->file_path);
    }
}
