<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteOperation extends Model
{
    protected $table = 'quote_operations';

    protected $fillable = [
        'quote_id',
        'operation_id',
        'labour_id',
        'time_minutes',
        'rate_per_hour',
        'sub_total',
        'sort_order',
    ];

    protected $casts = [
        'time_minutes'  => 'decimal:2',
        'rate_per_hour' => 'decimal:2',
        'sub_total'     => 'decimal:2',
        'sort_order'    => 'integer',
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }

    public function labour()
    {
        return $this->belongsTo(Operator::class, 'labour_id');
    }
}
