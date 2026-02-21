<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteTap extends Model
{
    protected $table = 'quote_taps';

    protected $fillable = [
        'quote_id',
        'tap_id',
        'tap_price',
        'thread_option',
        'option_price',
        'direction',
        'thread_size',
        'base_price',
        'chamfer_id',
        'chamfer_size',
        'chamfer_price',
        'debur_id',
        'debur_size',
        'debur_price',
        'sub_total',
        'sort_order',
    ];

    protected $casts = [
        'tap_price'     => 'decimal:2',
        'option_price'  => 'decimal:2',
        'base_price'    => 'decimal:2',
        'chamfer_size'  => 'decimal:4',
        'chamfer_price' => 'decimal:2',
        'debur_size'    => 'decimal:4',
        'debur_price'   => 'decimal:2',
        'sub_total'     => 'decimal:2',
        'sort_order'    => 'integer',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function tap()
    {
        return $this->belongsTo(Tap::class);
    }

    public function chamfer()
    {
        return $this->belongsTo(Chamfer::class);
    }

    public function debur()
    {
        return $this->belongsTo(Debur::class);
    }
}
