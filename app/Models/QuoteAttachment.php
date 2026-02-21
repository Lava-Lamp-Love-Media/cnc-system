<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class QuoteAttachment extends Model
{
    protected $table = 'quote_attachments';

    protected $fillable = [
        'quote_id',
        'original_name',
        'stored_name',
        'mime_type',
        'file_size',
        'disk',
        'path',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes < 1024)       return $bytes . ' B';
        if ($bytes < 1048576)    return round($bytes / 1024, 1) . ' KB';
        return round($bytes / 1048576, 1) . ' MB';
    }
}
