@extends('layouts.app')

@section('page-title', 'Create Quote')

@section('style')
<style>
/* ── Sticky header wrapper ───────────────────────────── */
#stickyHeader {
    position:relative; z-index:1;
    background:#f4f6f9; padding:0 0 8px;
    margin-bottom:10px;
}

/* ── Totals Bar ──────────────────────────────────────── */
.totals-bar { background:#343a40; color:#fff; border-radius:6px; padding:7px 14px;
              display:flex; flex-wrap:wrap; gap:6px; align-items:center; margin-bottom:5px; }
.totals-bar .t-item { text-align:center; }
.totals-bar .t-item .t-label { font-size:9px; color:#adb5bd; text-transform:uppercase; letter-spacing:.4px; }
.totals-bar .t-item .t-val   { font-size:13px; font-weight:700; }
.totals-bar .t-item.grand .t-val { color:#28a745; font-size:16px; }
.totals-bar .divider { width:1px; height:28px; background:rgba(255,255,255,.15); }

/* ── Section Tab Bar ─────────────────────────────────── */
.section-tabs { display:flex; gap:5px; flex-wrap:wrap; padding:2px 0 5px; }
.section-tab  { display:inline-flex; align-items:center; gap:5px; padding:5px 12px;
                border:2px solid #dee2e6; border-radius:20px; background:#fff;
                font-size:12px; font-weight:600; cursor:pointer; transition:all .2s; color:#555; white-space:nowrap; }
.section-tab:hover  { border-color:#aaa; color:#333; }
.section-tab.active { color:#fff; border-color:transparent; }
.section-tab .badge-total { background:rgba(255,255,255,.3); border-radius:10px;
                             padding:1px 6px; font-size:10px; }
.tab-machine.active  { background:#495057; }
.tab-ops.active      { background:#28a745; }
.tab-items.active    { background:#007bff; }
.tab-holes.active    { background:#28a745; }
.tab-taps.active     { background:#dc3545; }
.tab-threads.active  { background:#6f42c1; }
.tab-secondary.active{ background:#fd7e14; }
.tab-plating.active  { background:#e83e8c; }

/* ── Section Panels ─────────────────────────────────── */
.section-panel { display:none; }
.section-panel.show { display:block; }

/* ── Panel Header ────────────────────────────────────── */
.panel-header {
    display:flex; align-items:center; justify-content:space-between;
    padding:10px 16px; border-radius:6px 6px 0 0; color:#fff; margin-bottom:0;
}
.panel-header h6 { margin:0; font-weight:700; font-size:15px; }
.panel-header .panel-actions { display:flex; align-items:center; gap:8px; }
.panel-header .total-badge {
    background:rgba(255,255,255,.25); border-radius:20px;
    padding:3px 12px; font-size:13px; font-weight:700;
}

/* ── Row card (for holes/taps) ───────────────────────── */
.row-card { border:1px solid #e9ecef; border-radius:6px; margin-bottom:10px; background:#fff; }
.row-card .row-card-header {
    background:#f8f9fa; border-bottom:1px solid #e9ecef;
    padding:6px 12px; border-radius:6px 6px 0 0;
    display:flex; align-items:center; justify-content:space-between;
}
.row-card .row-card-body { padding:12px; }
.field-label { font-size:11px; font-weight:600; color:#6c757d; text-transform:uppercase;
               letter-spacing:.5px; margin-bottom:3px; }

/* ── Quick-add + button ──────────────────────────────── */
.btn-quickadd { width:28px;height:28px;padding:0;font-size:13px;border-radius:4px;
                line-height:1;text-align:center; flex-shrink:0;
                display:inline-flex;align-items:center;justify-content:center; }

/* ── Card footer fix ── */
.card { overflow: visible !important; }
.card-footer {
    border-radius: 0 0 10px 10px !important;
    display: block !important;
    visibility: visible !important;
    background: #fff;
    border-top: 1px solid rgba(0,0,0,.125);
    padding: .75rem 1.25rem;
}
/* ── Ensure all buttons are visible ── */
.card-footer .btn,
.card-footer a.btn {
    display: inline-flex !important;
    align-items: center !important;
    visibility: visible !important;
    opacity: 1 !important;
    color: #fff !important;
}
.card-footer .btn-secondary { background:#6c757d !important; color:#fff !important; }
.card-footer .btn-primary   { background:#007bff !important; border:0 !important; color:#fff !important; }

/* ── Select2 custom styling ─────────────────────────── */
.select2-container--bootstrap4 .select2-selection {
    border-color: #ced4da !important;
    border-radius: 4px !important;
}
.select2-container--bootstrap4 .select2-selection--single {
    height: 38px !important;
}
.select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
    padding-left: 10px !important;
    color: #495057 !important;
}
.select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
    height: 36px !important;
}
/* Customer add button alignment */
#customerSelectGroup .d-flex {
    align-items: flex-start !important;
}
#customerSelectGroup .btn {
    margin-top: 0;
    height: 38px;
}

/* ── Drop Zone ───────────────────────────────────────── */
#dropZone {
    border: 2px dashed #ced4da !important;
    border-radius: 6px;
    background: #f8f9fa;
    padding: 18px;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
    min-height: 68px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    user-select: none;
}
#dropZone.drag-over { background:#d4edda !important; border-color:#28a745 !important; }

/* ── Date Picker (flatpickr) ─────────────────────────── */
.flatpickr-input { background:#fff !important; }
.flatpickr-calendar { font-family:'Source Sans Pro',sans-serif; border-radius:8px; box-shadow:0 5px 20px rgba(0,0,0,.15); }
.flatpickr-day.selected { background:#667eea; border-color:#667eea; }
.flatpickr-day.selected:hover { background:#764ba2; border-color:#764ba2; }

/* ── height normalise ───────────────── */

</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')
<div class="row">
<div class="col-12">
<form action="{{ route('company.quotes.store') }}" method="POST" id="quoteForm" enctype="multipart/form-data">
@csrf

{{-- ══ TOTALS BAR ══ --}}
<div id="stickyHeader">


{{-- ══ CARD 1: HEADER ══ --}}
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title"><i class="fas fa-file-invoice mr-2"></i>Create Quote / Job Order</h3>
            <a href="{{ route('company.quotes.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left mr-1"></i> Back
            </a>
        </div>
    </div>
    <div class="card-body pb-2">

        {{-- ── Row 1: Core identifiers ── --}}
        <div class="row align-items-end">
            <div class="col-md-2">
                <div class="form-group mb-3">
                    <label class="field-label">Type <span class="text-danger">*</span></label>
                    <select name="type" id="quoteType" class="form-control @error('type') is-invalid @enderror" onchange="onTypeChange()">
                        <option value="quote"     {{ old('type','quote')=='quote'     ?'selected':'' }}>Quote</option>
                        <option value="job_order" {{ old('type')=='job_order'         ?'selected':'' }}>Job Order</option>
                        <option value="invoice"   {{ old('type')=='invoice'           ?'selected':'' }}>Invoice</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-3">
                    <label class="field-label">Number <span class="text-danger">*</span></label>
                    <input type="text" name="quote_number" id="quoteNumber"
                           class="form-control bg-light font-weight-bold @error('quote_number') is-invalid @enderror"
                           value="{{ old('quote_number', $quoteNumber) }}" readonly>
                    @error('quote_number')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-3">
                    <label class="field-label">Manufacturing Method</label>
                    <select name="manufacturing_method" class="form-control">
                        <option value="manufacture_in_house" {{ old('manufacturing_method','manufacture_in_house')=='manufacture_in_house'?'selected':'' }}>Manufacture In-House</option>
                        <option value="outsource"            {{ old('manufacturing_method')=='outsource'?'selected':'' }}>Outsource</option>
                        <option value="hybrid"               {{ old('manufacturing_method')=='hybrid'?'selected':'' }}>Hybrid</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group mb-3">
                    <label class="field-label">Unit</label>
                    <select name="unit" id="globalUnit" class="form-control">
                        <option value="inch">inch</option>
                        <option value="mm">mm</option>
                    </select>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group mb-3">
                    <label class="field-label">Qty <span class="text-danger">*</span></label>
                    <input type="number" name="quantity" id="globalQty"
                           class="form-control text-center font-weight-bold"
                           value="{{ old('quantity',1) }}" min="1" onchange="recalcAll()">
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group mb-3">
                    <label class="field-label">Setup $</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                        <input type="number" name="setup_price" step="0.01" class="form-control" value="{{ old('setup_price',0) }}">
                    </div>
                </div>
            </div>
         
        </div>

        {{-- ── Row 2: Dates ── --}}
        <div class="row align-items-end">
            <div class="col-md-2">
                <div class="form-group mb-2">
                    <label class="field-label"><i class="fas fa-calendar-alt mr-1 text-primary"></i>Quote Date</label>
                    <input type="text" name="quote_date" id="quoteDatePicker"
                           class="form-control datepicker"
                           value="{{ old('quote_date') ? \Carbon\Carbon::parse(old('quote_date'))->format('m/d/Y') : \Carbon\Carbon::today()->format('m/d/Y') }}"
                           placeholder="MM/DD/YYYY" autocomplete="off">
                    <input type="hidden" name="quote_date_raw" id="quoteDateRaw" value="{{ old('quote_date', date('Y-m-d')) }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-2">
                    <label class="field-label"><i class="fas fa-calendar-check mr-1 text-warning"></i>Due Date</label>
                    <input type="text" name="due_date" id="dueDatePicker"
                           class="form-control datepicker"
                           value="{{ old('due_date') ? \Carbon\Carbon::parse(old('due_date'))->format('m/d/Y') : '' }}"
                           placeholder="MM/DD/YYYY" autocomplete="off">
                    <input type="hidden" name="due_date_raw" id="dueDateRaw" value="{{ old('due_date') }}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-2">
                    <label class="field-label"><i class="fas fa-hourglass-half mr-1 text-success"></i>Valid Until</label>
                    <input type="text" name="valid_until" id="validUntilPicker"
                           class="form-control datepicker"
                           value="{{ old('valid_until') ? \Carbon\Carbon::parse(old('valid_until'))->format('m/d/Y') : '' }}"
                           placeholder="MM/DD/YYYY" autocomplete="off">
                    <input type="hidden" name="valid_until_raw" id="validUntilRaw" value="{{ old('valid_until') }}">
                </div>
            </div>

               <div class="col-md-2">
                <div class="form-group mb-3">
                    <label class="field-label">Part #</label>
                    <input type="text" name="part_number" class="form-control" value="{{ old('part_number') }}" placeholder="e.g. P-1001">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group mb-3">
                    <label class="field-label">Cage Number</label>
                    <input type="text" name="cage_number" class="form-control text-center" value="{{ old('cage_number') }}" placeholder="A">
                </div>
            </div>

            {{-- PO Number - shown only for job_order --}}
            <div class="col-md-2" id="poNumberField" style="display:none;">
                <div class="form-group mb-2">
                    <label class="field-label"><i class="fas fa-hashtag mr-1 text-info"></i>PO Number (auto)</label>
                    <input type="text" name="po_number" id="poNumber"
                           class="form-control bg-light font-weight-bold"
                           readonly placeholder="Auto-generated">
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ══ CARD 2: CUSTOMER ══ --}}
<div class="card">
    <div class="card-header">
        <div class="d-flex justify-content-between align-items-center">
            <h3 class="card-title"><i class="fas fa-user mr-2"></i>Customer</h3>
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input" id="isTempCustomer" onchange="toggleTempCustomer()">
                <label class="custom-control-label" for="isTempCustomer">Walk-in / Temp</label>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4" id="customerSelectGroup">
                <div class="form-group">
                    <label class="field-label">Select Customer</label>
                    <div class="d-flex align-items-center gap-2" style="gap:8px;">
                        <div style="flex:1; min-width:0;">
                            <select name="customer_id" id="customerSelect" class="form-control" style="width:100%;">
                                <option value="">-- Select Customer --</option>
                                @foreach($customers as $c)
                                    @php
                                        $ship = optional($c->defaultShippingAddress);
                                        $bill = optional($c->billingAddress);
                                        $shipStr = collect([$ship->address_line_1 ?? null, $ship->city ?? null, $ship->state ?? null])->filter()->implode(', ');
                                        $billStr = collect([$bill->address_line_1 ?? null, $bill->city ?? null, $bill->state ?? null])->filter()->implode(', ');
                                    @endphp
                                    <option value="{{ $c->id }}" data-ship="{{ $shipStr }}" data-bill="{{ $billStr }}"
                                        {{ old('customer_id')==$c->id ? 'selected':'' }}>
                                        {{ $c->name }} ({{ $c->customer_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="button" class="btn btn-success flex-shrink-0"
                                style="width:36px;height:38px;padding:0;border-radius:6px;"
                                onclick="$('#modalAddCustomer').modal('show')" title="Add New Customer">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-5" id="tempCustomerFields" style="display:none;">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="field-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="temp_customer_name" class="form-control" placeholder="Full name">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="field-label">Email</label>
                            <input type="email" name="temp_customer_email" class="form-control" placeholder="email@...">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="field-label">Phone</label>
                            <input type="text" name="temp_customer_phone" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="field-label">Ship To</label>
                            <textarea name="ship_to" id="shipTo" class="form-control" rows="2">{{ old('ship_to') }}</textarea>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="field-label">Bill To</label>
                            <textarea name="bill_to" id="billTo" class="form-control" rows="2">{{ old('bill_to') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══ CARD 3: SHAPE & MATERIAL ══ --}}
<div class="card">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-cube mr-2"></i>Shape &amp; Material</h3></div>
    <div class="card-body pb-2">

        {{-- ── Row 1: Shape + conditional dimension field ── --}}
        <div class="row align-items-end">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Shape</label>
                    <select name="shape" id="shapeSelect" class="form-control" onchange="toggleShapeFields()">
                        <option value="round">Round</option>
                        <option value="square">Square</option>
                        <option value="hexagon">Hexagon</option>
                        <option value="width_length_height">Width x Length x Height</option>
                    </select>
                </div>
            </div>

            {{-- Pin Size Diameter + Diameter Adjustment: hidden when W×L×H selected --}}
            <div id="pinFields" class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Pin Size Diameter</label>
                    <input type="number" step="0.0001" name="pin_diameter" id="pinDiameter"
                           class="form-control" placeholder="0" onchange="calcVolume()">
                </div>
            </div>
            <div id="pinLengthField" class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Diameter Adjustment</label>
                    <input type="number" step="0.0001" name="pin_length_row1" id="pinLengthRow1"
                           class="form-control" placeholder="0" onchange="syncPinLength()">
                </div>
            </div>

            {{-- WLH: hidden until shape = width_length_height --}}
            <div id="wlhFields" style="display:none;" class="col-md-4">
                {{-- shown below in row 3 --}}
            </div>
        </div>

        {{-- ── Row 2: Material Type | Metal Alloy | Block Price | Adj Price | Real Price | Overall Pin Length ── --}}
        <div class="row align-items-end">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Material Type</label>
                    <select name="material_type" id="materialType" class="form-control">
                        <option value="">-- All Types --</option>
                        <option value="metal_alloy">Metal Alloy</option>
                        <option value="plastic">Plastic</option>
                        <option value="composite">Composite</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Material <span id="materialCountBadge" class="badge badge-info ml-1">0</span></label>
                    <select name="metal_alloy" id="metalAlloySelect" class="form-control">
                        <option value="">-- Select Material --</option>
                    </select>
                    <small class="text-muted" id="materialFilterHint">Filtered by unit &amp; type</small>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Block Price per LB/Kg</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                        <input type="number" step="0.0001" name="block_price" id="blockPrice"
                               class="form-control" value="0" onchange="calcMaterialTotal()">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Metal Adjustment Price</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                        <input type="number" step="0.0001" name="metal_adjustment" id="metalAdj"
                               class="form-control" value="0" onchange="calcMaterialTotal()">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Metal Real Price</label>
                    <input type="number" step="0.0001" name="metal_real_price" id="metalRealPrice"
                           class="form-control bg-light" readonly value="0">
                </div>
            </div>
            <div class="col-md-2" id="overallPinLengthField">
                <div class="form-group">
                    <label class="field-label">Over All Pin Length</label>
                    <input type="number" step="0.0001" name="pin_length" id="pinLength"
                           class="form-control" placeholder="0.0000" onchange="calcVolume()">
                </div>
            </div>
        </div>

        {{-- ── Row 3: W × L × H (only when shape = width_length_height) ── --}}
        <div id="wlhRow" style="display:none;">
            <div class="row align-items-end">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="field-label">Width</label>
                        <input type="number" step="0.0001" name="width" id="matWidth"
                               class="form-control" placeholder="0" onchange="calcVolume()">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="field-label">Length</label>
                        <input type="number" step="0.0001" name="length" id="matLength"
                               class="form-control" placeholder="0" onchange="calcVolume()">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="field-label">Height</label>
                        <input type="number" step="0.0001" name="height" id="matHeight"
                               class="form-control" placeholder="0" onchange="calcVolume()">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Row 4: Volumes & Weights (only for W×L×H) ── --}}
        <div id="wlhVolumeRow" style="display:none;">
        <div class="row align-items-end">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Cubic Inch Volume</label>
                    <input type="number" step="0.0001" name="cubic_inch_volume" id="cubicInch"
                           class="form-control bg-light" readonly value="0">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Cubic MM Volume</label>
                    <input type="number" step="0.0001" name="cubic_mm_volume" id="cubicMm"
                           class="form-control bg-light" readonly value="0">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Weight LB</label>
                    <input type="number" step="0.0001" name="weight_lb" id="weightLb"
                           class="form-control bg-light" readonly value="0">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Weight KG</label>
                    <input type="number" step="0.0001" name="weight_kg_display" id="weightKg"
                           class="form-control bg-light" readonly value="0">
                </div>
            </div>
        </div>
        </div>{{-- /wlhVolumeRow --}}

        {{-- ── Row 5: Prices & Total Weights ── --}}
        <div class="row align-items-end">
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Each Pin Price</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                        <input type="number" step="0.0001" name="each_pin_price" id="eachPinPrice"
                               class="form-control bg-light" readonly value="0">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Total Pin Price</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text">$</span></div>
                        <input type="number" step="0.01" name="total_pin_price" id="totalPinPrice"
                               class="form-control bg-light font-weight-bold" readonly value="0">
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Calculated Weight (kg)</label>
                    <input type="number" step="0.0001" name="calc_weight_kg" id="calcWeightKg"
                           class="form-control bg-light" readonly value="0">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Calculated Weight (lbs)</label>
                    <input type="number" step="0.0001" name="calc_weight_lbs" id="calcWeightLbs"
                           class="form-control bg-light" readonly value="0">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Total Calculated Weight (kg)</label>
                    <input type="number" step="0.0001" name="total_weight_kg_display" id="totalWeightKg"
                           class="form-control bg-light" readonly value="0">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label class="field-label">Total Calculated Weight (lbs)</label>
                    <input type="number" step="0.0001" name="total_weight_lb" id="totalWeightLb"
                           class="form-control bg-light font-weight-bold" readonly value="0">
                </div>
            </div>
        </div>

        {{-- hidden storage --}}
        <input type="hidden" name="weight_kg"       id="weightKgHidden"      value="0">
        <input type="hidden" name="total_weight_kg" id="totalWeightKgHidden" value="0">

        <hr class="mt-1 mb-3">

        {{-- Attachments --}}
        <div class="form-group mb-0">
            <label class="field-label"><i class="fas fa-paperclip mr-1"></i>Attachments <small class="text-muted font-weight-normal text-lowercase">(drag &amp; drop or click — PDF, JPG, PNG, DWG, DXF, STEP, STL)</small></label>
            <input type="file" name="attachments[]" id="fileInput" multiple
                   accept=".pdf,.jpg,.jpeg,.png,.dwg,.dxf,.step,.stp,.stl" style="display:none;">
            <div id="dropZone">
                <i class="fas fa-cloud-upload-alt text-muted fa-lg"></i>
                <span class="text-muted">Drop files here or click to browse</span>
            </div>
            <div id="filePreview" class="d-flex flex-wrap mt-2"></div>
        </div>
    </div>
</div>
{{-- ══ SECTION TABS ══ --}}
<div class="section-tabs">
    <button type="button" class="section-tab tab-machine active" onclick="showSection('machine',this)">
        <i class="fas fa-cog"></i> Machine <span class="badge-total" id="stab_machine">$0.00</span>
    </button>
    <button type="button" class="section-tab tab-ops" onclick="showSection('ops',this)">
        <i class="fas fa-tools"></i> Operations <span class="badge-total" id="stab_ops">$0.00</span>
    </button>
    <button type="button" class="section-tab tab-items" onclick="showSection('items',this)">
        <i class="fas fa-box"></i> Items <span class="badge-total" id="stab_items">$0.00</span>
    </button>
    <button type="button" class="section-tab tab-holes" onclick="showSection('holes',this)">
        <i class="fas fa-circle-notch"></i> Holes <span class="badge-total" id="stab_holes">$0.00</span>
    </button>
    <button type="button" class="section-tab tab-taps" onclick="showSection('taps',this)">
        <i class="fas fa-screwdriver"></i> Taps <span class="badge-total" id="stab_taps">$0.00</span>
    </button>
    <button type="button" class="section-tab tab-threads" onclick="showSection('threads',this)">
        <i class="fas fa-compress-arrows-alt"></i> Threads <span class="badge-total" id="stab_threads">$0.00</span>
    </button>
    <button type="button" class="section-tab tab-secondary" onclick="showSection('secondary',this)">
        <i class="fas fa-layer-group"></i> Secondary Ops <span class="badge-total" id="stab_secondary">$0.00</span>
    </button>
    <button type="button" class="section-tab tab-plating" onclick="showSection('plating',this)">
        <i class="fas fa-fire"></i> Plating &amp; Heat <span class="badge-total" id="stab_plating">$0.00</span>
    </button>
</div>
</div>{{-- /stickyHeader --}}

{{-- ══ MACHINE SECTION ══ --}}
<div class="section-panel show" id="sec_machine">
    <div class="card mb-3">
        <div class="panel-header" style="background:#495057;">
            <h6><i class="fas fa-cog mr-2"></i>Machine</h6>
            <div class="panel-actions">
                <span class="total-badge">$<span id="machineTotal">0.00</span></span>
                <button type="button" class="btn btn-light btn-sm" onclick="addMachineRow()">
                    <i class="fas fa-plus mr-1"></i> Add Machine
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center">#</th>
                            <th style="min-width:200px;">Machine</th>
                            <th style="min-width:120px;">Model</th>
                            <th style="min-width:110px;">Labor Mode</th>
                            <th style="min-width:180px;">Labour</th>
                            <th>Material</th>
                            <th>Complexity</th>
                            <th>Priority</th>
                            <th class="text-center" style="min-width:90px;">Time<br><small class="font-weight-normal">(min)</small></th>
                            <th class="text-center" style="min-width:100px;">Rate<br><small class="font-weight-normal">($/hr)</small></th>
                            <th class="text-center" style="min-width:110px;">Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="machineBody">
                        <tr class="empty-row"><td colspan="12" class="text-center text-muted py-3">Click "Add Machine" to begin</td></tr>
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="10" class="text-right font-weight-bold">Sub Total:</td>
                            <td class="text-right font-weight-bold text-success" colspan="2">
                                $<span id="machineTotalFoot">0.00</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ══ OPERATIONS SECTION ══ --}}
<div class="section-panel" id="sec_ops">
    <div class="card mb-3">
        <div class="panel-header" style="background:#28a745;">
            <h6><i class="fas fa-tools mr-2"></i>Operations</h6>
            <div class="panel-actions">
                <span class="total-badge">$<span id="operationTotal">0.00</span></span>
                <button type="button" class="btn btn-light btn-sm" onclick="addOperationRow()">
                    <i class="fas fa-plus mr-1"></i> Add Operation
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="min-width:200px;">Operation</th>
                            <th style="min-width:180px;">Labour</th>
                            <th>Time (min)</th>
                            <th>Rate ($/hr)</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="operationBody">
                        <tr class="empty-row"><td colspan="6" class="text-center text-muted py-3">Click "Add Operation" to begin</td></tr>
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="4" class="text-right font-weight-bold">Sub Total:</td>
                            <td class="text-right font-weight-bold text-success" colspan="2">
                                $<span id="operationTotalFoot">0.00</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ══ ITEMS SECTION ══ --}}
<div class="section-panel" id="sec_items">
    <div class="card mb-3">
        <div class="panel-header" style="background:#007bff;">
            <h6><i class="fas fa-box mr-2"></i>Items</h6>
            <div class="panel-actions">
                <span class="total-badge">$<span id="itemsTotal">0.00</span></span>
                <button type="button" class="btn btn-light btn-sm" onclick="addItemRow()">
                    <i class="fas fa-plus mr-1"></i> Add Item
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="min-width:200px;">Item</th>
                            <th>Description</th>
                            <th style="width:80px;">Qty</th>
                            <th>Rate ($)</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        <tr class="empty-row"><td colspan="6" class="text-center text-muted py-3">Click "Add Item" to begin</td></tr>
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="4" class="text-right font-weight-bold">Sub Total:</td>
                            <td class="text-right font-weight-bold text-success" colspan="2">
                                $<span id="itemsTotalFoot">0.00</span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ══ HOLES SECTION — Your screenshot design ══ --}}
<div class="section-panel" id="sec_holes">
    <div class="card mb-3">
        <div class="panel-header" style="background:#28a745;">
            <h6><i class="fas fa-circle-notch mr-2"></i>Holes</h6>
            <div class="panel-actions">
                <span class="total-badge">$<span id="holesTotal">0.00</span></span>
                <button type="button" class="btn btn-light btn-sm" onclick="addHoleRow()">
                    <i class="fas fa-plus mr-1"></i> Add Hole
                </button>
            </div>
        </div>
        <div class="card-body" id="holesBody" style="background:#f8f9fa;">
            <p class="text-muted text-center py-2 mb-0" id="holesEmpty">Click "Add Hole" to begin</p>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <strong>Sub Total: &nbsp; $<span id="holesTotalFoot">0.00</span></strong>
        </div>
    </div>
</div>

{{-- ══ TAPS SECTION — Your screenshot design ══ --}}
<div class="section-panel" id="sec_taps">
    <div class="card mb-3">
        <div class="panel-header" style="background:#dc3545;">
            <h6><i class="fas fa-screwdriver mr-2"></i>Taps</h6>
            <div class="panel-actions">
                <span class="total-badge">$<span id="tapsTotal">0.00</span></span>
                <button type="button" class="btn btn-light btn-sm" onclick="addTapRow()">
                    <i class="fas fa-plus mr-1"></i> Add Tap
                </button>
            </div>
        </div>
        <div class="card-body" id="tapsBody" style="background:#f8f9fa;">
            <p class="text-muted text-center py-2 mb-0" id="tapsEmpty">Click "Add Tap" to begin</p>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <strong>Sub Total: &nbsp; $<span id="tapsTotalFoot">0.00</span></strong>
        </div>
    </div>
</div>

{{-- ══ THREADS SECTION ══ --}}
<div class="section-panel" id="sec_threads">
    <div class="card mb-3">
        <div class="panel-header" style="background:#6f42c1;">
            <h6><i class="fas fa-compress-arrows-alt mr-2"></i>Threads</h6>
            <div class="panel-actions">
                <span class="total-badge">$<span id="threadsTotal">0.00</span></span>
                <button type="button" class="btn btn-light btn-sm" onclick="addThreadRow()">
                    <i class="fas fa-plus mr-1"></i> Add Thread
                </button>
            </div>
        </div>
        <div class="card-body" id="threadsBody" style="background:#f8f9fa;">
            <p class="text-muted text-center py-2 mb-0" id="threadsEmpty">Click "Add Thread" to begin</p>
        </div>
        <div class="card-footer d-flex justify-content-end">
            <strong>Sub Total: &nbsp; $<span id="threadsTotalFoot">0.00</span></strong>
        </div>
    </div>
</div>

{{-- ══ SECONDARY OPS SECTION ══ --}}
<div class="section-panel" id="sec_secondary">
    <div class="card mb-3">
        <div class="panel-header" style="background:#fd7e14;">
            <h6><i class="fas fa-layer-group mr-2"></i>Secondary Operations</h6>
            <div class="panel-actions">
                <span class="total-badge">$<span id="secondaryTotal">0.00</span></span>
                <button type="button" class="btn btn-light btn-sm" onclick="addSecondaryRow()">
                    <i class="fas fa-plus mr-1"></i> Add Operation
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-sm mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th style="min-width:180px;">Operation Name</th>
                            <th style="min-width:200px;">Vendor</th>
                            <th>Price Type</th><th style="width:80px;">Qty</th>
                            <th>Unit Price ($)</th><th>Total</th><th></th>
                        </tr>
                    </thead>
                    <tbody id="secondaryBody">
                        <tr class="empty-row"><td colspan="7" class="text-center text-muted py-3">Click "Add Operation" to begin</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ══ PLATING & HEAT SECTION ══ --}}
<div class="section-panel" id="sec_plating">
    <div class="card mb-3">
        <div class="panel-header" style="background:#e83e8c;">
            <h6><i class="fas fa-fire mr-2"></i>Plating &amp; Heat Treating</h6>
            <div class="panel-actions">
                <span class="total-badge">$<span id="platingHeatTotal">0.00</span></span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6 class="font-weight-bold border-bottom pb-1 mb-3 text-danger">Plating</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="field-label">Vendor</label>
                                <div class="d-flex align-items-center" style="gap:6px;">
                                    <div style="flex:1;min-width:0;">
                                        <select name="plating_vendor_id" id="platingVendorSelect" class="form-control form-control-sm" style="width:100%;">
                                            <option value="">🔍 Search vendor...</option>
                                            @foreach($vendors as $v)<option value="{{ $v->id }}">{{ $v->name }}</option>@endforeach
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-warning flex-shrink-0"
                                            style="width:32px;height:31px;padding:0;border-radius:4px;"
                                            onclick="openVendorModal('plating')" title="Add Vendor">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="field-label">Coating Type</label>
                                <input type="text" name="plating_type" class="form-control form-control-sm" placeholder="e.g. Zinc, Hard Chrome">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="field-label">Pricing</label>
                                <select name="plating_pricing_type" id="platingPricingType" class="form-control form-control-sm" onchange="togglePlatingFields()">
                                    <option value="per_each">Per Each</option>
                                    <option value="per_pound">Per Pound</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="plEachCnt"><div class="form-group"><label class="field-label">Count</label><input type="number" name="plating_count" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()"></div></div>
                        <div class="col-md-4" id="plEachPrc"><div class="form-group"><label class="field-label">$/Each</label><input type="number" step="0.01" name="plating_price_each" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()"></div></div>
                        <div class="col-md-4 d-none" id="plLbs"><div class="form-group"><label class="field-label">Total lbs</label><input type="number" step="0.01" name="plating_total_pounds" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()"></div></div>
                        <div class="col-md-4 d-none" id="plLot"><div class="form-group"><label class="field-label">Lot $</label><input type="number" step="0.01" name="plating_lot_charge" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()"></div></div>
                        <div class="col-md-4 d-none" id="plPpl"><div class="form-group"><label class="field-label">$/lb (>100)</label><input type="number" step="0.0001" name="plating_per_pound" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()"></div></div>
                        <div class="col-md-4"><div class="form-group"><label class="field-label">Salt Test $</label><input type="number" step="0.01" name="plating_salt_testing" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()"></div></div>
                        <div class="col-md-4"><div class="form-group"><label class="field-label">Surcharge $</label><input type="number" step="0.01" name="plating_surcharge" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()"></div></div>
                        <div class="col-md-4"><div class="form-group"><label class="field-label">Standards $</label><input type="number" step="0.01" name="plating_standards_price" class="form-control form-control-sm" value="0" onchange="calcPlatingTotal()"></div></div>
                        <div class="col-12"><div class="form-group"><label class="field-label font-weight-bold">Plating Total</label><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div><input type="number" step="0.01" name="plating_total" id="platingTotal" class="form-control bg-light font-weight-bold" readonly value="0"></div></div></div>
                    </div>
                </div>
                <div class="col-md-6 border-left">
                    <h6 class="font-weight-bold border-bottom pb-1 mb-3 text-warning">Heat Treating</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="field-label">Vendor</label>
                                <div class="d-flex align-items-center" style="gap:6px;">
                                    <div style="flex:1;min-width:0;">
                                        <select name="heat_vendor_id" id="heatVendorSelect" class="form-control form-control-sm" style="width:100%;">
                                            <option value="">🔍 Search vendor...</option>
                                            @foreach($vendors as $v)<option value="{{ $v->id }}">{{ $v->name }}</option>@endforeach
                                        </select>
                                    </div>
                                    <button type="button" class="btn btn-warning flex-shrink-0"
                                            style="width:32px;height:31px;padding:0;border-radius:4px;"
                                            onclick="openVendorModal('heat')" title="Add Vendor">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="field-label">Treatment Type</label>
                                <input type="text" name="heat_type" class="form-control form-control-sm" placeholder="e.g. Anneal, Harden">
                            </div>
                        </div>
                        <div class="col-md-4"><div class="form-group"><label class="field-label">Pricing</label><select name="heat_pricing_type" id="heatPricingType" class="form-control form-control-sm" onchange="toggleHeatFields()"><option value="per_each">Per Each</option><option value="per_pound">Per Pound</option></select></div></div>
                        <div class="col-md-4" id="htEachCnt"><div class="form-group"><label class="field-label">Count</label><input type="number" name="heat_count" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()"></div></div>
                        <div class="col-md-4" id="htEachPrc"><div class="form-group"><label class="field-label">$/Each</label><input type="number" step="0.01" name="heat_price_each" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()"></div></div>
                        <div class="col-md-4 d-none" id="htLbs"><div class="form-group"><label class="field-label">Total lbs</label><input type="number" step="0.01" name="heat_total_pounds" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()"></div></div>
                        <div class="col-md-4 d-none" id="htLot"><div class="form-group"><label class="field-label">Lot $</label><input type="number" step="0.01" name="heat_lot_charge" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()"></div></div>
                        <div class="col-md-4 d-none" id="htPpl"><div class="form-group"><label class="field-label">$/lb (>100)</label><input type="number" step="0.0001" name="heat_per_pound" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()"></div></div>
                        <div class="col-md-4"><div class="form-group"><label class="field-label">Testing $</label><input type="number" step="0.01" name="heat_testing" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()"></div></div>
                        <div class="col-md-4"><div class="form-group"><label class="field-label">Surcharge $</label><input type="number" step="0.01" name="heat_surcharge" class="form-control form-control-sm" value="0" onchange="calcHeatTotal()"></div></div>
                        <div class="col-12"><div class="form-group"><label class="field-label font-weight-bold">Heat Total</label><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div><input type="number" step="0.01" name="heat_total" id="heatTotal" class="form-control bg-light font-weight-bold" readonly value="0"></div></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══ FINAL CARD ══ --}}
<div class="card">
    <div class="card-header"><h3 class="card-title"><i class="fas fa-calculator mr-2"></i>Final Pricing &amp; Notes</h3></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-7">
                <table class="table table-sm table-bordered mb-0" id="summaryTable">
                    <thead class="thead-dark">
                        <tr>
                            <th style="min-width:140px;">Component</th>
                            <th class="text-right" style="min-width:110px;">Each ($)</th>
                            <th class="text-center" style="min-width:60px;">Qty</th>
                            <th class="text-right" style="min-width:120px;">Qty Total ($)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><i class="fas fa-layer-group text-primary mr-1"></i> Material</td>
                            <td class="text-right">$<span id="sum_material_each">0.00</span></td>
                            <td class="text-center"><span class="badge badge-secondary qty-badge">1</span></td>
                            <td class="text-right font-weight-bold text-dark">$<span id="sum_material_total">0.00</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-industry text-secondary mr-1"></i> Machine</td>
                            <td class="text-right">$<span id="sum_machine_each">0.00</span></td>
                            <td class="text-center"><span class="badge badge-secondary qty-badge">1</span></td>
                            <td class="text-right font-weight-bold text-dark">$<span id="sum_machine_total">0.00</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-cog text-info mr-1"></i> Operations</td>
                            <td class="text-right">$<span id="sum_ops_each">0.00</span></td>
                            <td class="text-center"><span class="badge badge-secondary qty-badge">1</span></td>
                            <td class="text-right font-weight-bold text-dark">$<span id="sum_ops_total">0.00</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-boxes text-warning mr-1"></i> Items</td>
                            <td class="text-right">$<span id="sum_items_each">0.00</span></td>
                            <td class="text-center"><span class="badge badge-secondary qty-badge">1</span></td>
                            <td class="text-right font-weight-bold text-dark">$<span id="sum_items_total">0.00</span></td>
                        </tr>
                        <tr>
                            <td><i class="far fa-circle text-primary mr-1"></i> Holes</td>
                            <td class="text-right">$<span id="sum_holes_each">0.00</span></td>
                            <td class="text-center"><span class="badge badge-secondary qty-badge">1</span></td>
                            <td class="text-right font-weight-bold text-dark">$<span id="sum_holes_total">0.00</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-screwdriver text-danger mr-1"></i> Taps</td>
                            <td class="text-right">$<span id="sum_taps_each">0.00</span></td>
                            <td class="text-center"><span class="badge badge-secondary qty-badge">1</span></td>
                            <td class="text-right font-weight-bold text-dark">$<span id="sum_taps_total">0.00</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-compress-arrows-alt mr-1" style="color:#6f42c1;"></i> Threads</td>
                            <td class="text-right">$<span id="sum_threads_each">0.00</span></td>
                            <td class="text-center"><span class="badge badge-secondary qty-badge">1</span></td>
                            <td class="text-right font-weight-bold text-dark">$<span id="sum_threads_total">0.00</span></td>
                        </tr>
                        <tr>
                            <td><i class="fas fa-layer-group mr-1" style="color:#fd7e14;"></i> Secondary Ops</td>
                            <td class="text-right">$<span id="sum_secondary_each">0.00</span></td>
                            <td class="text-center"><span class="badge badge-secondary qty-badge">1</span></td>
                            <td class="text-right font-weight-bold text-dark">$<span id="sum_secondary_total">0.00</span></td>
                        </tr>
                        <tr class="table-info">
                            <td><i class="fas fa-tint mr-1"></i> <strong>Plating</strong></td>
                            <td class="text-right">$<span id="sum_plating_each">0.00</span></td>
                            <td class="text-center text-muted">—</td>
                            <td class="text-right font-weight-bold">$<span id="sum_plating_total">0.00</span></td>
                        </tr>
                        <tr class="table-warning">
                            <td><i class="fas fa-fire mr-1"></i> <strong>Heat Treatment</strong></td>
                            <td class="text-right">$<span id="sum_heat_each">0.00</span></td>
                            <td class="text-center text-muted">—</td>
                            <td class="text-right font-weight-bold">$<span id="sum_heat_total">0.00</span></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr class="table-success">
                            <td class="font-weight-bold">Sub Total</td>
                            <td class="text-right font-weight-bold">$<span id="sum_subtotal_each">0.00</span></td>
                            <td class="text-center"><span class="badge badge-success qty-badge">1</span></td>
                            <td class="text-right font-weight-bold">$<span id="sum_subtotal_total">0.00</span></td>
                        </tr>
                        <tr class="table-dark">
                            <td class="font-weight-bold"><i class="fas fa-calculator mr-1"></i> GRAND TOTAL</td>
                            <td class="text-right font-weight-bold">$<span id="sum_grand_each">0.00</span></td>
                            <td class="text-center"><span class="badge badge-light qty-badge">1</span></td>
                            <td class="text-right font-weight-bold text-success" style="font-size:15px;">$<span id="sum_grand_total">0.00</span></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="col-md-5">
                <div class="form-group"><label class="field-label">Break-In Charge ($)</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">$</span></div><input type="number" step="0.01" name="break_in_charge" id="breakInCharge" class="form-control" value="0" onchange="recalcAll()"></div></div>
                <div class="form-group"><label class="field-label">Override Price Each ($) <small class="text-muted">0 = auto</small></label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">$</span></div><input type="number" step="0.01" name="override_price" id="overridePrice" class="form-control" value="0" onchange="recalcAll()"></div></div>
                <div class="form-group"><label class="field-label font-weight-bold">Grand Each Price</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text">$</span></div><input type="number" step="0.01" name="grand_each_price" id="grandEachPrice" class="form-control bg-light font-weight-bold" readonly value="0"></div></div>
                <div class="form-group"><label class="field-label font-weight-bold text-success">Grand Total Price</label><div class="input-group"><div class="input-group-prepend"><span class="input-group-text bg-success text-white">$</span></div><input type="number" step="0.01" name="grand_total_price" id="grandTotalPrice" class="form-control bg-light font-weight-bold text-success" readonly value="0"></div></div>
                <div class="form-group"><label class="field-label">Engineer Notes</label><textarea name="engineer_notes" class="form-control" rows="3">{{ old('engineer_notes') }}</textarea></div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="d-flex justify-content-between">
            <a href="{{ route('company.quotes.index') }}" class="btn btn-secondary"><i class="fas fa-times mr-1"></i> Cancel</a>
            <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-check mr-1"></i> Save Quote</button>
        </div>
    </div>
</div>

</form>
</div>
</div>
{{-- ══════════════════════════════════════════════════
     MODALS
══════════════════════════════════════════════════ --}}

{{-- ── Add Customer Modal ── --}}
<div class="modal fade" id="modalAddCustomer" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-user-plus mr-2"></i>Quick Add Customer</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4"><div class="form-group"><label>Name <span class="text-danger">*</span></label><input type="text" id="mc_name" class="form-control"></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Code <span class="text-danger">*</span></label><input type="text" id="mc_code" class="form-control" placeholder="CUST-001"></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Type</label><select id="mc_type" class="form-control"><option value="individual">Individual</option><option value="company">Company</option></select></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Email</label><input type="email" id="mc_email" class="form-control"></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Phone</label><input type="text" id="mc_phone" class="form-control"></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Payment Terms (days)</label><input type="number" id="mc_terms" class="form-control" value="30"></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="saveCustomerAjax()"><i class="fas fa-check mr-1"></i> Save Customer</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Add Machine Modal ── --}}
<div class="modal fade" id="modalAddMachine" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title"><i class="fas fa-cog mr-2"></i>Quick Add Machine</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6"><div class="form-group"><label>Name <span class="text-danger">*</span></label><input type="text" id="mm_name" class="form-control"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Code <span class="text-danger">*</span></label><input type="text" id="mm_code" class="form-control" placeholder="MCH-001"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Manufacturer</label><input type="text" id="mm_manufacturer" class="form-control"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Model</label><input type="text" id="mm_model" class="form-control"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Status</label><select id="mm_status" class="form-control"><option value="active">Active</option><option value="maintenance">Maintenance</option><option value="inactive">Inactive</option></select></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Description</label><input type="text" id="mm_desc" class="form-control"></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-dark" onclick="saveMachineAjax()"><i class="fas fa-check mr-1"></i> Save Machine</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Add Operation Modal ── --}}
<div class="modal fade" id="modalAddOperation" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background:#28a745;" class="text-white">
                <h5 class="modal-title text-white"><i class="fas fa-tools mr-2"></i>Quick Add Operation</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6"><div class="form-group"><label>Name <span class="text-danger">*</span></label><input type="text" id="mo_name" class="form-control"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Code <span class="text-danger">*</span></label><input type="text" id="mo_code" class="form-control" placeholder="OP-001"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Hourly Rate ($)</label><input type="number" step="0.01" id="mo_rate" class="form-control" value="0"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Status</label><select id="mo_status" class="form-control"><option value="active">Active</option><option value="inactive">Inactive</option></select></div></div>
                    <div class="col-12"><div class="form-group"><label>Description</label><input type="text" id="mo_desc" class="form-control"></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="saveOperationAjax()"><i class="fas fa-check mr-1"></i> Save Operation</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Add Labour/Operator Modal ── --}}
