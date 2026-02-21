<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $table = 'quote_items';

    protected $fillable = [
        'quote_id',
        'item_id',
        'description',
        'qty',
        'rate',
        'sub_total',
        'sort_order',
    ];

    protected $casts = [
        'qty'        => 'integer',
        'rate'       => 'decimal:2',
        'sub_total'  => 'decimal:2',
        'sort_order' => 'integer',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
