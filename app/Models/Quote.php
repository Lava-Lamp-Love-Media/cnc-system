<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quote extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // Tree structure
        'parent_id',
        'tree_order',
        // Header
        'company_id',
        'type',
        'quote_number',
        'manufacturing_method',
        'unit',
        'quantity',
        'setup_price',
        'quote_date',
        'due_date',
        'valid_until',
        'part_number',
        'cage_number',
        'po_number',
        // Customer
        'customer_id',
        'is_temp_customer',
        'temp_customer_name',
        'temp_customer_email',
        'temp_customer_phone',
        'ship_to',
        'bill_to',
        // Material
        'shape',
        'pin_diameter',
        'diameter_adjustment',
        'pin_length',
        'material_type',
        'material_id',
        'block_price',
        'metal_adjustment',
        'metal_real_price',
        'width',
        'length',
        'height',
        'cubic_inch_volume',
        'cubic_mm_volume',
        'weight_lb',
        'weight_kg',
        'each_pin_price',
        'total_pin_price',
        'calc_weight_kg',
        'calc_weight_lbs',
        'total_weight_kg',
        'total_weight_lb',
        // Plating
        'plating_vendor_id',
        'plating_type',
        'plating_pricing_type',
        'plating_count',
        'plating_price_each',
        'plating_total_pounds',
        'plating_lot_charge',
        'plating_per_pound',
        'plating_salt_testing',
        'plating_surcharge',
        'plating_standards_price',
        'plating_total',
        // Heat
        'heat_vendor_id',
        'heat_type',
        'heat_pricing_type',
        'heat_count',
        'heat_price_each',
        'heat_total_pounds',
        'heat_lot_charge',
        'heat_per_pound',
        'heat_testing',
        'heat_surcharge',
        'heat_total',
        // Final
        'break_in_charge',
        'override_price',
        'grand_each_price',
        'grand_total_price',
        'engineer_notes',
        'status',
    ];

    protected $casts = [
        'parent_id'    => 'integer',
        'tree_order'   => 'integer',
        'quote_date'   => 'date',
        'due_date'     => 'date',
        'valid_until'  => 'date',
        'is_temp_customer' => 'boolean',
        'quantity'     => 'integer',
        'setup_price'  => 'decimal:2',
        'block_price'  => 'decimal:4',
        'metal_adjustment' => 'decimal:4',
        'metal_real_price' => 'decimal:4',
        'pin_diameter' => 'decimal:4',
        'diameter_adjustment' => 'decimal:4',
        'pin_length'   => 'decimal:4',
        'width' => 'decimal:4',
        'length' => 'decimal:4',
        'height' => 'decimal:4',
        'cubic_inch_volume' => 'decimal:4',
        'cubic_mm_volume'   => 'decimal:2',
        'weight_lb'    => 'decimal:4',
        'weight_kg'    => 'decimal:4',
        'each_pin_price'    => 'decimal:4',
        'total_pin_price'   => 'decimal:2',
        'calc_weight_kg'    => 'decimal:4',
        'calc_weight_lbs'   => 'decimal:4',
        'total_weight_kg'   => 'decimal:4',
        'total_weight_lb'   => 'decimal:4',
        'plating_total'     => 'decimal:2',
        'heat_total'        => 'decimal:2',
        'break_in_charge'   => 'decimal:2',
        'override_price'    => 'decimal:2',
        'grand_each_price'  => 'decimal:2',
        'grand_total_price' => 'decimal:2',
    ];

    // ── Tree relationships ─────────────────────────────────

    /** Parent quote (this is a child job order / invoice) */
    public function parent()
    {
        return $this->belongsTo(Quote::class, 'parent_id');
    }

    /** Child quotes (job orders / invoices under this quote) */
    public function children()
    {
        return $this->hasMany(Quote::class, 'parent_id')->orderBy('tree_order')->orderBy('id');
    }

    /** Convenience: is this a top-level (parent) quote? */
    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }

    /** Convenience: is this a child (job order under a quote)? */
    public function isChild(): bool
    {
        return ! is_null($this->parent_id);
    }

    // ── Standard relationships ─────────────────────────────

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
    public function platingVendor()
    {
        return $this->belongsTo(Vendor::class, 'plating_vendor_id');
    }
    public function heatVendor()
    {
        return $this->belongsTo(Vendor::class, 'heat_vendor_id');
    }

    // ── Section children ───────────────────────────────────
    public function machines()
    {
        return $this->hasMany(QuoteMachine::class)->orderBy('sort_order')->orderBy('id');
    }
    public function operations()
    {
        return $this->hasMany(QuoteOperation::class)->orderBy('sort_order')->orderBy('id');
    }
    public function items()
    {
        return $this->hasMany(QuoteItem::class)->orderBy('sort_order')->orderBy('id');
    }
    public function holes()
    {
        return $this->hasMany(QuoteHole::class)->orderBy('sort_order')->orderBy('id');
    }
    public function taps()
    {
        return $this->hasMany(QuoteTap::class)->orderBy('sort_order')->orderBy('id');
    }
    public function threads()
    {
        return $this->hasMany(QuoteThread::class)->orderBy('sort_order')->orderBy('id');
    }
    public function secondaryOps()
    {
        return $this->hasMany(QuoteSecondaryOp::class)->orderBy('sort_order')->orderBy('id');
    }
    public function attachments()
    {
        return $this->hasMany(QuoteAttachment::class);
    }

    // ── Scopes ────────────────────────────────────────────

    public function scopeForCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /** Only top-level (parent) quotes */
    public function scopeParentsOnly($query)
    {
        return $query->whereNull('parent_id');
    }

    /** Only child quotes */
    public function scopeChildrenOnly($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    // ── Accessors ──────────────────────────────────────────

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'draft'     => '<span class="badge badge-secondary">Draft</span>',
            'sent'      => '<span class="badge badge-info">Sent</span>',
            'approved'  => '<span class="badge badge-success">Approved</span>',
            'rejected'  => '<span class="badge badge-danger">Rejected</span>',
            'converted' => '<span class="badge badge-primary">Converted</span>',
            'cancelled' => '<span class="badge badge-dark">Cancelled</span>',
            default     => '<span class="badge badge-light">' . $this->status . '</span>',
        };
    }

    public function getTypeBadgeAttribute(): string
    {
        return match ($this->type) {
            'quote'     => '<span class="badge badge-info">Quote</span>',
            'job_order' => '<span class="badge badge-warning">Job Order</span>',
            'invoice'   => '<span class="badge badge-success">Invoice</span>',
            default     => '<span class="badge badge-secondary">' . $this->type . '</span>',
        };
    }
}