<div class="modal fade" id="modalAddLabour" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title"><i class="fas fa-user-hard-hat mr-2"></i>Quick Add Labour / Operator</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6"><div class="form-group"><label>Name <span class="text-danger">*</span></label><input type="text" id="ml_name" class="form-control"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Code <span class="text-danger">*</span></label><input type="text" id="ml_code" class="form-control" placeholder="OPR-001"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Hourly Rate ($)</label><input type="number" step="0.01" id="ml_rate" class="form-control" value="0"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Skill Level</label><select id="ml_skill" class="form-control"><option value="trainee">Trainee</option><option value="junior">Junior</option><option value="senior">Senior</option><option value="expert">Expert</option></select></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Phone</label><input type="text" id="ml_phone" class="form-control"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Status</label><select id="ml_status" class="form-control"><option value="active">Active</option><option value="inactive">Inactive</option></select></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info" onclick="saveLabourAjax()"><i class="fas fa-check mr-1"></i> Save Labour</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Add Item Modal ── --}}
<div class="modal fade" id="modalAddItem" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-box mr-2"></i>Quick Add Item</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4"><div class="form-group"><label>Name <span class="text-danger">*</span></label><input type="text" id="mi_name" class="form-control"></div></div>
                    <div class="col-md-4"><div class="form-group"><label>SKU <span class="text-danger">*</span></label><input type="text" id="mi_sku" class="form-control"></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Class <span class="text-danger">*</span></label><select id="mi_class" class="form-control"><option value="tooling">Tooling</option><option value="sellable">Sellable</option><option value="raw_stock">Raw Stock</option><option value="consommable">Consumable</option></select></div></div>
                    <div class="col-md-3"><div class="form-group"><label>Unit</label><select id="mi_unit" class="form-control"><option value="each">Each</option><option value="kg">kg</option><option value="lb">lb</option><option value="meter">Meter</option><option value="foot">Foot</option></select></div></div>
                    <div class="col-md-3"><div class="form-group"><label>Cost Price $</label><input type="number" step="0.01" id="mi_cost" class="form-control" value="0"></div></div>
                    <div class="col-md-3"><div class="form-group"><label>Sell Price $</label><input type="number" step="0.01" id="mi_sell" class="form-control" value="0"></div></div>
                    <div class="col-md-3"><div class="form-group"><label>Description</label><input type="text" id="mi_desc" class="form-control"></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="saveItemAjax()"><i class="fas fa-check mr-1"></i> Save Item</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Add Vendor Modal ── --}}
