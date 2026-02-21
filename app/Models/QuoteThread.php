<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteThread extends Model
{
    protected $table = 'quote_threads';

    protected $fillable = [
        'quote_id',
        'thread_id',
        'thread_price',
        'option',
        'option_price',
        'direction',
        'thread_size',
        'size_price',
        'standard',
        'pitch',
        'pitch_price',
        'class',
        'class_price',
        'sub_total',
        'sort_order',
    ];

    protected $casts = [
        'thread_price' => 'decimal:2',
        'option_price' => 'decimal:2',
        'size_price'   => 'decimal:2',
        'pitch_price'  => 'decimal:2',
        'class_price'  => 'decimal:2',
        'sub_total'    => 'decimal:2',
        'sort_order'   => 'integer',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }
}
