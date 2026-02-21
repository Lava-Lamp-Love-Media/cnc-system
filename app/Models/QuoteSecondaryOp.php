<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteSecondaryOp extends Model
{
    protected $table = 'quote_secondary_ops';

    protected $fillable = [
        'quote_id',
        'vendor_id',
        'name',
        'price_type',
        'qty',
        'unit_price',
        'sub_total',
        'sort_order',
    ];

    protected $casts = [
        'qty'        => 'integer',
        'unit_price' => 'decimal:2',
        'sub_total'  => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