<div class="modal fade" id="modalAddVendor" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="fas fa-building mr-2"></i>Quick Add Vendor</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6"><div class="form-group"><label>Name <span class="text-danger">*</span></label><input type="text" id="mv_name" class="form-control"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Code <span class="text-danger">*</span></label><input type="text" id="mv_code" class="form-control" placeholder="VND-001"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Type</label><select id="mv_type" class="form-control"><option value="supplier">Supplier</option><option value="manufacturer">Manufacturer</option><option value="distributor">Distributor</option><option value="contractor">Contractor</option></select></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Email</label><input type="email" id="mv_email" class="form-control"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Phone</label><input type="text" id="mv_phone" class="form-control"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Payment Terms (days)</label><input type="number" id="mv_terms" class="form-control" value="30"></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="saveVendorAjax()"><i class="fas fa-check mr-1"></i> Save Vendor</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Add Chamfer Modal ── --}}
<div class="modal fade" id="modalAddChamfer" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Add Chamfer</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Code <span class="text-danger">*</span></label><input type="text" id="mch_code" class="form-control" placeholder="CH-001"></div>
                <div class="form-group"><label>Name <span class="text-danger">*</span></label><input type="text" id="mch_name" class="form-control" placeholder="e.g. 0.5mm × 45°"></div>
                <div class="form-group"><label>Size (mm) <span class="text-danger">*</span></label><input type="number" step="0.001" id="mch_size" class="form-control" value="0.5"></div>
                <div class="form-group"><label>Angle (°)</label><input type="number" step="0.1" id="mch_angle" class="form-control" value="45"></div>
                <div class="form-group"><label>Price ($) <span class="text-danger">*</span></label><input type="number" step="0.01" id="mch_price" class="form-control" value="0"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning btn-sm" onclick="saveChamferAjax()"><i class="fas fa-check mr-1"></i> Save</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Add Debur Modal ── --}}
