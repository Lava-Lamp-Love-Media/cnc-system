<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteHole extends Model
{
    protected $table = 'quote_holes';

    protected $fillable = [
        'quote_id',
        'qty',
        'drilling_method',
        'hole_size',
        'hole_unit',
        'tol_plus',
        'tol_minus',
        'depth_type',
        'depth_size',
        'hole_price',
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
        'qty'           => 'integer',
        'hole_size'     => 'decimal:4',
        'tol_plus'      => 'decimal:4',
        'tol_minus'     => 'decimal:4',
        'depth_size'    => 'decimal:4',
        'hole_price'    => 'decimal:2',
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

    public function chamfer()
    {
        return $this->belongsTo(Chamfer::class);
    }

    public function debur()
    {
        return $this->belongsTo(Debur::class);
    }
}
