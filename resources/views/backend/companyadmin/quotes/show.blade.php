@extends('layouts.app')

@section('page-title', 'Quote ' . $quote->quote_number)

@section('style')
<style>
/* ── Layout ─────────────────────────────────── */
.show-layout { display:grid; grid-template-columns:1fr 290px; gap:16px; align-items:start; }
@media(max-width:1100px){ .show-layout { grid-template-columns:1fr; } }

/* ── Top bar ────────────────────────────────── */
.q-topbar {
    background:#fff; border:1px solid #e4e7ec; border-radius:10px;
    padding:12px 18px; margin-bottom:16px;
    display:flex; align-items:center; justify-content:space-between;
    flex-wrap:wrap; gap:10px; box-shadow:0 1px 4px rgba(0,0,0,.06);
}
.q-topbar .qn  { font-size:20px; font-weight:800; color:#2563eb; font-family:monospace; }
.q-topbar .qmt { font-size:12px; color:#9ca3af; margin-top:2px; }

/* ── Info card ──────────────────────────────── */
.ic { background:#fff; border:1px solid #e4e7ec; border-radius:10px; margin-bottom:12px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.05); }
.ic-h { padding:10px 16px; background:#f8fafc; border-bottom:1px solid #e4e7ec; display:flex; align-items:center; gap:8px; font-size:13px; font-weight:700; color:#1a2033; }
.ic-h .ico { width:26px;height:26px;border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:11px;color:#fff;flex-shrink:0; }
.ic-b { padding:14px 16px; }
.kv { display:grid; grid-template-columns:repeat(auto-fill,minmax(145px,1fr)); gap:10px; }
.kv-i .kl { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#9ca3af; margin-bottom:2px; }
.kv-i .kv2 { font-size:13px; font-weight:600; color:#1a2033; }
.kv-i .kv2.mono { font-family:monospace; }

/* ── Status badges ──────────────────────────── */
.bs { display:inline-block; padding:3px 10px; border-radius:20px; font-size:11px; font-weight:700; }
.bs.draft     { background:#f1f5f9; color:#475569; }
.bs.sent      { background:#eff6ff; color:#1d4ed8; }
.bs.approved  { background:#f0fdf4; color:#166534; }
.bs.rejected  { background:#fef2f2; color:#991b1b; }
.bs.converted { background:#f5f3ff; color:#5b21b6; }
.bs.cancelled { background:#f1f5f9; color:#374151; }

/* ══════════════════════════════════════════════
   PARENT-CHILD TREE  (matches screenshot style)
   ════════════════════════════════════════════ */

/* Parent card */
.tree-parent {
    background:#fff;
    border:1px solid #e4e7ec;
    border-radius:10px;
    margin-bottom:8px;
    overflow:hidden;
    box-shadow:0 1px 3px rgba(0,0,0,.05);
    transition:box-shadow .15s;
}
.tree-parent:hover { box-shadow:0 3px 10px rgba(0,0,0,.08); }
.tree-parent.sortable-ghost  { opacity:.35; border:2px dashed #93c5fd; background:#eff6ff; }
.tree-parent.sortable-chosen { box-shadow:0 6px 20px rgba(37,99,235,.2); }

/* Parent row — the header that shows in list like screenshot */
.tp-row {
    display:flex; align-items:center;
    padding:11px 14px; gap:10px;
    cursor:default; user-select:none;
    min-height:48px;
}

/* ▼ Expand chevron button — like the ∨ in screenshot */
.tp-chevron-btn {
    width:26px; height:26px; flex-shrink:0;
    border:1px solid #d1d5db; border-radius:6px;
    background:#f9fafb; color:#6b7280;
    display:flex; align-items:center; justify-content:center;
    font-size:11px; cursor:pointer; transition:all .15s;
}
.tp-chevron-btn:hover { background:#e5e7eb; border-color:#9ca3af; }
.tp-chevron-btn .fa-chevron-down { transition:transform .2s; }
.tp-chevron-btn.collapsed .fa-chevron-down { transform:rotate(-90deg); }

/* Drag handle */
.tp-drag { cursor:grab; color:#d1d5db; font-size:13px; flex-shrink:0; padding:2px 3px; border-radius:3px; }
.tp-drag:hover { color:#9ca3af; background:#f3f4f6; }
.tp-drag:active { cursor:grabbing; }

/* Icon pill */
.tp-icon { width:28px; height:28px; border-radius:7px; display:flex; align-items:center; justify-content:center; font-size:11px; color:#fff; flex-shrink:0; }

/* Section name + count */
.tp-label { flex:1; display:flex; align-items:center; gap:8px; }
.tp-name  { font-size:13px; font-weight:700; color:#1a2033; }
.tp-count { background:#f1f5f9; border-radius:20px; padding:2px 8px; font-size:11px; font-weight:700; color:#6b7280; }

/* Total + edit */
.tp-right { display:flex; align-items:center; gap:10px; }
.tp-total { font-size:14px; font-weight:800; color:#1a2033; min-width:80px; text-align:right; }
.tp-edit-btn { font-size:11px; padding:3px 8px; border-radius:5px; white-space:nowrap; }

/* ── Children container ─────────────────────── */
.tp-children { border-top:1px solid #f1f5f9; background:#fafbfc; }
.tp-children.collapsed { display:none; }

.tc-list { padding:8px 12px 4px; display:flex; flex-direction:column; gap:5px; }

/* Child row */
.tree-child {
    background:#fff; border:1px solid #e9ecef; border-radius:8px;
    display:flex; align-items:flex-start; padding:9px 11px; gap:8px;
    transition:background .1s, box-shadow .1s;
}
.tree-child:hover { background:#f8fafc; }
.tree-child.sortable-ghost  { background:#dbeafe !important; opacity:.45; border-style:dashed; border-color:#93c5fd; }
.tree-child.sortable-chosen { box-shadow:0 4px 14px rgba(37,99,235,.15); }

.tc-drag { cursor:grab; color:#d1d5db; font-size:12px; padding-top:2px; flex-shrink:0; border-radius:3px; padding:2px 3px; }
.tc-drag:hover  { color:#9ca3af; background:#f3f4f6; }
.tc-drag:active { cursor:grabbing; }

.tc-num { width:20px; height:20px; border-radius:50%; background:#e5e7eb; color:#6b7280; font-size:10px; font-weight:800; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px; }

.tc-body { flex:1; min-width:0; }
.tc-main { font-weight:700; font-size:12px; color:#1a2033; }
.tc-pills { display:flex; flex-wrap:wrap; gap:4px; margin-top:4px; }
.pill { background:#fff; border:1px solid #e4e7ec; border-radius:20px; padding:2px 7px; font-size:10px; font-weight:600; color:#6b7280; white-space:nowrap; }
.pill.blue   { background:#eff6ff; border-color:#bfdbfe; color:#1d4ed8; }
.pill.green  { background:#f0fdf4; border-color:#bbf7d0; color:#15803d; }
.pill.amber  { background:#fffbeb; border-color:#fde68a; color:#92400e; }
.pill.red    { background:#fef2f2; border-color:#fecaca; color:#b91c1c; }
.pill.purple { background:#f5f3ff; border-color:#ddd6fe; color:#5b21b6; }

.tc-total { font-size:13px; font-weight:800; color:#1a2033; white-space:nowrap; align-self:center; margin-left:auto; padding-left:8px; }

/* Section sub-total footer */
.tc-footer {
    display:flex; justify-content:space-between; align-items:center;
    padding:6px 12px 10px; font-size:11px; color:#9ca3af;
    border-top:1px solid #e9ecef; margin:4px 12px 0;
}
.tc-footer .tf-total { font-size:13px; font-weight:800; color:#1a2033; }

/* ── Floating save btn ──────────────────────── */
#saveOrderBtn {
    display:none; position:fixed; bottom:24px; right:24px; z-index:9999;
    background:#2563eb; color:#fff; border:none; border-radius:30px;
    padding:12px 22px; font-size:13px; font-weight:700;
    box-shadow:0 4px 20px rgba(37,99,235,.4); cursor:pointer;
    align-items:center; gap:8px; transition:background .15s;
}
#saveOrderBtn:hover { background:#1d4ed8; }
#saveOrderBtn.vis { display:flex; }
#saveOrderBtn.ok  { background:#16a34a; }
#saveOrderBtn.err { background:#dc2626; }

/* ── Sidebar ────────────────────────────────── */
.sum-card { background:#fff; border:1px solid #e4e7ec; border-radius:10px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.05); position:sticky; top:70px; }
.sum-head { background:#1e293b; color:#fff; padding:13px 18px; font-size:14px; font-weight:700; }
.sum-line { display:flex; justify-content:space-between; align-items:center; padding:8px 18px; border-bottom:1px solid #f1f5f9; font-size:12px; }
.sum-line .sl { color:#9ca3af; }
.sum-line .sv { font-weight:700; color:#1a2033; text-align:right; }
.sum-line .sv small { display:block; color:#9ca3af; font-weight:400; font-size:10px; }
.sum-line.grand { background:#f0fdf4; padding:12px 18px; }
.sum-line.grand .sl { font-weight:700; color:#166534; font-size:13px; }
.sum-line.grand .sv { font-size:18px; font-weight:900; color:#16a34a; }
.sum-line.dim .sv  { color:#9ca3af; }
.sum-status { padding:12px 18px; border-top:1px solid #e4e7ec; }
.sum-status label { font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#9ca3af; display:block; margin-bottom:7px; }
.status-btns { display:flex; flex-wrap:wrap; gap:5px; }
.status-btns .btn { font-size:11px; border-radius:20px; padding:3px 10px; }
.sum-actions { padding:12px 18px; border-top:1px solid #e4e7ec; display:flex; flex-direction:column; gap:7px; }
</style>
@endsection

@section('content')
<div class="container-fluid">

{{-- Top bar --}}
<div class="q-topbar">
    <div>
        <div class="qn">{{ $quote->quote_number }}</div>
        <div class="qmt">
            {{ ucfirst(str_replace('_',' ',$quote->type)) }}
            @if($quote->part_number) · Part: <strong>{{ $quote->part_number }}</strong>@endif
            @if($quote->cage_number) · Cage: <strong>{{ $quote->cage_number }}</strong>@endif
            · Created {{ $quote->created_at->format('M d, Y') }}
        </div>
    </div>
    <div class="d-flex flex-wrap align-items-center" style="gap:8px;">
        <span class="bs {{ $quote->status }}">{{ ucfirst($quote->status) }}</span>
        <a href="{{ route('company.quotes.edit', $quote) }}" class="btn btn-primary btn-sm">
            <i class="fas fa-pencil-alt mr-1"></i> Edit
        </a>
        <a href="{{ route('company.quotes.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-toggle="dropdown">
                <i class="fas fa-ellipsis-v"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="#" onclick="changeStatus('sent')"><i class="fas fa-paper-plane mr-2 text-info"></i>Mark Sent</a>
                <a class="dropdown-item" href="#" onclick="changeStatus('approved')"><i class="fas fa-check mr-2 text-success"></i>Mark Approved</a>
                <a class="dropdown-item" href="#" onclick="changeStatus('rejected')"><i class="fas fa-times mr-2 text-danger"></i>Mark Rejected</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#delModal">
                    <i class="fas fa-trash mr-2"></i>Delete Quote
                </a>
            </div>
        </div>
    </div>
</div>

<div class="show-layout">
{{-- ═══ LEFT COLUMN ═══ --}}
<div>

{{-- Quote details --}}
<div class="ic">
    <div class="ic-h"><span class="ico" style="background:#2563eb;"><i class="fas fa-file-invoice"></i></span>Quote Details</div>
    <div class="ic-b">
        <div class="kv">
            <div class="kv-i"><div class="kl">Type</div><div class="kv2">{{ ucfirst(str_replace('_',' ',$quote->type)) }}</div></div>
            <div class="kv-i"><div class="kl">Method</div><div class="kv2">{{ ucfirst(str_replace('_',' ',$quote->manufacturing_method ?? '')) }}</div></div>
            <div class="kv-i"><div class="kl">Unit</div><div class="kv2">{{ strtoupper($quote->unit) }}</div></div>
            <div class="kv-i"><div class="kl">Quantity</div><div class="kv2">× {{ $quote->quantity }}</div></div>
            <div class="kv-i"><div class="kl">Setup</div><div class="kv2">${{ number_format($quote->setup_price,2) }}</div></div>
            @if($quote->po_number)<div class="kv-i"><div class="kl">PO #</div><div class="kv2 mono">{{ $quote->po_number }}</div></div>@endif
            <div class="kv-i"><div class="kl">Quote Date</div><div class="kv2">{{ $quote->quote_date?->format('M d, Y') ?? '—' }}</div></div>
            <div class="kv-i"><div class="kl">Due Date</div><div class="kv2">{{ $quote->due_date?->format('M d, Y') ?? '—' }}</div></div>
            <div class="kv-i"><div class="kl">Valid Until</div><div class="kv2">{{ $quote->valid_until?->format('M d, Y') ?? '—' }}</div></div>
        </div>
    </div>
</div>

{{-- Customer --}}
<div class="ic">
    <div class="ic-h"><span class="ico" style="background:#7c3aed;"><i class="fas fa-user"></i></span>Customer</div>
    <div class="ic-b">
        <div class="kv">
            @if($quote->is_temp_customer)
                <div class="kv-i"><div class="kl">Name</div><div class="kv2">{{ $quote->temp_customer_name }} <span style="background:#fffbeb;color:#92400e;font-size:10px;padding:1px 6px;border-radius:10px;font-weight:700;">Walk-in</span></div></div>
                @if($quote->temp_customer_email)<div class="kv-i"><div class="kl">Email</div><div class="kv2">{{ $quote->temp_customer_email }}</div></div>@endif
                @if($quote->temp_customer_phone)<div class="kv-i"><div class="kl">Phone</div><div class="kv2">{{ $quote->temp_customer_phone }}</div></div>@endif
            @elseif($quote->customer)
                <div class="kv-i"><div class="kl">Customer</div><div class="kv2">{{ $quote->customer->name }}</div></div>
            @else
                <div class="kv-i"><div class="kl">Customer</div><div class="kv2" style="color:#9ca3af;">—</div></div>
            @endif
            @if($quote->ship_to)<div class="kv-i" style="grid-column:span 2"><div class="kl">Ship To</div><div class="kv2" style="white-space:pre-line;font-size:12px;">{{ $quote->ship_to }}</div></div>@endif
        </div>
    </div>
</div>

{{-- Material --}}
<div class="ic">
    <div class="ic-h"><span class="ico" style="background:#059669;"><i class="fas fa-cube"></i></span>Material</div>
    <div class="ic-b">
        <div class="kv">
            <div class="kv-i"><div class="kl">Shape</div><div class="kv2">{{ ucfirst(str_replace('_',' ',$quote->shape ?? '')) }}</div></div>
            @if($quote->material)<div class="kv-i"><div class="kl">Material</div><div class="kv2">{{ $quote->material->name }}</div></div>@endif
            @if($quote->pin_diameter > 0)<div class="kv-i"><div class="kl">Diameter</div><div class="kv2 mono">{{ $quote->pin_diameter }}"</div></div>@endif
            @if($quote->pin_length > 0)<div class="kv-i"><div class="kl">Length</div><div class="kv2 mono">{{ $quote->pin_length }}"</div></div>@endif
            @if($quote->width)<div class="kv-i"><div class="kl">W×L×H</div><div class="kv2 mono">{{ $quote->width }}×{{ $quote->length }}×{{ $quote->height }}</div></div>@endif
            <div class="kv-i"><div class="kl">Each Pin</div><div class="kv2">${{ number_format($quote->each_pin_price,4) }}</div></div>
            <div class="kv-i"><div class="kl">Total Pin</div><div class="kv2" style="font-size:14px;font-weight:800;">${{ number_format($quote->total_pin_price,2) }}</div></div>
        </div>
    </div>
</div>

{{-- ═══════════════════════════════════════════
     PARENT-CHILD TREE
     Each section = parent row (like invoice row in screenshot)
     Clicking ∨ expands to show child rows
     Both parent sections AND child rows are drag-sortable
═════════════════════════════════════════════ --}}
@php
$sections = [
    ['key'=>'machines',    'rel'=>'machines',    'table'=>'quote_machines',      'label'=>'Machine',       'icon'=>'fas fa-cog',         'color'=>'#374151'],
    ['key'=>'operations',  'rel'=>'operations',  'table'=>'quote_operations',    'label'=>'Operations',    'icon'=>'fas fa-tools',       'color'=>'#16a34a'],
    ['key'=>'items',       'rel'=>'items',       'table'=>'quote_items',         'label'=>'Items',         'icon'=>'fas fa-box',         'color'=>'#2563eb'],
    ['key'=>'holes',       'rel'=>'holes',       'table'=>'quote_holes',         'label'=>'Holes',         'icon'=>'fas fa-circle-notch','color'=>'#0891b2'],
    ['key'=>'taps',        'rel'=>'taps',        'table'=>'quote_taps',          'label'=>'Taps',          'icon'=>'fas fa-screwdriver', 'color'=>'#dc2626'],
    ['key'=>'threads',     'rel'=>'threads',     'table'=>'quote_threads',       'label'=>'Threads',       'icon'=>'fas fa-minus',       'color'=>'#7c3aed'],
    ['key'=>'secondaryOps','rel'=>'secondaryOps','table'=>'quote_secondary_ops', 'label'=>'Secondary Ops', 'icon'=>'fas fa-layer-group', 'color'=>'#ea580c'],
];
@endphp

<div id="quoteTree">
@foreach($sections as $sec)
@php $children = $quote->{$sec['rel']}; $secTotal = $children->sum('sub_total'); @endphp
@if($children->count())
<div class="tree-parent" data-section="{{ $sec['key'] }}">

    {{-- Parent header row --}}
    <div class="tp-row">
        {{-- ∨ expand button --}}
        <div class="tp-chevron-btn" onclick="toggleSection(this)" title="Expand / Collapse">
            <i class="fas fa-chevron-down"></i>
        </div>
        {{-- drag handle (for reordering sections) --}}
        <span class="tp-drag" title="Drag to reorder section"><i class="fas fa-grip-vertical"></i></span>
        {{-- colour icon --}}
        <span class="tp-icon" style="background:{{ $sec['color'] }};"><i class="{{ $sec['icon'] }}"></i></span>
        {{-- name + count --}}
        <div class="tp-label">
            <span class="tp-name">{{ $sec['label'] }}</span>
            <span class="tp-count">{{ $children->count() }}</span>
        </div>
        {{-- total + edit --}}
        <div class="tp-right">
            <span class="tp-total">${{ number_format($secTotal,2) }}</span>
            <a href="{{ route('company.quotes.edit', $quote) }}#{{ $sec['key'] }}"
               class="btn btn-outline-primary btn-sm tp-edit-btn"
               onclick="event.stopPropagation()">
                <i class="fas fa-pencil-alt"></i>
            </a>
        </div>
    </div>

    {{-- Children (collapsed class hides them, start open) --}}
    <div class="tp-children">
        <div class="tc-list tc-sortable"
             id="sort-{{ $sec['key'] }}"
             data-table="{{ $sec['table'] }}">

        @foreach($children as $i => $child)
        <div class="tree-child" data-id="{{ $child->id }}">
            <span class="tc-drag" title="Drag to reorder"><i class="fas fa-grip-vertical"></i></span>
            <span class="tc-num">{{ $i + 1 }}</span>
            <div class="tc-body">

                @if($sec['key'] === 'machines')
                    <div class="tc-main">
                        {{ $child->machine?->name ?? 'Machine' }}
                        @if($child->model)<span style="font-weight:400;color:#9ca3af;"> · {{ $child->model }}</span>@endif
                    </div>
                    <div class="tc-pills">
                        <span class="pill">{{ $child->labor_mode }}</span>
                        <span class="pill">{{ $child->complexity }}</span>
                        <span class="pill blue">{{ $child->time_minutes }} min</span>
                        <span class="pill green">${{ number_format($child->rate_per_hour,2) }}/hr</span>
                        @if($child->labour?->name)<span class="pill">👤 {{ $child->labour->name }}</span>@endif
                        @if($child->priority && $child->priority !== 'Normal')<span class="pill amber">{{ $child->priority }}</span>@endif
                    </div>

                @elseif($sec['key'] === 'operations')
                    <div class="tc-main">{{ $child->operation?->name ?? 'Operation' }}</div>
                    <div class="tc-pills">
                        <span class="pill blue">{{ $child->time_minutes }} min</span>
                        <span class="pill green">${{ number_format($child->rate_per_hour,2) }}/hr</span>
                        @if($child->labour?->name)<span class="pill">👤 {{ $child->labour->name }}</span>@endif
                    </div>

                @elseif($sec['key'] === 'items')
                    <div class="tc-main">{{ $child->item?->name ?? 'Item' }}</div>
                    <div class="tc-pills">
                        @if($child->description)<span class="pill">{{ Str::limit($child->description,30) }}</span>@endif
                        <span class="pill blue">× {{ $child->qty }}</span>
                        <span class="pill green">${{ number_format($child->rate,2) }} ea</span>
                    </div>

                @elseif($sec['key'] === 'holes')
                    <div class="tc-main">{{ $child->drilling_method }} · ⌀ {{ $child->hole_size }}" ({{ strtoupper($child->hole_unit) }})</div>
                    <div class="tc-pills">
                        <span class="pill blue">× {{ $child->qty }}</span>
                        <span class="pill">{{ ucfirst($child->depth_type) }}</span>
                        <span class="pill">±{{ $child->tol_plus }}</span>
                        @if($child->chamfer?->name)<span class="pill green">Chamfer: {{ $child->chamfer->name }}</span>@endif
                        @if($child->debur?->name)<span class="pill amber">Debur: {{ $child->debur->name }}</span>@endif
                    </div>

                @elseif($sec['key'] === 'taps')
                    <div class="tc-main">{{ $child->tap?->name ?? '—' }} · {{ $child->thread_size }}</div>
                    <div class="tc-pills">
                        <span class="pill">{{ ucfirst($child->direction) }}-hand</span>
                        <span class="pill blue">{{ $child->thread_option }}</span>
                        @if($child->chamfer?->name)<span class="pill green">Chamfer</span>@endif
                        @if($child->debur?->name)<span class="pill amber">Debur</span>@endif
                    </div>

                @elseif($sec['key'] === 'threads')
                    <div class="tc-main">{{ $child->thread?->name ?? '—' }} · {{ $child->thread_size }}</div>
                    <div class="tc-pills">
                        <span class="pill">{{ $child->standard }}</span>
                        <span class="pill blue">Pitch {{ $child->pitch }}</span>
                        <span class="pill purple">Class {{ $child->class }}</span>
                        <span class="pill">{{ ucfirst($child->direction) }}-hand</span>
                    </div>

                @elseif($sec['key'] === 'secondaryOps')
                    <div class="tc-main">{{ $child->name }}</div>
                    <div class="tc-pills">
                        @if($child->vendor?->name)<span class="pill">{{ $child->vendor->name }}</span>@endif
                        <span class="pill blue">{{ ucfirst(str_replace('_',' ',$child->price_type)) }}</span>
                        <span class="pill">× {{ $child->qty }}</span>
                        <span class="pill green">${{ number_format($child->unit_price,2) }}</span>
                    </div>
                @endif

            </div>
            <span class="tc-total">${{ number_format($child->sub_total,2) }}</span>
        </div>
        @endforeach

        </div>{{-- /tc-list --}}
        <div class="tc-footer">
            <span>{{ $sec['label'] }} Sub Total</span>
            <span class="tf-total">${{ number_format($secTotal,2) }}</span>
        </div>
    </div>{{-- /tp-children --}}
</div>
@endif
@endforeach

{{-- Plating --}}
@if($quote->plating_total > 0)
<div class="tree-parent">
    <div class="tp-row">
        <div class="tp-chevron-btn" onclick="toggleSection(this)"><i class="fas fa-chevron-down"></i></div>
        <span class="tp-drag"><i class="fas fa-grip-vertical"></i></span>
        <span class="tp-icon" style="background:#db2777;"><i class="fas fa-flask"></i></span>
        <div class="tp-label"><span class="tp-name">Plating</span></div>
        <div class="tp-right"><span class="tp-total">${{ number_format($quote->plating_total,2) }}</span></div>
    </div>
    <div class="tp-children">
        <div class="tc-list">
            <div class="tree-child" style="background:#fdf2f8;border-color:#f9a8d4;">
                <div class="tc-body">
                    <div class="tc-main">{{ $quote->plating_type ?? 'Plating' }}@if($quote->platingVendor) · {{ $quote->platingVendor->name }}@endif</div>
                    <div class="tc-pills">
                        <span class="pill">{{ ucfirst(str_replace('_',' ',$quote->plating_pricing_type ?? '')) }}</span>
                        @if($quote->plating_count > 0)<span class="pill blue">{{ $quote->plating_count }} × ${{ $quote->plating_price_each }}</span>@endif
                        @if($quote->plating_salt_testing > 0)<span class="pill">Salt Test ${{ $quote->plating_salt_testing }}</span>@endif
                        @if($quote->plating_surcharge > 0)<span class="pill amber">+${{ $quote->plating_surcharge }}</span>@endif
                    </div>
                </div>
                <span class="tc-total">${{ number_format($quote->plating_total,2) }}</span>
            </div>
        </div>
    </div>
</div>
@endif

{{-- Heat Treatment --}}
@if($quote->heat_total > 0)
<div class="tree-parent">
    <div class="tp-row">
        <div class="tp-chevron-btn" onclick="toggleSection(this)"><i class="fas fa-chevron-down"></i></div>
        <span class="tp-drag"><i class="fas fa-grip-vertical"></i></span>
        <span class="tp-icon" style="background:#b45309;"><i class="fas fa-fire"></i></span>
        <div class="tp-label"><span class="tp-name">Heat Treatment</span></div>
        <div class="tp-right"><span class="tp-total">${{ number_format($quote->heat_total,2) }}</span></div>
    </div>
    <div class="tp-children">
        <div class="tc-list">
            <div class="tree-child" style="background:#fffbeb;border-color:#fde68a;">
                <div class="tc-body">
                    <div class="tc-main">{{ $quote->heat_type ?? 'Heat Treatment' }}@if($quote->heatVendor) · {{ $quote->heatVendor->name }}@endif</div>
                    <div class="tc-pills">
                        <span class="pill">{{ ucfirst(str_replace('_',' ',$quote->heat_pricing_type ?? '')) }}</span>
                        @if($quote->heat_count > 0)<span class="pill blue">{{ $quote->heat_count }} × ${{ $quote->heat_price_each }}</span>@endif
                        @if($quote->heat_testing > 0)<span class="pill">Testing ${{ $quote->heat_testing }}</span>@endif
                        @if($quote->heat_surcharge > 0)<span class="pill amber">+${{ $quote->heat_surcharge }}</span>@endif
                    </div>
                </div>
                <span class="tc-total">${{ number_format($quote->heat_total,2) }}</span>
            </div>
        </div>
    </div>
</div>
@endif

</div>{{-- /quoteTree --}}

@if($quote->engineer_notes)
<div class="ic mt-3">
    <div class="ic-h"><span class="ico" style="background:#f59e0b;"><i class="fas fa-sticky-note"></i></span>Engineer Notes</div>
    <div class="ic-b"><div style="background:#fffbeb;border:1px solid #fde68a;border-radius:8px;padding:12px;font-size:13px;color:#92400e;white-space:pre-wrap;">{{ $quote->engineer_notes }}</div></div>
</div>
@endif

</div>{{-- /LEFT --}}

{{-- ═══ RIGHT SIDEBAR ═══ --}}
<div>
<div class="sum-card">
    <div class="sum-head">💰 Pricing Summary</div>
    @php
    $qty   = $quote->quantity;
    $lines = [
        ['Material',      $quote->total_pin_price,              true],
        ['Machine',       $quote->machines->sum('sub_total'),    true],
        ['Operations',    $quote->operations->sum('sub_total'),  true],
        ['Items',         $quote->items->sum('sub_total'),       true],
        ['Holes',         $quote->holes->sum('sub_total'),       true],
        ['Taps',          $quote->taps->sum('sub_total'),        true],
        ['Threads',       $quote->threads->sum('sub_total'),     true],
        ['Secondary Ops', $quote->secondaryOps->sum('sub_total'),true],
        ['Plating',       $quote->plating_total,                 false],
        ['Heat',          $quote->heat_total,                    false],
        ['Break-in',      $quote->break_in_charge,               false],
    ];
    @endphp
    @foreach($lines as [$lbl,$val,$perQty])
    @if($val > 0)
    <div class="sum-line{{ $perQty ? '' : ' dim' }}">
        <span class="sl">{{ $lbl }}</span>
        <span class="sv">
            ${{ number_format($perQty ? $val*$qty : $val, 2) }}
            @if($perQty)<small>${{ number_format($val,2) }} × {{ $qty }}</small>
            @else<small>fixed</small>@endif
        </span>
    </div>
    @endif
    @endforeach
    <div class="sum-line" style="background:#f8fafc;border-top:2px solid #e4e7ec;">
        <span class="sl" style="font-weight:700;">Each Price</span>
        <span class="sv" style="font-size:16px;">${{ number_format($quote->grand_each_price,2) }}</span>
    </div>
    <div style="padding:2px 18px 4px;font-size:10px;color:#9ca3af;">× {{ $quote->quantity }} pieces</div>
    <div class="sum-line grand">
        <span class="sl">GRAND TOTAL</span>
        <span class="sv">${{ number_format($quote->grand_total_price,2) }}</span>
    </div>
    <div class="sum-status">
        <label>Change Status</label>
        <div class="status-btns">
            @foreach(['draft','sent','approved','rejected','cancelled'] as $s)
            <button onclick="changeStatus('{{ $s }}')"
                    class="btn btn-sm {{ $quote->status===$s ? 'btn-dark' : 'btn-outline-secondary' }}">
                {{ ucfirst($s) }}
            </button>
            @endforeach
        </div>
    </div>
    <div class="sum-actions">
        <a href="{{ route('company.quotes.edit', $quote) }}" class="btn btn-primary btn-sm text-center d-block">
            <i class="fas fa-pencil-alt mr-1"></i> Edit Quote
        </a>
        <a href="{{ route('company.quotes.index') }}" class="btn btn-outline-secondary btn-sm text-center d-block">
            <i class="fas fa-arrow-left mr-1"></i> Back to List
        </a>
    </div>
</div>
</div>{{-- /RIGHT --}}
</div>{{-- /show-layout --}}
</div>{{-- /container --}}

{{-- Floating save order button --}}
<button id="saveOrderBtn" onclick="saveOrder()">
    <i class="fas fa-save" id="soIcon"></i>
    <span id="soText">Save Order</span>
</button>

{{-- Delete confirm --}}
<div class="modal fade" id="delModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">Delete <strong>{{ $quote->quote_number }}</strong>? This cannot be undone.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <form action="{{ route('company.quotes.destroy', $quote) }}" method="POST" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
var CSRF     = '{{ csrf_token() }}';
var QUOTE_ID = {{ $quote->id }};
var pending  = {};
var dirty    = false;

// ── Toggle expand / collapse ───────────────────────────────
function toggleSection(btn) {
    btn.classList.toggle('collapsed');
    var row      = btn.closest('.tp-row');
    var children = row.nextElementSibling; // .tp-children
    children.classList.toggle('collapsed');
}

// ── Expand ALL  /  Collapse ALL ────────────────────────────
function expandAll() {
    document.querySelectorAll('.tp-children').forEach(c => c.classList.remove('collapsed'));
    document.querySelectorAll('.tp-chevron-btn').forEach(b => b.classList.remove('collapsed'));
}
function collapseAll() {
    document.querySelectorAll('.tp-children').forEach(c => c.classList.add('collapsed'));
    document.querySelectorAll('.tp-chevron-btn').forEach(b => b.classList.add('collapsed'));
}

// ── Parent section drag-drop (reorder whole sections) ──────
Sortable.create(document.getElementById('quoteTree'), {
    handle: '.tp-drag',
    animation: 220,
    ghostClass: 'sortable-ghost',
    chosenClass: 'sortable-chosen',
    onEnd: markDirty
});

// ── Child row drag-drop (reorder within each section) ──────
document.querySelectorAll('.tc-sortable').forEach(function(container) {
    var table = container.dataset.table;
    Sortable.create(container, {
        handle: '.tc-drag',
        animation: 180,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        onEnd: function() {
            // Renumber
            container.querySelectorAll('.tree-child').forEach(function(row, i) {
                var n = row.querySelector('.tc-num');
                if (n) n.textContent = i + 1;
            });
            // Collect IDs
            var ids = [];
            container.querySelectorAll('.tree-child[data-id]').forEach(function(r) {
                ids.push(r.dataset.id);
            });
            pending[table] = ids;
            markDirty();
        }
    });
});

// ── Dirty state ─────────────────────────────────────────────
function markDirty() {
    dirty = true;
    var btn = document.getElementById('saveOrderBtn');
    btn.classList.add('vis');
    btn.classList.remove('ok','err');
    document.getElementById('soIcon').className = 'fas fa-save';
    document.getElementById('soText').textContent = 'Save Order';
}

// ── Save to server ───────────────────────────────────────────
function saveOrder() {
    if (!dirty || !Object.keys(pending).length) return;
    var btn = document.getElementById('saveOrderBtn');
    btn.disabled = true;
    document.getElementById('soIcon').className = 'fas fa-spinner fa-spin';
    document.getElementById('soText').textContent = 'Saving…';
    fetch('/company/quotes/' + QUOTE_ID + '/reorder', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ orders: pending })
    })
    .then(r => r.json())
    .then(function() {
        btn.classList.add('ok');
        document.getElementById('soIcon').className = 'fas fa-check';
        document.getElementById('soText').textContent = 'Saved!';
        dirty = false; pending = {};
        setTimeout(function() {
            btn.classList.remove('vis','ok'); btn.disabled = false;
            document.getElementById('soIcon').className = 'fas fa-save';
            document.getElementById('soText').textContent = 'Save Order';
        }, 2000);
    })
    .catch(function() {
        btn.classList.add('err');
        document.getElementById('soIcon').className = 'fas fa-exclamation-triangle';
        document.getElementById('soText').textContent = 'Failed — Retry';
        btn.disabled = false;
    });
}

// ── Status change ────────────────────────────────────────────
function changeStatus(status) {
    fetch('/company/quotes/' + QUOTE_ID + '/status', {
        method: 'PATCH',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body: JSON.stringify({ status: status })
    }).then(() => location.reload());
}

// ── Warn on unsaved ──────────────────────────────────────────
window.addEventListener('beforeunload', function(e) {
    if (dirty) { e.preventDefault(); e.returnValue = ''; }
});
</script>
@endpush