<div class="modal fade" id="modalAddDebur" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Add Debur</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group"><label>Code <span class="text-danger">*</span></label><input type="text" id="mdb_code" class="form-control" placeholder="DB-001"></div>
                <div class="form-group"><label>Name <span class="text-danger">*</span></label><input type="text" id="mdb_name" class="form-control" placeholder="e.g. Standard Debur"></div>
                <div class="form-group"><label>Size (mm)</label><input type="number" step="0.001" id="mdb_size" class="form-control" value="0"></div>
                <div class="form-group"><label>Price ($) <span class="text-danger">*</span></label><input type="number" step="0.01" id="mdb_price" class="form-control" value="0"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-info btn-sm" onclick="saveDeburAjax()"><i class="fas fa-check mr-1"></i> Save</button>
            </div>
        </div>
    </div>
</div>

{{-- ── Add Tap Modal ── --}}
<div class="modal fade" id="modalAddTap" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-screwdriver mr-2"></i>Quick Add Tap</h5>
                <button type="button" class="close text-white" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6"><div class="form-group"><label>Name <span class="text-danger">*</span></label><input type="text" id="mt_name" class="form-control" placeholder="e.g. M6×1.0"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Code <span class="text-danger">*</span></label><input type="text" id="mt_code" class="form-control" placeholder="TAP-001"></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Diameter (mm)</label><input type="number" step="0.001" id="mt_dia" class="form-control" value="6"></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Pitch (mm)</label><input type="number" step="0.001" id="mt_pitch" class="form-control" value="1"></div></div>
                    <div class="col-md-4"><div class="form-group"><label>Direction</label><select id="mt_dir" class="form-control"><option value="right">Right</option><option value="left">Left</option></select></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Thread Standard</label><select id="mt_std" class="form-control"><option value="metric">Metric</option><option value="UNC">UNC</option><option value="UNF">UNF</option><option value="BSP">BSP</option><option value="NPT">NPT</option></select></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Tap Price ($) <span class="text-danger">*</span></label><input type="number" step="0.01" id="mt_price" class="form-control" value="0"></div></div>
                    <div class="col-md-6"><div class="form-group"><label>Status</label><select id="mt_status" class="form-control"><option value="active">Active</option><option value="inactive">Inactive</option></select></div></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" onclick="saveTapAjax()"><i class="fas fa-check mr-1"></i> Save Tap</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
// ══════════════════════════════════════════════════════════
// DATA FROM BACKEND (pre-built in controller, no closures)
// ══════════════════════════════════════════════════════════
var machinesData   = @json($machinesJs);
var operationsData = @json($operationsJs);
var itemsData      = @json($itemsJs);
var vendorsData    = @json($vendorsJs);
var tapsData       = @json($tapsJs);
var threadsData    = @json($threadsJs ?? []);
var operatorsData  = @json($operatorsJs);
var chamfersData   = @json($chamfersJs);
var debursData     = @json($debursJs);

var csrf = document.querySelector('meta[name="csrf-token"]').content;

// ══════════════════════════════════════════════════════════
// INIT
// ══════════════════════════════════════════════════════════
$(document).ready(function(){
    // ── Flatpickr date pickers (MM/DD/YYYY) ──
    if(typeof flatpickr !== 'undefined'){
        var dpConfig = {
            dateFormat: 'm/d/Y',
            allowInput: true,
            disableMobile: true,
            onChange: function(selectedDates, dateStr, instance){
                // sync hidden raw Y-m-d field for backend
                var rawId = instance.element.id.replace('Picker', 'Raw');
                var rawField = document.getElementById(rawId);
                if(rawField && selectedDates.length){
                    var d = selectedDates[0];
                    rawField.value = d.getFullYear()+'-'
                        +String(d.getMonth()+1).padStart(2,'0')+'-'
                        +String(d.getDate()).padStart(2,'0');
                }
            }
        };
        flatpickr('#quoteDatePicker',  dpConfig);
        flatpickr('#dueDatePicker',    dpConfig);
        flatpickr('#validUntilPicker', dpConfig);
    }

    // ── Init section panels with inline style (belt + suspenders) ──
    document.querySelectorAll('.section-panel').forEach(function(p){
        p.style.display = 'none';
    });
    var firstPanel = document.getElementById('sec_machine');
    if(firstPanel){ firstPanel.style.display = 'block'; }

    // ── Select2 init helper ──
    function initSelect2(selector, placeholder, onChange){
        if(typeof $.fn.select2 !== 'function') {
            if(onChange) $(selector).on('change', onChange);
            return;
        }
        var $el = $(selector).select2({
            theme: 'bootstrap4',
            placeholder: placeholder || '-- Select --',
            allowClear: true,
            width: '100%'
        });
        if(onChange) $el.on('change', onChange);
        return $el;
    }

    // Customer dropdown
    initSelect2('#customerSelect', '🔍 Search customer...', function(){
        var opt = $(this).find(':selected');
        $('#shipTo').val(opt.data('ship') || '');
        $('#billTo').val(opt.data('bill') || '');
    });

    // Metal alloy dropdown
    // Load materials from server and filter by current unit + type
    loadMaterials();

    // Re-filter whenever unit OR material type changes
    $('#globalUnit').off('change.matfilter').on('change.matfilter', function(){
        filterMaterials();
    });
    $('#materialType').off('change.matfilter').on('change.matfilter', function(){
        filterMaterials();
    });

    initSelect2('#metalAlloySelect', '-- Select Material --', function(){
        updateMetalPrice();
    });

    // Plating & Heat vendor dropdowns
    initSelect2('#platingVendorSelect', '🔍 Search vendor...');
    initSelect2('#heatVendorSelect',    '🔍 Search vendor...');

    // ── Drag & Drop (file input is OUTSIDE dropzone to prevent click loop) ──
    var dz  = document.getElementById('dropZone');
    var fin = document.getElementById('fileInput');

    dz.addEventListener('click', function(e){
        e.stopPropagation();
        fin.click();
    });
    dz.addEventListener('dragover', function(e){
        e.preventDefault(); e.stopPropagation();
        dz.classList.add('drag-over');
    });
    dz.addEventListener('dragleave', function(e){
        e.stopPropagation();
        dz.classList.remove('drag-over');
    });
    dz.addEventListener('drop', function(e){
        e.preventDefault(); e.stopPropagation();
        dz.classList.remove('drag-over');
        handleFiles(e.dataTransfer.files);
    });
    fin.addEventListener('change', function(){
        handleFiles(this.files);
    });
});

// ══════════════════════════════════════════════════════════
// SELECT2 ROW HELPER  
// ══════════════════════════════════════════════════════════
function s2(selector, placeholder){
    if(typeof $.fn.select2 !== 'function') return;
    $(selector).select2({
        theme: 'bootstrap4',
        placeholder: placeholder || '-- Select --',
        allowClear: false,
        width: '100%',
        dropdownParent: $(selector).closest('.card, form')
    });
}

// ══════════════════════════════════════════════════════════
// SECTION TABS
// ══════════════════════════════════════════════════════════
function showSection(name, btn){
    // Hide all panels
    document.querySelectorAll('.section-panel').forEach(function(p){
        p.classList.remove('show');
        p.style.display = 'none';
    });
    // Deactivate all tabs
    document.querySelectorAll('.section-tab').forEach(function(t){
        t.classList.remove('active');
    });
    // Show selected panel
    var panel = document.getElementById('sec_' + name);
    if(panel){
        panel.classList.add('show');
        panel.style.display = 'block';
    }
    // Activate selected tab
    btn.classList.add('active');
}

// ══════════════════════════════════════════════════════════
// TYPE CHANGE — show PO number when job_order selected
// ══════════════════════════════════════════════════════════
function onTypeChange(){
    var t = document.getElementById('quoteType').value;
    var poField = document.getElementById('poNumberField');
    if(t === 'job_order'){
        poField.style.display = '';
        // Auto-generate PO number based on current quote number pattern
        var qn = document.getElementById('quoteNumber').value;
        document.getElementById('poNumber').value = 'PO' + qn.replace(/^QT/, '');
    } else {
        poField.style.display = 'none';
    }
}

// ══════════════════════════════════════════════════════════
// CUSTOMER TOGGLE
// ══════════════════════════════════════════════════════════
function toggleTempCustomer(){
    var temp = $('#isTempCustomer').is(':checked');
    $('#customerSelectGroup').toggle(!temp);
    $('#tempCustomerFields').toggle(temp);
}

// ══════════════════════════════════════════════════════════
// VENDOR MODAL CONTEXT
// ══════════════════════════════════════════════════════════
var vendorContext = null;
function openVendorModal(ctx){ vendorContext = ctx; $('#modalAddVendor').modal('show'); }

// ══════════════════════════════════════════════════════════
// ATTACHMENTS
// ══════════════════════════════════════════════════════════
var attachedFiles = [];
function handleFiles(files){
    Array.from(files).forEach(function(f){
        if(f.size > 20*1024*1024){ toastr.error(f.name + ' exceeds 20MB'); return; }
        var idx = attachedFiles.length;
        attachedFiles.push(f);
        var w = document.createElement('div');
        w.id = 'att_' + idx;
        w.style.cssText = 'position:relative;margin:4px;text-align:center;width:80px;';
        var ext = f.name.split('.').pop().toUpperCase();
        if(f.type.startsWith('image/')){
            var r = new FileReader();
            r.onload = function(e){
                w.innerHTML = '<img src="'+e.target.result+'" style="width:80px;height:60px;object-fit:cover;border:1px solid #dee2e6;border-radius:4px;">'
                    + '<button type="button" onclick="removeAtt('+idx+')" style="position:absolute;top:-5px;right:-5px;background:#dc3545;color:#fff;border:none;border-radius:50%;width:18px;height:18px;font-size:10px;cursor:pointer;">×</button>'
                    + '<div style="font-size:9px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;width:80px;">'+f.name+'</div>';
            };
            r.readAsDataURL(f);
        } else {
            w.innerHTML = '<div style="width:80px;height:60px;background:#f8f9fa;border:1px solid #dee2e6;border-radius:4px;display:flex;align-items:center;justify-content:center;"><span style="font-size:11px;font-weight:bold;">'+ext+'</span></div>'
                + '<button type="button" onclick="removeAtt('+idx+')" style="position:absolute;top:-5px;right:-5px;background:#dc3545;color:#fff;border:none;border-radius:50%;width:18px;height:18px;font-size:10px;cursor:pointer;">×</button>'
                + '<div style="font-size:9px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;width:80px;">'+f.name+'</div>';
        }
        document.getElementById('filePreview').appendChild(w);
        syncFileInput();
    });
}
function removeAtt(idx){ attachedFiles.splice(idx,1); var el=document.getElementById('att_'+idx); if(el)el.remove(); syncFileInput(); }
function syncFileInput(){ var dt=new DataTransfer(); attachedFiles.forEach(function(f){dt.items.add(f);}); document.getElementById('fileInput').files=dt.files; }

// ══════════════════════════════════════════════════════════
// SHAPE & MATERIAL
// ══════════════════════════════════════════════════════════
function toggleShapeFields(){
    var s = $('#shapeSelect').val();
    var isWLH = (s === 'width_length_height');
    // Pin Size Diameter & Diameter Adjustment — hide only for W×L×H
    $('#pinFields').toggle(!isWLH);
    $('#pinLengthField').toggle(!isWLH);
    // W×L×H rows appear only for that shape
    $('#wlhRow').toggle(isWLH);
    $('#wlhVolumeRow').toggle(isWLH);
    calcVolume();
}
// ── All materials loaded from server once ──────────────────
var _allMaterials = [];

function loadMaterials(){
    $.getJSON('{{ route("company.materials.ajax-list") }}', function(data){
        _allMaterials = data;
        filterMaterials();
    }).fail(function(){
        console.warn('Could not load materials from server.');
    });
}

