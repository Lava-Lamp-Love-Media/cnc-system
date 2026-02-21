<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteMachine extends Model
{
    protected $table = 'quote_machines';

    protected $fillable = [
        'quote_id',
        'machine_id',
        'labour_id',
        'model',
        'labor_mode',
        'material',
        'complexity',
        'priority',
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

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }

    public function labour()
    {
        return $this->belongsTo(Operator::class, 'labour_id');
    }
}
