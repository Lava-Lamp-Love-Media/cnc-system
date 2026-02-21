<?php
// ══════════════════════════════════════════════════════════
// Child Models — save each as its own file in App\Models\
// ══════════════════════════════════════════════════════════

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// ── QuoteMachine ──────────────────────────────────────────
class QuoteMachine extends Model
{
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

// ── QuoteOperation ────────────────────────────────────────
class QuoteOperation extends Model
{
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

// ── QuoteItem ─────────────────────────────────────────────
class QuoteItem extends Model
{
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
        'qty'       => 'integer',
        'rate'      => 'decimal:2',
        'sub_total' => 'decimal:2',
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

// ── QuoteHole ─────────────────────────────────────────────
class QuoteHole extends Model
{
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

// ── QuoteTap ──────────────────────────────────────────────
class QuoteTap extends Model
{
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

// ── QuoteThread ───────────────────────────────────────────
class QuoteThread extends Model
{
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

// ── QuoteSecondaryOp ──────────────────────────────────────
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

// ── QuoteAttachment ───────────────────────────────────────
class QuoteAttachment extends Model
{
    protected $fillable = [
        'quote_id',
        'original_name',
        'stored_name',
        'mime_type',
        'file_size',
        'disk',
        'path',
    ];
    protected $casts = ['file_size' => 'integer'];
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