function filterMaterials(){
    var unit = $('#globalUnit').val();          // 'mm' or 'inch'
    var type = $('#materialType').val();        // '' | 'metal_alloy' | 'plastic' | etc.

    var filtered = _allMaterials.filter(function(m){
        var unitMatch = (m.unit === unit);
        var typeMatch = (!type || m.type === type);
        return unitMatch && typeMatch;
    });

    var $sel = $('#metalAlloySelect');
    var prev = $sel.val();
    $sel.empty().append('<option value="">-- Select Material --</option>');

    filtered.forEach(function(m){
        var label = m.name;
        if(m.diameter_from > 0 || m.diameter_to > 0){
            label += ' (' + parseFloat(m.diameter_from).toFixed(2)
                  + ' – ' + parseFloat(m.diameter_to).toFixed(2)
                  + ' ' + m.unit + ')';
        }
        $sel.append(
            $('<option>', {
                value: m.id,
                text:  label
            })
            .data('price',   m.real_price)
            .data('density', m.density)
            .data('unit',    m.unit)
            .data('adj',     m.adj)
            .data('adj_type',m.adj_type)
        );
    });

    // Restore previous selection if still available
    if(prev) $sel.val(prev);

    // Update count badge
    $('#materialCountBadge').text(filtered.length);

    // Re-init Select2 if active
    if(typeof $.fn.select2 === 'function' && $sel.hasClass('select2-hidden-accessible')){
        $sel.trigger('change.select2');
    }

    updateMetalPrice();
}

function updateMetalPrice(){
    var opt   = $('#metalAlloySelect').find(':selected');
    var price = parseFloat(opt.data('price') || 0);
    if(price > 0){
        $('#blockPrice').val(price.toFixed(4));
    }
    calcMaterialTotal();
}

function syncPinLength(){
    // Keep row1 pin length in sync with Row2 "Over All Pin Length" field
    var val = $('#pinLengthRow1').val();
    $('#pinLength').val(val);
    calcVolume();
}

function toggleMaterialType(){
    // kept for backwards compat — now handled by filterMaterials()
    filterMaterials();
}
function calcMaterialTotal(){
    var block = parseFloat($('#blockPrice').val())||0;
    var adj   = parseFloat($('#metalAdj').val())||0;
    $('#metalRealPrice').val((block+adj).toFixed(4));
    calcVolume();
}
function calcVolume(){
    var shape   = $('#shapeSelect').val();
    var $matOpt  = $('#metalAlloySelect').find(':selected');
    var matUnit  = $matOpt.data('unit') || unit;
    var rawDensity = parseFloat($matOpt.data('density')) || 0;
    // Convert to usable lb/in³:
    // If material unit is mm → density stored as kg/m³ → convert to lb/in³ (÷ 27679.9)
    // If material unit is inch → density already in lb/in³
    var density;
    if(rawDensity > 100){
        // kg/m³ — convert to lb/in³
        density = rawDensity / 27679.9;
    } else {
        // already lb/in³
        density = rawDensity || 0.284;
    }
    var unit    = $('#globalUnit').val();
    var qty     = parseInt($('#globalQty').val())||1;
    var real    = parseFloat($('#metalRealPrice').val())||0;
    var volIn3  = 0; // cubic inches
    var weightLb = 0;

    if(shape === 'width_length_height'){
        var w = parseFloat($('#matWidth').val())||0;
        var l = parseFloat($('#matLength').val())||0;
        var h = parseFloat($('#matHeight').val())||0;
        volIn3   = unit==='mm' ? (w*l*h)/16387.064 : w*l*h;
    } else {
        // round/square/hex — use diameter adjustment + overall pin length
        var d  = parseFloat($('#pinDiameter').val())||0;
        var pl = parseFloat($('#pinLength').val())||0;
        volIn3 = unit==='mm'
            ? (Math.PI*(d/2)*(d/2)*pl)/16387.064
            : Math.PI*(d/2)*(d/2)*pl;
    }

    var volMm3   = volIn3 * 16387.064;
    weightLb     = volIn3 * density;
    var weightKg = weightLb * 0.453592;

    // Row 4 — volumes & weight per piece
    $('#cubicInch').val(volIn3.toFixed(4));
    $('#cubicMm').val(volMm3.toFixed(2));
    $('#weightLb').val(weightLb.toFixed(4));
    $('#weightKg').val(weightKg.toFixed(4));

    // Row 5 — prices & total weights
    var eachPrice  = weightLb * real;
    var totalPrice = eachPrice * qty;
    $('#eachPinPrice').val(eachPrice.toFixed(4));
    $('#totalPinPrice').val(totalPrice.toFixed(2));
    $('#calcWeightKg').val(weightKg.toFixed(4));
    $('#calcWeightLbs').val(weightLb.toFixed(4));
    $('#totalWeightKg').val((weightKg*qty).toFixed(4));
    $('#totalWeightLb').val((weightLb*qty).toFixed(4));

    // Hidden fields for form submit
    $('#weightKgHidden').val(weightKg.toFixed(4));
    $('#totalWeightKgHidden').val((weightKg*qty).toFixed(4));

    recalcAll();
}

// ══════════════════════════════════════════════════════════
// HELPERS
// ══════════════════════════════════════════════════════════
function f2(v){ return (parseFloat(v)||0).toFixed(2); }
function clearEmpty(id){ var b=$('#'+id); if(b.find('tr.empty-row').length) b.empty(); }
function clearEmptyDiv(id){ var e=document.getElementById(id+'Empty'); if(e)e.remove(); }
function rmRow(id){ $('#'+id).remove(); }

function buildSelectOptions(arr, label){
    var h = '<option value="">Select '+label+'</option>';
    arr.forEach(function(x){ h += '<option value="'+x.id+'"'+(x.extra||'')+'>'+x.name+'</option>'; });
    return h;
}

// ══════════════════════════════════════════════════════════
// MACHINES
// ══════════════════════════════════════════════════════════
var mCnt = 0;
function addMachineRow(){
    mCnt++;
    clearEmpty('machineBody');
    var mOpts = '<option value="">Select Machine</option>';
    machinesData.forEach(function(m){ mOpts += '<option value="'+m.id+'" data-model="'+(m.model||'')+'">'+m.name+'</option>'; });
    var lOpts = '<option value="">Select Labour</option>';
    operatorsData.forEach(function(o){ lOpts += '<option value="'+o.id+'" data-rate="'+(o.rate||0)+'">'+o.name+'</option>'; });
    var r = mCnt;
    $('#machineBody').append(
        '<tr id="mr_'+r+'">'
        +'<td class="text-center font-weight-bold">'+r+'</td>'
        +'<td style="min-width:220px;">'
        +'  <div class="d-flex align-items-center" style="gap:4px;">'
        +'    <div style="flex:1;min-width:0;"><select name="machines['+r+'][machine_id]" class="form-control form-control-sm" style="width:100%">'+mOpts+'</select></div>'
        +'    <button type="button" class="btn btn-success btn-quickadd flex-shrink-0" onclick="$(\'#modalAddMachine\').modal(\'show\')" title="Add Machine"><i class="fas fa-plus"></i></button>'
        +'  </div>'
        +'</td>'
        +'<td><input type="text" name="machines['+r+'][model]" class="form-control form-control-sm" placeholder="Model" style="min-width:90px;"></td>'
        +'<td><select name="machines['+r+'][labor_mode]" class="form-control form-control-sm" style="min-width:110px;"><option>Attended</option><option>Unattended</option><option>Semi-Attended</option></select></td>'
        +'<td style="min-width:220px;">'
        +'  <div class="d-flex align-items-center" style="gap:4px;">'
        +'    <div style="flex:1;min-width:0;"><select name="machines['+r+'][labour_id]" class="form-control form-control-sm m-labour" onchange="updateMSub('+r+',true)" style="width:100%">'+lOpts+'</select></div>'
        +'    <button type="button" class="btn btn-info btn-quickadd flex-shrink-0" onclick="$(\'#modalAddLabour\').modal(\'show\')" title="Add Labour"><i class="fas fa-plus"></i></button>'
        +'  </div>'
        +'</td>'
        +'<td><select name="machines['+r+'][material]" class="form-control form-control-sm"><option>Steel</option><option>Aluminum</option><option>Stainless</option><option>Brass</option><option>Titanium</option></select></td>'
        +'<td><select name="machines['+r+'][complexity]" class="form-control form-control-sm"><option>Simple</option><option>Moderate</option><option>Complex</option><option>Very Complex</option></select></td>'
        +'<td><select name="machines['+r+'][priority]" class="form-control form-control-sm"><option>Normal</option><option>Rush</option><option>Urgent</option></select></td>'
        +'<td class="text-center"><input type="number" step="0.01" name="machines['+r+'][time]" class="form-control form-control-sm m-time text-center" value="0" onchange="updateMSub('+r+')"></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="machines['+r+'][rate]" id="mrate_'+r+'" class="form-control m-rate text-center" value="0.00" onchange="updateMSub('+r+')"></div></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text bg-success text-white">$</span></div>'
        +'<input type="number" step="0.01" name="machines['+r+'][sub_total]" id="mst_'+r+'" class="form-control bg-light m-sub font-weight-bold" value="0.00" readonly></div></td>'
        +'<td class="text-center"><button type="button" class="btn btn-sm btn-danger" onclick="rmRow(\'mr_'+r+'\');calcMachineTotal()"><i class="fas fa-trash"></i></button></td>'
        +'</tr>'
    );
    // Apply Select2 to new row selects
    s2('#mr_'+r+' select[name*="[machine_id]"]', 'Select machine...');
    s2('#mr_'+r+' select[name*="[labour_id]"]', 'Select labour...');
}
function updateMSub(r, fromLabour){
    var time = parseFloat($('#mr_'+r+' .m-time').val())||0;

    // If called from labour change, pre-fill rate from labour data-rate
    if(fromLabour){
        var labourRate = parseFloat($('[name="machines['+r+'][labour_id]"]').find(':selected').data('rate'))||0;
        if(labourRate > 0) $('#mrate_'+r).val(labourRate.toFixed(2));
    }

    // Always use the current value of the rate field (user may have overridden it)
    var rate = parseFloat($('#mrate_'+r).val())||0;
    $('#mst_'+r).val(((time/60)*rate).toFixed(2));
    calcMachineTotal();
}
function calcMachineTotal(){
    var t=0; $('.m-sub').each(function(){t+=parseFloat($(this).val())||0;});
    $('#machineTotal').text(t.toFixed(2));
    $('#machineTotalFoot').text(t.toFixed(2));
    $('#stab_machine').text('$'+t.toFixed(2));
    recalcAll();
}

// ══════════════════════════════════════════════════════════
// OPERATIONS
// ══════════════════════════════════════════════════════════
var opCnt = 0;
function addOperationRow(){
    opCnt++;
    clearEmpty('operationBody');
    var oOpts = '<option value="">Select Operation</option>';
    operationsData.forEach(function(o){ oOpts += '<option value="'+o.id+'" data-rate="'+o.rate+'">'+o.name+'</option>'; });
    var lOpts = '<option value="">Select Labour</option>';
    operatorsData.forEach(function(o){ lOpts += '<option value="'+o.id+'" data-rate="'+(o.rate||0)+'">'+o.name+'</option>'; });
    var r = opCnt;
    $('#operationBody').append(
        '<tr id="opr_'+r+'">'
        +'<td style="min-width:240px;"><div class="d-flex align-items-center" style="gap:4px;">'
        +'  <div style="flex:1;min-width:0;"><select name="operations['+r+'][operation_id]" class="form-control form-control-sm op-sel" onchange="updateOpSub('+r+')" style="width:100%">'+oOpts+'</select></div>'
        +'  <button type="button" class="btn btn-success btn-quickadd flex-shrink-0" onclick="$(\'#modalAddOperation\').modal(\'show\')" title="Add Operation"><i class="fas fa-plus"></i></button>'
        +'</div></td>'
        +'<td style="min-width:240px;"><div class="d-flex align-items-center" style="gap:4px;">'
        +'  <div style="flex:1;min-width:0;"><select name="operations['+r+'][labour_id]" class="form-control form-control-sm op-lab" onchange="updateOpSub('+r+')" style="width:100%">'+lOpts+'</select></div>'
        +'  <button type="button" class="btn btn-info btn-quickadd flex-shrink-0" onclick="$(\'#modalAddLabour\').modal(\'show\')" title="Add Labour"><i class="fas fa-plus"></i></button>'
        +'</div></td>'
        +'<td><input type="number" step="0.01" name="operations['+r+'][time]" class="form-control form-control-sm op-time" value="0" onchange="updateOpSub('+r+')"></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="operations['+r+'][rate]" id="oprate_'+r+'" class="form-control bg-light" value="0" readonly></div></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="operations['+r+'][sub_total]" id="opst_'+r+'" class="form-control bg-light op-sub" value="0.00" readonly></div></td>'
        +'<td><button type="button" class="btn btn-sm btn-danger" onclick="rmRow(\'opr_'+r+'\');calcOpTotal()"><i class="fas fa-trash"></i></button></td>'
        +'</tr>'
    );
    s2('#opr_'+r+' select[name*="[operation_id]"]', 'Select operation...');
    s2('#opr_'+r+' select[name*="[labour_id]"]', 'Select labour...');
}
function updateOpSub(r){
    var time  = parseFloat($('#opr_'+r+' .op-time').val())||0;
    var lRate = parseFloat($('#opr_'+r+' .op-lab').find(':selected').data('rate'))||0;
    var oRate = parseFloat($('#opr_'+r+' .op-sel').find(':selected').data('rate'))||0;
    var rate  = lRate || oRate;
    $('#oprate_'+r).val(rate.toFixed(2));
    $('#opst_'+r).val(((time/60)*rate).toFixed(2));
    calcOpTotal();
}
function calcOpTotal(){
    var t=0; $('.op-sub').each(function(){t+=parseFloat($(this).val())||0;});
    $('#operationTotal').text(t.toFixed(2));
    $('#operationTotalFoot').text(t.toFixed(2));
    $('#stab_ops').text('$'+t.toFixed(2));
    recalcAll();
}

// ══════════════════════════════════════════════════════════
// ITEMS
// ══════════════════════════════════════════════════════════
var itCnt = 0;
function addItemRow(){
    itCnt++;
    clearEmpty('itemsBody');
    var iOpts = '<option value="">Select Item</option>';
    itemsData.forEach(function(i){ iOpts += '<option value="'+i.id+'" data-rate="'+(i.sell_price||0)+'" data-desc="'+(i.description||'').replace(/"/g,"'")+'">'+i.name+'</option>'; });
    var r = itCnt;
    $('#itemsBody').append(
        '<tr id="itr_'+r+'">'
        +'<td style="min-width:260px;"><div class="d-flex align-items-center" style="gap:4px;">'
        +'  <div style="flex:1;min-width:0;"><select name="items['+r+'][item_id]" class="form-control form-control-sm it-sel" onchange="itemChanged(this,'+r+')" style="width:100%">'+iOpts+'</select></div>'
        +'  <button type="button" class="btn btn-primary btn-quickadd flex-shrink-0" onclick="$(\'#modalAddItem\').modal(\'show\')" title="Add Item"><i class="fas fa-plus"></i></button>'
        +'</div></td>'
        +'<td><input type="text" name="items['+r+'][description]" id="itdesc_'+r+'" class="form-control form-control-sm"></td>'
        +'<td><input type="number" name="items['+r+'][qty]" class="form-control form-control-sm it-qty" value="1" onchange="updateItSub('+r+')"></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="items['+r+'][rate]" class="form-control it-rate" value="0.00" onchange="updateItSub('+r+')"></div></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="items['+r+'][sub_total]" id="itst_'+r+'" class="form-control bg-light it-sub" value="0.00" readonly></div></td>'
        +'<td><button type="button" class="btn btn-sm btn-danger" onclick="rmRow(\'itr_'+r+'\');calcItemTotal()"><i class="fas fa-trash"></i></button></td>'
        +'</tr>'
    );
    s2('#itr_'+r+' select[name*="[item_id]"]', 'Search item...');
}
function itemChanged(sel,r){
    var opt=$(sel).find(':selected');
    $('#itr_'+r+' .it-rate').val(f2(opt.data('rate')||0));
    $('#itdesc_'+r).val(opt.data('desc')||'');
    updateItSub(r);
}
function updateItSub(r){
    var qty=parseFloat($('#itr_'+r+' .it-qty').val())||0;
    var rate=parseFloat($('#itr_'+r+' .it-rate').val())||0;
    $('#itst_'+r).val((qty*rate).toFixed(2));
    calcItemTotal();
}
function calcItemTotal(){
    var t=0; $('.it-sub').each(function(){t+=parseFloat($(this).val())||0;});
    $('#itemsTotal').text(t.toFixed(2));
    $('#itemsTotalFoot').text(t.toFixed(2));
    $('#stab_items').text('$'+t.toFixed(2));
    recalcAll();
}

// ══════════════════════════════════════════════════════════
// HOLES — Exact design from your screenshot (2-row card)
// ══════════════════════════════════════════════════════════
var hCnt = 0;
function addHoleRow(){
    hCnt++;
    clearEmptyDiv('holes');
    var r = hCnt;
    // Build chamfer options
    var chOpts = '<option value="" data-price="0">No Chamfer</option>';
    chamfersData.forEach(function(c){ chOpts += '<option value="'+c.id+'" data-price="'+c.unit_price+'">'+c.name+'</option>'; });
    // Build debur options
    var dbOpts = '<option value="" data-price="0">No Debur</option>';
    debursData.forEach(function(d){ dbOpts += '<option value="'+d.id+'" data-price="'+d.unit_price+'">'+d.name+'</option>'; });

    var html = '<div class="row-card" id="hr_'+r+'">'
        // ── Row 1 ──
        +'<div class="row-card-header">'
        +'  <span class="font-weight-bold">H'+r+'</span>'
        +'  <button type="button" class="btn btn-sm btn-danger" onclick="rmHole('+r+')"><i class="fas fa-trash"></i></button>'
        +'</div>'
        +'<div class="row-card-body">'
        +'  <div class="row align-items-end">'

        +'    <div class="col-auto" style="min-width:90px"><div class="field-label">ID</div>'
        +'      <input type="text" class="form-control form-control-sm" value="H'+r+'" readonly style="font-weight:700;background:#f8f9fa;">'
        +'    </div>'

        +'    <div class="col-auto" style="min-width:100px"><div class="field-label">Quantity</div>'
        +'      <input type="number" name="holes['+r+'][qty]" class="form-control form-control-sm h-qty" value="1" onchange="calcHoleSub('+r+')">'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Drilling Method</div>'
        +'      <div class="input-group input-group-sm" style="min-width:180px">'
        +'        <select name="holes['+r+'][drilling_method]" class="form-control">'
        +'          <option value="">Select Method</option>'
        +'          <option>Drill</option><option>Ream</option><option>Bore</option>'
        +'          <option>Counter Bore</option><option>Counter Sink</option>'
        +'        </select>'
        +'        <div class="input-group-append"><button type="button" class="btn btn-success btn-quickadd" title="Not used here"><i class="fas fa-plus"></i></button></div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Hole Size</div>'
        +'      <div class="input-group input-group-sm" style="min-width:160px">'
        +'        <input type="number" step="0.001" name="holes['+r+'][hole_size]" class="form-control" placeholder="2.505">'
        +'        <div class="input-group-append">'
        +'          <button type="button" class="btn btn-primary" onclick="setHoleUnit('+r+',\'mm\')">mm</button>'
        +'          <button type="button" class="btn btn-secondary" onclick="setHoleUnit('+r+',\'inch\')">inch</button>'
        +'        </div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Tolerance (+)</div>'
        +'      <div class="input-group input-group-sm" style="min-width:140px">'
        +'        <div class="input-group-prepend"><span class="input-group-text btn-success text-white" style="cursor:pointer;background:#28a745;">+</span></div>'
        +'        <input type="number" step="0.001" name="holes['+r+'][tol_plus]" class="form-control" value="0.005">'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Tolerance (-)</div>'
        +'      <div class="input-group input-group-sm" style="min-width:140px">'
        +'        <div class="input-group-prepend"><span class="input-group-text" style="background:#dc3545;color:#fff;">-</span></div>'
        +'        <input type="number" step="0.001" name="holes['+r+'][tol_minus]" class="form-control" value="0.005">'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Depth Type</div>'
        +'      <select name="holes['+r+'][depth_type]" class="form-control form-control-sm" style="min-width:110px" onchange="toggleHoleDepth('+r+')">'
        +'        <option value="through">Through</option><option value="other">Other</option>'
        +'      </select>'
        +'      <div id="hdepth_'+r+'" style="display:none;margin-top:4px;">'
        +'        <input type="number" step="0.01" name="holes['+r+'][depth_size]" class="form-control form-control-sm" placeholder="Depth">'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Hole Price</div>'
        +'      <div class="input-group input-group-sm" style="min-width:120px">'
        +'        <div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'        <input type="number" step="0.01" name="holes['+r+'][hole_price]" class="form-control h-hp" value="0.00" onchange="calcHoleSub('+r+')">'
        +'      </div>'
        +'    </div>'

        +'  </div>'

        // ── Row 2 ──
        +'  <div class="row align-items-end mt-2">'

        +'    <div class="col-auto"><div class="field-label">Chamfer</div>'
        +'      <div class="input-group input-group-sm" style="min-width:180px">'
        +'        <select name="holes['+r+'][chamfer]" class="form-control" onchange="updateHoleChamfer('+r+')">'+chOpts+'</select>'
        +'        <div class="input-group-append"><button type="button" class="btn btn-warning btn-quickadd" onclick="$(\'#modalAddChamfer\').modal(\'show\')" title="Add Chamfer"><i class="fas fa-plus"></i></button></div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Chamfer Size</div>'
        +'      <div class="input-group input-group-sm" style="min-width:150px">'
        +'        <input type="number" step="0.001" name="holes['+r+'][chamfer_size]" id="hcsize_'+r+'" class="form-control" placeholder="Size">'
        +'        <div class="input-group-append">'
        +'          <button type="button" class="btn btn-primary">mm</button>'
        +'          <button type="button" class="btn btn-secondary">inch</button>'
        +'        </div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Chamfer Price</div>'
        +'      <div class="input-group input-group-sm" style="min-width:120px">'
        +'        <div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'        <input type="number" step="0.01" name="holes['+r+'][chamfer_price]" id="hcp_'+r+'" class="form-control bg-light" value="0.00" readonly>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Debur</div>'
        +'      <div class="input-group input-group-sm" style="min-width:180px">'
        +'        <select name="holes['+r+'][debur]" class="form-control" onchange="updateHoleDebur('+r+')">'+dbOpts+'</select>'
        +'        <div class="input-group-append"><button type="button" class="btn btn-info btn-quickadd" onclick="$(\'#modalAddDebur\').modal(\'show\')" title="Add Debur"><i class="fas fa-plus"></i></button></div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Debur Size</div>'
        +'      <div class="input-group input-group-sm" style="min-width:150px">'
        +'        <input type="number" step="0.001" name="holes['+r+'][debur_size]" class="form-control" placeholder="Size">'
        +'        <div class="input-group-append">'
        +'          <button type="button" class="btn btn-primary">mm</button>'
        +'          <button type="button" class="btn btn-secondary">inch</button>'
        +'        </div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Debur Price</div>'
        +'      <div class="input-group input-group-sm" style="min-width:120px">'
        +'        <div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'        <input type="number" step="0.01" name="holes['+r+'][debur_price]" id="hdp_'+r+'" class="form-control bg-light" value="0.00" readonly>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label"><strong>Total</strong></div>'
        +'      <input type="number" step="0.01" name="holes['+r+'][sub_total]" id="hst_'+r+'" class="form-control form-control-sm bg-white font-weight-bold h-sub" style="min-width:100px;" value="0.00" readonly>'
        +'    </div>'

        +'  </div>'
        +'</div>'
        +'</div>';

    document.getElementById('holesBody').insertAdjacentHTML('beforeend', html);
}
function setHoleUnit(r, unit){ /* stored locally per row - visual only */ }
function toggleHoleDepth(r){ $('#hdepth_'+r).toggle($('select[name="holes['+r+'][depth_type]"]').val()==='other'); }
function updateHoleChamfer(r){ var p=parseFloat($('select[name="holes['+r+'][chamfer]"]').find(':selected').data('price'))||0; $('#hcp_'+r).val(p.toFixed(2)); calcHoleSub(r); }
function updateHoleDebur(r){ var p=parseFloat($('select[name="holes['+r+'][debur]"]').find(':selected').data('price'))||0; $('#hdp_'+r).val(p.toFixed(2)); calcHoleSub(r); }
function calcHoleSub(r){
    var hp  = parseFloat($('input[name="holes['+r+'][hole_price]"]').val())||0;
    var ch  = parseFloat($('#hcp_'+r).val())||0;
    var db  = parseFloat($('#hdp_'+r).val())||0;
    var qty = parseFloat($('input[name="holes['+r+'][qty]"]').val())||1;
    $('#hst_'+r).val(((hp+ch+db)*qty).toFixed(2));
    calcHoleTotal();
}
function calcHoleTotal(){
    var t=0; $('.h-sub').each(function(){t+=parseFloat($(this).val())||0;});
    $('#holesTotal').text(t.toFixed(2));
    $('#holesTotalFoot').text(t.toFixed(2));
    $('#stab_holes').text('$'+t.toFixed(2));
    $('#tb_holes').text(t.toFixed(2));
    recalcAll();
}
function rmHole(r){ $('#hr_'+r).remove(); calcHoleTotal(); }

// ══════════════════════════════════════════════════════════
// TAPS — Exact design from your screenshot (2-row card)
// ══════════════════════════════════════════════════════════
var tpCnt = 0;
function addTapRow(){
    tpCnt++;
    clearEmptyDiv('taps');
    var r = tpCnt;
    var tOpts = '<option value="">Select Tapped</option>';
    tapsData.forEach(function(t){ tOpts += '<option value="'+t.id+'" data-price="'+t.tap_price+'">'+t.name+'</option>'; });
    var chOpts = '<option value="" data-price="0">No Chamfer</option>';
    chamfersData.forEach(function(c){ chOpts += '<option value="'+c.id+'" data-price="'+c.unit_price+'">'+c.name+'</option>'; });
    var dbOpts = '<option value="" data-price="0">No Debur</option>';
    debursData.forEach(function(d){ dbOpts += '<option value="'+d.id+'" data-price="'+d.unit_price+'">'+d.name+'</option>'; });

    var html = '<div class="row-card" id="tr_'+r+'">'
        +'<div class="row-card-header">'
        +'  <span class="font-weight-bold text-danger">T'+r+'</span>'
        +'  <button type="button" class="btn btn-sm btn-danger" onclick="rmTap('+r+')"><i class="fas fa-trash"></i></button>'
        +'</div>'
        +'<div class="row-card-body">'

        // Row 1
        +'  <div class="row align-items-end">'

        +'    <div class="col-auto" style="min-width:90px"><div class="field-label">ID</div>'
        +'      <input type="text" class="form-control form-control-sm" value="T'+r+'" readonly style="font-weight:700;background:#f8f9fa;">'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Select Tapped</div>'
        +'      <div class="input-group input-group-sm" style="min-width:200px">'
        +'        <select name="taps['+r+'][tap_id]" class="form-control" onchange="tapChanged(this,'+r+')">'+tOpts+'</select>'
        +'        <div class="input-group-append"><button type="button" class="btn btn-danger btn-quickadd" onclick="$(\'#modalAddTap\').modal(\'show\')" title="Add Tap"><i class="fas fa-plus"></i></button></div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Tap Price</div>'
        +'      <div class="input-group input-group-sm" style="min-width:120px">'
        +'        <div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'        <input type="number" step="0.01" name="taps['+r+'][tap_price]" id="tpp_'+r+'" class="form-control bg-light" value="0.00" readonly>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Thread Option</div>'
        +'      <select name="taps['+r+'][thread_option]" class="form-control form-control-sm" style="min-width:130px" onchange="calcTapSub('+r+')">'
        +'        <option value="">Select</option>'
        +'        <option value="internal" data-price="2.50">Internal</option>'
        +'        <option value="external" data-price="3.00">External</option>'
        +'      </select>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Thread Price</div>'
        +'      <div class="input-group input-group-sm" style="min-width:120px">'
        +'        <div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'        <input type="number" step="0.01" name="taps['+r+'][option_price]" id="toprice_'+r+'" class="form-control bg-light" value="0.00" readonly>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Direction</div>'
        +'      <select name="taps['+r+'][direction]" class="form-control form-control-sm" style="min-width:100px">'
        +'        <option value="right">Right</option><option value="left">Left</option>'
        +'      </select>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Thread Size</div>'
        +'      <div class="input-group input-group-sm" style="min-width:160px">'
        +'        <input type="text" name="taps['+r+'][thread_size]" class="form-control" value="M6×1.0">'
        +'        <div class="input-group-append">'
        +'          <button type="button" class="btn btn-primary">mm</button>'
        +'          <button type="button" class="btn btn-secondary">inch</button>'
        +'        </div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Base Price</div>'
        +'      <div class="input-group input-group-sm" style="min-width:120px">'
        +'        <div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'        <input type="number" step="0.01" name="taps['+r+'][base_price]" class="form-control tp-base" value="0.00" onchange="calcTapSub('+r+')">'
        +'      </div>'
        +'    </div>'

        +'  </div>'

        // Row 2
        +'  <div class="row align-items-end mt-2">'

        +'    <div class="col-auto"><div class="field-label">Chamfer</div>'
        +'      <div class="input-group input-group-sm" style="min-width:180px">'
        +'        <select name="taps['+r+'][chamfer]" class="form-control" onchange="updateTapChamfer('+r+')">'+chOpts+'</select>'
        +'        <div class="input-group-append"><button type="button" class="btn btn-warning btn-quickadd" onclick="$(\'#modalAddChamfer\').modal(\'show\')" title="Add Chamfer"><i class="fas fa-plus"></i></button></div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Chamfer Size</div>'
        +'      <div class="input-group input-group-sm" style="min-width:150px">'
        +'        <input type="number" step="0.001" name="taps['+r+'][chamfer_size]" class="form-control" placeholder="Size">'
        +'        <div class="input-group-append">'
        +'          <button type="button" class="btn btn-primary">mm</button>'
        +'          <button type="button" class="btn btn-secondary">inch</button>'
        +'        </div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Chamfer Price</div>'
        +'      <div class="input-group input-group-sm" style="min-width:120px">'
        +'        <div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'        <input type="number" step="0.01" name="taps['+r+'][chamfer_price]" id="tcpr_'+r+'" class="form-control bg-light" value="0.00" readonly>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Debur</div>'
        +'      <div class="input-group input-group-sm" style="min-width:180px">'
        +'        <select name="taps['+r+'][debur]" class="form-control" onchange="updateTapDebur('+r+')">'+dbOpts+'</select>'
        +'        <div class="input-group-append"><button type="button" class="btn btn-info btn-quickadd" onclick="$(\'#modalAddDebur\').modal(\'show\')" title="Add Debur"><i class="fas fa-plus"></i></button></div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Debur Size</div>'
        +'      <div class="input-group input-group-sm" style="min-width:150px">'
        +'        <input type="number" step="0.001" name="taps['+r+'][debur_size]" class="form-control" placeholder="Size">'
        +'        <div class="input-group-append">'
        +'          <button type="button" class="btn btn-primary">mm</button>'
        +'          <button type="button" class="btn btn-secondary">inch</button>'
        +'        </div>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label">Debur Price</div>'
        +'      <div class="input-group input-group-sm" style="min-width:120px">'
        +'        <div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'        <input type="number" step="0.01" name="taps['+r+'][debur_price]" id="tdpr_'+r+'" class="form-control bg-light" value="0.00" readonly>'
        +'      </div>'
        +'    </div>'

        +'    <div class="col-auto"><div class="field-label"><strong>Total</strong></div>'
        +'      <input type="number" step="0.01" name="taps['+r+'][sub_total]" id="tst_'+r+'" class="form-control form-control-sm bg-white font-weight-bold tp-sub" style="min-width:100px;" value="0.00" readonly>'
        +'    </div>'

        +'  </div>'
        +'</div>'
        +'</div>';

    document.getElementById('tapsBody').insertAdjacentHTML('beforeend', html);
}
function tapChanged(sel,r){ var p=parseFloat($(sel).find(':selected').data('price'))||0; $('#tpp_'+r).val(p.toFixed(2)); calcTapSub(r); }
function updateTapChamfer(r){ var p=parseFloat($('select[name="taps['+r+'][chamfer]"]').find(':selected').data('price'))||0; $('#tcpr_'+r).val(p.toFixed(2)); calcTapSub(r); }
function updateTapDebur(r){ var p=parseFloat($('select[name="taps['+r+'][debur]"]').find(':selected').data('price'))||0; $('#tdpr_'+r).val(p.toFixed(2)); calcTapSub(r); }
function calcTapSub(r){
    var tap  = parseFloat($('#tpp_'+r).val())||0;
    var opt  = parseFloat($('select[name="taps['+r+'][thread_option]"]').find(':selected').data('price'))||0;
    var base = parseFloat($('#tr_'+r+' .tp-base').val())||0;
    var ch   = parseFloat($('#tcpr_'+r).val())||0;
    var db   = parseFloat($('#tdpr_'+r).val())||0;
    $('#toprice_'+r).val(opt.toFixed(2));
    $('#tst_'+r).val((tap+opt+base+ch+db).toFixed(2));
    calcTapTotal();
}
function calcTapTotal(){
    var t=0; $('.tp-sub').each(function(){t+=parseFloat($(this).val())||0;});
    $('#tapsTotal').text(t.toFixed(2));
    $('#tapsTotalFoot').text(t.toFixed(2));
    $('#stab_taps').text('$'+t.toFixed(2));
    recalcAll();
}
function rmTap(r){ $('#tr_'+r).remove(); calcTapTotal(); }

// ══════════════════════════════════════════════════════════
// THREADS — 2-row card style matching screenshot
// ══════════════════════════════════════════════════════════
var thCnt = 0;

function addThreadRow(){
    thCnt++;
    var r = thCnt;

    $('#threadsEmpty').hide();

    // Build thread select options
    var thrOpts = '<option value="">Select Thread</option>';
    threadsData.forEach(function(t){
        var sizes   = JSON.stringify(t.thread_sizes   || []);
        var options = JSON.stringify(t.thread_options || []);
        thrOpts += '<option value="' + t.id + '"'
            + ' data-thread-price="'  + t.thread_price  + '"'
            + ' data-pitch-price="'   + t.pitch_price   + '"'
            + ' data-class-price="'   + t.class_price   + '"'
            + ' data-size-price="'    + t.size_price    + '"'
            + ' data-option-price="'  + t.option_price  + '"'
            + ' data-direction="'     + t.direction     + '"'
            + " data-thread-sizes='"  + sizes.replace(/'/g,"\\'") + "'"
            + " data-thread-options='" + options.replace(/'/g,"\\'") + "'"
            + '>' + t.name + '</option>';
    });

    var stdOpts = ['National Coarse','National Fine','Metric','UNC','UNF','BSP','NPT']
        .map(function(s){ return '<option>' + s + '</option>'; }).join('');

    var clsOpts = ['1A','2A','3A','1B','2B','3B','6g','6H','6e']
        .map(function(s){ return '<option>' + s + '</option>'; }).join('');

    // Build row HTML — NO line-continuation backslashes, plain concatenation
    var h = '';
    h += '<div class="row-card" id="thr_' + r + '">';
    h +=   '<div class="row-card-header">';
    h +=     '<span class="font-weight-bold" style="color:#6f42c1;">TH' + r + '</span>';
    h +=     '<button type="button" class="btn btn-sm btn-danger" onclick="rmThread(' + r + ')"><i class="fas fa-trash"></i></button>';
    h +=   '</div>';
    h +=   '<div class="row-card-body">';

    // ── Row 1 ──
    h +=     '<div class="row align-items-end">';

    h +=       '<div class="col-auto" style="min-width:90px">';
    h +=         '<div class="field-label">ID</div>';
    h +=         '<input type="text" class="form-control form-control-sm" value="TH' + r + '" readonly style="font-weight:700;background:#f8f9fa;">';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Select Thread</div>';
    h +=         '<div class="input-group input-group-sm" style="min-width:200px">';
    h +=           '<select name="threads[' + r + '][thread_id]" class="form-control" id="thr_sel_' + r + '" onchange="threadChanged(this,' + r + ')">' + thrOpts + '</select>';
    h +=           '<div class="input-group-append"><button type="button" class="btn btn-quickadd" style="background:#6f42c1;color:#fff;" title="Add Thread"><i class="fas fa-plus"></i></button></div>';
    h +=         '</div>';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Threaded Price</div>';
    h +=         '<div class="input-group input-group-sm" style="min-width:120px">';
    h +=           '<div class="input-group-prepend"><span class="input-group-text">$</span></div>';
    h +=           '<input type="number" step="0.01" name="threads[' + r + '][thread_price]" id="thr_tp_' + r + '" class="form-control bg-light" value="0.00" readonly>';
    h +=         '</div>';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Option</div>';
    h +=         '<select name="threads[' + r + '][option]" id="thr_opt_' + r + '" class="form-control form-control-sm" style="min-width:150px" onchange="calcThSub(' + r + ')">';
    h +=           '<option value="">Select Option</option>';
    h +=         '</select>';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Thread Price</div>';
    h +=         '<div class="input-group input-group-sm" style="min-width:120px">';
    h +=           '<div class="input-group-prepend"><span class="input-group-text">$</span></div>';
    h +=           '<input type="number" step="0.01" name="threads[' + r + '][option_price]" id="thr_op_' + r + '" class="form-control bg-light" value="0.00" readonly>';
    h +=         '</div>';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Direction</div>';
    h +=         '<select name="threads[' + r + '][direction]" id="thr_dir_' + r + '" class="form-control form-control-sm" style="min-width:100px">';
    h +=           '<option value="right">Right</option><option value="left">Left</option>';
    h +=         '</select>';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Thread Size</div>';
    h +=         '<select name="threads[' + r + '][thread_size]" id="thr_sz_' + r + '" class="form-control form-control-sm" style="min-width:130px" onchange="calcThSub(' + r + ')">';
    h +=           '<option value="">--</option>';
    h +=         '</select>';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Size Price</div>';
    h +=         '<div class="input-group input-group-sm" style="min-width:110px">';
    h +=           '<div class="input-group-prepend"><span class="input-group-text">$</span></div>';
    h +=           '<input type="number" step="0.01" name="threads[' + r + '][size_price]" id="thr_szp_' + r + '" class="form-control bg-light" value="0.00" readonly>';
    h +=         '</div>';
    h +=       '</div>';

    h +=     '</div>'; // end row 1

    // ── Row 2 ──
    h +=     '<div class="row align-items-end mt-2">';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Standard</div>';
    h +=         '<select name="threads[' + r + '][standard]" id="thr_std_' + r + '" class="form-control form-control-sm" style="min-width:150px">' + stdOpts + '</select>';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Pitch</div>';
    h +=         '<select name="threads[' + r + '][pitch]" id="thr_pitch_' + r + '" class="form-control form-control-sm" style="min-width:100px" onchange="calcThSub(' + r + ')">';
    h +=           '<option value="4">4</option><option value="8">8</option><option value="12">12</option>';
    h +=           '<option value="16">16</option><option value="20">20</option><option value="32">32</option>';
    h +=         '</select>';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Pitch Price</div>';
    h +=         '<div class="input-group input-group-sm" style="min-width:120px">';
    h +=           '<div class="input-group-prepend"><span class="input-group-text">$</span></div>';
    h +=           '<input type="number" step="0.01" name="threads[' + r + '][pitch_price]" id="thr_pp_' + r + '" class="form-control bg-light" value="0.00" readonly>';
    h +=         '</div>';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Class</div>';
    h +=         '<select name="threads[' + r + '][class]" id="thr_cls_' + r + '" class="form-control form-control-sm" style="min-width:100px" onchange="calcThSub(' + r + ')">' + clsOpts + '</select>';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Class Price</div>';
    h +=         '<div class="input-group input-group-sm" style="min-width:120px">';
    h +=           '<div class="input-group-prepend"><span class="input-group-text">$</span></div>';
    h +=           '<input type="number" step="0.01" name="threads[' + r + '][class_price]" id="thr_cp_' + r + '" class="form-control bg-light" value="0.00" readonly>';
    h +=         '</div>';
    h +=       '</div>';

    h +=       '<div class="col-auto">';
    h +=         '<div class="field-label">Total</div>';
    h +=         '<div class="input-group input-group-sm" style="min-width:130px">';
    h +=           '<div class="input-group-prepend"><span class="input-group-text bg-success text-white">$</span></div>';
    h +=           '<input type="number" step="0.01" name="threads[' + r + '][sub_total]" id="thr_sub_' + r + '" class="form-control bg-light font-weight-bold th-sub" value="0.00" readonly>';
    h +=         '</div>';
    h +=       '</div>';

    h +=     '</div>'; // end row 2
    h +=   '</div>'; // row-card-body
    h += '</div>'; // row-card

    $('#threadsBody').append(h);
}

function threadChanged(sel, r){
    var opt = $(sel).find(':selected');

    $('#thr_tp_'+r).val(parseFloat(opt.data('thread-price') || 0).toFixed(2));
    $('#thr_pp_'+r).val(parseFloat(opt.data('pitch-price')  || 0).toFixed(2));
    $('#thr_cp_'+r).val(parseFloat(opt.data('class-price')  || 0).toFixed(2));
    $('#thr_szp_'+r).val(parseFloat(opt.data('size-price')  || 0).toFixed(2));

    var dir = opt.data('direction') || 'right';
    $('#thr_dir_'+r).val(dir);

    // Populate Options dropdown
    var opts = opt.data('thread-options') || [];
    if(typeof opts === 'string'){ try{ opts = JSON.parse(opts); }catch(e){ opts=[]; } }
    var $optSel = $('#thr_opt_'+r);
    $optSel.empty().append('<option value="">Select Option</option>');
    (Array.isArray(opts) ? opts : []).forEach(function(o){
        $optSel.append('<option value="' + o + '">' + o + '</option>');
    });

    // Populate Sizes dropdown
    var sizes = opt.data('thread-sizes') || [];
    if(typeof sizes === 'string'){ try{ sizes = JSON.parse(sizes); }catch(e){ sizes=[]; } }
    var $szSel = $('#thr_sz_'+r);
    $szSel.empty();
    (Array.isArray(sizes) ? sizes : []).forEach(function(s){
        $szSel.append('<option value="' + s + '">' + s + '</option>');
    });
    if(!sizes.length) $szSel.append('<option value="">--</option>');

    calcThSub(r);
}

function calcThSub(r){
    var tp  = parseFloat($('#thr_tp_'+r).val())  || 0;
    var op  = parseFloat($('#thr_op_'+r).val())  || 0;
    var pp  = parseFloat($('#thr_pp_'+r).val())  || 0;
    var cp  = parseFloat($('#thr_cp_'+r).val())  || 0;
    var szp = parseFloat($('#thr_szp_'+r).val()) || 0;
    $('#thr_sub_'+r).val((tp + op + pp + cp + szp).toFixed(2));
    calcThTotal();
}

function rmThread(r){
    $('#thr_'+r).remove();
    calcThTotal();
    if($('#threadsBody .row-card').length === 0) $('#threadsEmpty').show();
}

function calcThTotal(){
    var t = 0;
    $('.th-sub').each(function(){ t += parseFloat($(this).val()) || 0; });
    $('#threadsTotal').text(t.toFixed(2));
    $('#threadsTotalFoot').text(t.toFixed(2));
    $('#stab_threads').text('$' + t.toFixed(2));
    recalcAll();
}

// SECONDARY OPS
// ══════════════════════════════════════════════════════════
var scCnt = 0;
function addSecondaryRow(){
    scCnt++;
    clearEmpty('secondaryBody');
    var vOpts = '<option value="">No Vendor</option>';
    vendorsData.forEach(function(v){ vOpts += '<option value="'+v.id+'">'+v.name+'</option>'; });
    var r = scCnt;
    $('#secondaryBody').append(
        '<tr id="scr_'+r+'">'
        +'<td><input type="text" name="secondary['+r+'][name]" class="form-control form-control-sm" placeholder="e.g. Grinding"></td>'
        +'<td style="min-width:220px;"><div class="d-flex align-items-center" style="gap:4px;">'
        +'  <div style="flex:1;min-width:0;"><select name="secondary['+r+'][vendor_id]" class="form-control form-control-sm" style="width:100%">'+vOpts+'</select></div>'
        +'  <button type="button" class="btn btn-warning btn-quickadd flex-shrink-0" onclick="openVendorModal(\'secondary\')" title="Add Vendor"><i class="fas fa-plus"></i></button>'
        +'</div></td>'
        +'<td><select name="secondary['+r+'][price_type]" class="form-control form-control-sm sc-type" onchange="updateScSub('+r+')">'
        +'  <option value="lot">Lot</option><option value="per_piece">Per Piece</option><option value="per_pound">Per Pound</option>'
        +'</select></td>'
        +'<td><input type="number" name="secondary['+r+'][qty]" class="form-control form-control-sm sc-qty" value="1" onchange="updateScSub('+r+')"></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="secondary['+r+'][unit_price]" class="form-control sc-unit" value="0" onchange="updateScSub('+r+')"></div></td>'
        +'<td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">$</span></div>'
        +'<input type="number" step="0.01" name="secondary['+r+'][sub_total]" id="scst_'+r+'" class="form-control bg-light sc-sub font-weight-bold" value="0.00" readonly></div></td>'
        +'<td><button type="button" class="btn btn-sm btn-danger" onclick="rmRow(\'scr_'+r+'\');calcSecTotal()"><i class="fas fa-trash"></i></button></td>'
        +'</tr>'
    );
    s2('#scr_'+r+' select[name*="[vendor_id]"]', '🔍 Search vendor...');
}
function updateScSub(r){
    var type = $('select[name="secondary['+r+'][price_type]"]').val();
    var qty  = parseFloat($('input[name="secondary['+r+'][qty]"]').val())||1;
    var unit = parseFloat($('input[name="secondary['+r+'][unit_price]"]').val())||0;
    $('#scst_'+r).val((type==='lot' ? unit : qty*unit).toFixed(2));
    calcSecTotal();
}
function calcSecTotal(){
    var t=0; $('.sc-sub').each(function(){t+=parseFloat($(this).val())||0;});
    $('#secondaryTotal').text(t.toFixed(2));
    $('#stab_secondary').text('$'+t.toFixed(2));
    recalcAll();
}

// ══════════════════════════════════════════════════════════
// PLATING & HEAT
// ══════════════════════════════════════════════════════════
function togglePlatingFields(){
    var pp = $('#platingPricingType').val()==='per_pound';
    $('#plEachCnt,#plEachPrc').toggleClass('d-none', pp);
    $('#plLbs,#plLot,#plPpl').toggleClass('d-none', !pp);
    calcPlatingTotal();
}
function toggleHeatFields(){
    var pp = $('#heatPricingType').val()==='per_pound';
    $('#htEachCnt,#htEachPrc').toggleClass('d-none', pp);
    $('#htLbs,#htLot,#htPpl').toggleClass('d-none', !pp);
    calcHeatTotal();
}
function calcPlatingTotal(){
    var type = $('#platingPricingType').val();
    var base = 0;
    if(type==='per_each'){
        base = (parseFloat($('input[name="plating_count"]').val())||0) * (parseFloat($('input[name="plating_price_each"]').val())||0);
    } else {
        var lbs=parseFloat($('input[name="plating_total_pounds"]').val())||0;
        var lot=parseFloat($('input[name="plating_lot_charge"]').val())||0;
        var ppl=parseFloat($('input[name="plating_per_pound"]').val())||0;
        base = lbs<=100 ? lot : lot+(lbs-100)*ppl;
    }
    var t = base + (parseFloat($('input[name="plating_salt_testing"]').val())||0)
                 + (parseFloat($('input[name="plating_surcharge"]').val())||0)
                 + (parseFloat($('input[name="plating_standards_price"]').val())||0);
    $('#platingTotal').val(t.toFixed(2));
    updatePlatingHeatBadge();
    recalcAll();
}
function calcHeatTotal(){
    var type = $('#heatPricingType').val();
    var base = 0;
    if(type==='per_each'){
        base = (parseFloat($('input[name="heat_count"]').val())||0) * (parseFloat($('input[name="heat_price_each"]').val())||0);
    } else {
        var lbs=parseFloat($('input[name="heat_total_pounds"]').val())||0;
        var lot=parseFloat($('input[name="heat_lot_charge"]').val())||0;
        var ppl=parseFloat($('input[name="heat_per_pound"]').val())||0;
        base = lbs<=100 ? lot : lot+(lbs-100)*ppl;
    }
    var t = base + (parseFloat($('input[name="heat_testing"]').val())||0)
                 + (parseFloat($('input[name="heat_surcharge"]').val())||0);
    $('#heatTotal').val(t.toFixed(2));
    updatePlatingHeatBadge();
    recalcAll();
}
function updatePlatingHeatBadge(){
    var t = (parseFloat($('#platingTotal').val())||0) + (parseFloat($('#heatTotal').val())||0);
    $('#platingHeatTotal').text(t.toFixed(2));
    $('#stab_plating').text('$'+t.toFixed(2));
}

// ══════════════════════════════════════════════════════════
// GRAND TOTAL
// ══════════════════════════════════════════════════════════
function recalcAll(){
    var qty = parseInt($('#globalQty').val()) || 1;

    // ── Section sub-totals (sum of all row sub-totals in each section) ──
    var mat  = parseFloat($('#totalPinPrice').val())    || 0;
    var mach = parseFloat($('#machineTotal').text())    || 0;
    var ops  = parseFloat($('#operationTotal').text())  || 0;
    var itms = parseFloat($('#itemsTotal').text())      || 0;
    var holes= parseFloat($('#holesTotal').text())      || 0;
    var taps = parseFloat($('#tapsTotal').text())       || 0;
    var thrs = parseFloat($('#threadsTotal').text())    || 0;
    var sec  = parseFloat($('#secondaryTotal').text())  || 0;
    // Plating and Heat Treatment are standalone (not ×qty)
    var plat = parseFloat($('#platingTotal').val())     || 0;
    var heat = parseFloat($('#heatTotal').val())        || 0;
    var brk  = parseFloat($('#breakInCharge').val())    || 0;

    // ── Update Qty display everywhere ──
    $('#sum_qty_display').text('×' + qty);
    $('.qty-ref').text(qty);

    // ── Sections that multiply by Qty ──
    // Sections that multiply by qty
    // each = section sub total (for 1 piece)
    // total = each × qty
    var sections = {
        material:  mat,
        machine:   mach,
        ops:       ops,
        items:     itms,
        holes:     holes,
        taps:      taps,
        threads:   thrs,
        secondary: sec,
    };

    var sumEach  = 0;  // total each (1 piece cost)
    var sumTotal = 0;  // total × qty

    for (var k in sections) {
        var each  = sections[k];          // sub total = cost for 1 piece
        var total = each * qty;           // × qty
        sumEach  += each;
        sumTotal += total;
        $('#sum_' + k + '_each').text(each.toFixed(2));
        $('#sum_' + k + '_total').text(total.toFixed(2));
    }

    // Plating — not × qty, shown as fixed cost
    $('#sum_plating_each').text(plat.toFixed(2));
    $('#sum_plating_total').text(plat.toFixed(2));

    // Heat Treatment — not × qty, shown as fixed cost
    $('#sum_heat_each').text(heat.toFixed(2));
    $('#sum_heat_total').text(heat.toFixed(2));

    // Sub Total row
    $('#sum_subtotal_each').text(sumEach.toFixed(2));
    $('#sum_subtotal_total').text(sumTotal.toFixed(2));

    // Grand Total = (sections × qty) + plating + heat + break-in
    var grandTotal = sumTotal + plat + heat + brk;
    var override   = parseFloat($('#overridePrice').val()) || 0;
    var gTotal     = override > 0 ? (override * qty) : grandTotal;
    var gEach      = gTotal / qty;

    // Update Qty badges everywhere
    $('.qty-badge').text(qty);

    $('#sum_grand_each').text(gEach.toFixed(2));
    $('#sum_grand_total').text(gTotal.toFixed(2));
    $('#grandEachPrice').val(gEach.toFixed(2));
    $('#grandTotalPrice').val(gTotal.toFixed(2));

    // Update sticky top totals bar
    $('#tb_material').text(mat.toFixed(2));
    $('#tb_machine').text(mach.toFixed(2));
    $('#tb_ops').text(ops.toFixed(2));
    $('#tb_items').text(itms.toFixed(2));
    $('#tb_taps').text(taps.toFixed(2));
    $('#tb_threads').text(thrs.toFixed(2));
    $('#tb_secondary').text(sec.toFixed(2));
    $('#tb_plating').text((plat + heat).toFixed(2));
    $('#tb_grand').text(gTotal.toFixed(2));
}

// ══════════════════════════════════════════════════════════
// AJAX QUICK-ADDS
// ══════════════════════════════════════════════════════════
function ajaxPost(url, data, onSuccess){
    fetch(url, {
        method: 'POST',
        headers: {'Content-Type':'application/json','X-CSRF-TOKEN':csrf,'Accept':'application/json'},
        body: JSON.stringify(data)
    })
    .then(function(r){ return r.json(); })
    .then(function(d){
        if(d.success || d.id){ onSuccess(d); }
        else { toastr.error(d.message || 'Error saving'); }
    })
    .catch(function(){ toastr.error('Network error'); });
}

function saveCustomerAjax(){
    ajaxPost('{{ route("company.customers.store") }}', {
        name: $('#mc_name').val(), customer_code: $('#mc_code').val(),
        customer_type: $('#mc_type').val(), email: $('#mc_email').val(),
        phone: $('#mc_phone').val(), payment_terms_days: $('#mc_terms').val(),
        status: 'active',
        // Minimal address required by controller
        addresses: [{address_type:'billing', address_line_1:'TBD', city:'TBD', country:'US'}]
    }, function(d){
        var c = d.customer || d;
        var opt = new Option(c.name + ' (' + c.customer_code + ')', c.id, true, true);
        if(typeof $.fn.select2 === 'function'){
            var newOpt = new Option(c.name + ' (' + c.customer_code + ')', c.id, true, true);
            $('#customerSelect').append(newOpt).trigger('change');
        } else {
            $('#customerSelect').append(opt).val(c.id).trigger('change');
        }
        $('#modalAddCustomer').modal('hide');
        toastr.success('Customer added!');
    });
}

function saveMachineAjax(){
    ajaxPost('{{ route("company.machines.store") }}', {
        name: $('#mm_name').val(), machine_code: $('#mm_code').val(),
        manufacturer: $('#mm_manufacturer').val(), model: $('#mm_model').val(),
        status: $('#mm_status').val(), description: $('#mm_desc').val()
    }, function(d){
        var m = d.machine || d;
        machinesData.push({id: m.id, name: m.name, code: m.machine_code, model: m.model||''});
        // Update all machine selects
        $('select[name*="[machine_id]"]').each(function(){
            var cur=$(this).val();
            $(this).append('<option value="'+m.id+'">'+m.name+'</option>');
            $(this).val(cur);
        });
        $('#modalAddMachine').modal('hide');
        toastr.success('Machine added!');
    });
}

function saveOperationAjax(){
    ajaxPost('{{ route("company.operations.store") }}', {
        name: $('#mo_name').val(), operation_code: $('#mo_code').val(),
        hourly_rate: $('#mo_rate').val(), status: $('#mo_status').val(),
        description: $('#mo_desc').val()
    }, function(d){
        var o = d.operation || d;
        operationsData.push({id: o.id, name: o.name, rate: parseFloat(o.hourly_rate||0)});
        $('select[name*="[operation_id]"]').each(function(){
            var cur=$(this).val();
            $(this).append('<option value="'+o.id+'" data-rate="'+(o.hourly_rate||0)+'">'+o.name+'</option>');
            $(this).val(cur);
        });
        $('#modalAddOperation').modal('hide');
        toastr.success('Operation added!');
    });
}

function saveLabourAjax(){
    ajaxPost('{{ route("company.operators.store") }}', {
        name: $('#ml_name').val(), operator_code: $('#ml_code').val(),
        phone: $('#ml_phone').val(), skill_level: $('#ml_skill').val(),
        status: $('#ml_status').val()
    }, function(d){
        var o = d.operator || d;
        var rate = parseFloat($('#ml_rate').val())||0;
        operatorsData.push({id: o.id, name: o.name, rate: rate});
        $('select[name*="[labour_id]"]').each(function(){
            var cur=$(this).val();
            $(this).append('<option value="'+o.id+'" data-rate="'+rate+'">'+o.name+'</option>');
            $(this).val(cur);
        });
        $('#modalAddLabour').modal('hide');
        toastr.success('Labour added!');
    });
}

function saveItemAjax(){
    ajaxPost('{{ route("company.items.store") }}', {
        name: $('#mi_name').val(), sku: $('#mi_sku').val(),
        class: $('#mi_class').val(), unit: $('#mi_unit').val(),
        cost_price: $('#mi_cost').val(), sell_price: $('#mi_sell').val(),
        description: $('#mi_desc').val()
    }, function(d){
        var i = d.item || d;
        itemsData.push({id: i.id, name: i.name, sell_price: parseFloat(i.sell_price||0), description: i.description||''});
        $('select[name*="[item_id]"]').each(function(){
            var cur=$(this).val();
            $(this).append('<option value="'+i.id+'" data-rate="'+(i.sell_price||0)+'" data-desc="'+(i.description||'')+'">'+i.name+'</option>');
            $(this).val(cur);
        });
        $('#modalAddItem').modal('hide');
        toastr.success('Item added!');
    });
}

function saveVendorAjax(){
    ajaxPost('{{ route("company.vendors.store") }}', {
        name: $('#mv_name').val(), vendor_code: $('#mv_code').val(),
        vendor_type: $('#mv_type').val(), email: $('#mv_email').val(),
        phone: $('#mv_phone').val(), payment_terms_days: $('#mv_terms').val(),
        status: 'active',
        addresses: [{address_type:'billing', address_line_1:'TBD', city:'TBD', country:'US'}]
    }, function(d){
        var v = d.vendor || d;
        vendorsData.push({id: v.id, name: v.name});
        // Add to all vendor selects and refresh Select2 where initialized
        $('select[name*="vendor_id"]').each(function(){
            var $sel = $(this);
            var cur  = $sel.val();
            var opt  = new Option(v.name, v.id, false, false);
            if(typeof $.fn.select2 === 'function' && $sel.hasClass('select2-hidden-accessible')){
                $sel.append(opt).trigger('change.select2');
            } else {
                $sel.append(opt);
            }
            $sel.val(cur);
        });
        $('#modalAddVendor').modal('hide');
        toastr.success('Vendor added!');
    });
}

function saveChamferAjax(){
    ajaxPost('{{ route("company.chamfers.store") }}', {
        chamfer_code: $('#mch_code').val(), name: $('#mch_name').val(),
        size: $('#mch_size').val(), angle: $('#mch_angle').val(),
        unit_price: $('#mch_price').val(), status: 'active'
    }, function(d){
        var c = d.chamfer || d;
        chamfersData.push({id: c.id, name: c.name, unit_price: parseFloat(c.unit_price||0)});
        var opt = '<option value="'+c.id+'" data-price="'+(c.unit_price||0)+'">'+c.name+'</option>';
        $('select[name*="[chamfer]"]').append(opt);
        $('#modalAddChamfer').modal('hide');
        toastr.success('Chamfer added!');
    });
}

function saveDeburAjax(){
    ajaxPost('{{ route("company.deburs.store") }}', {
        debur_code: $('#mdb_code').val(), name: $('#mdb_name').val(),
        size: $('#mdb_size').val(), unit_price: $('#mdb_price').val(), status: 'active'
    }, function(d){
        var db = d.debur || d;
        debursData.push({id: db.id, name: db.name, unit_price: parseFloat(db.unit_price||0)});
        var opt = '<option value="'+db.id+'" data-price="'+(db.unit_price||0)+'">'+db.name+'</option>';
        $('select[name*="[debur]"]').append(opt);
        $('#modalAddDebur').modal('hide');
        toastr.success('Debur added!');
    });
}

function saveTapAjax(){
    ajaxPost('{{ route("company.taps.store") }}', {
        name: $('#mt_name').val(), tap_code: $('#mt_code').val(),
        diameter: $('#mt_dia').val(), pitch: $('#mt_pitch').val(),
        direction: $('#mt_dir').val(), thread_standard: $('#mt_std').val(),
        tap_price: $('#mt_price').val(), status: $('#mt_status').val()
    }, function(d){
        var t = d.tap || d;
        tapsData.push({id: t.id, name: t.name, tap_price: parseFloat(t.tap_price||0)});
        var opt = '<option value="'+t.id+'" data-price="'+(t.tap_price||0)+'">'+t.name+'</option>';
        $('select[name*="[tap_id]"]').append(opt);
        $('#modalAddTap').modal('hide');
        toastr.success('Tap added!');
    });
}


</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush