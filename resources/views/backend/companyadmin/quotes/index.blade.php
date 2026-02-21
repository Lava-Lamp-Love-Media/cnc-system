@extends('layouts.app')

@section('page-title', 'Quotes')

@section('style')
<style>
/* ── Stat cards ─────────────────────────── */
.stat-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(150px,1fr)); gap:10px; margin-bottom:18px; }
.stat-card { background:#fff; border:1px solid #e4e7ec; border-radius:10px; padding:14px 16px; box-shadow:0 1px 3px rgba(0,0,0,.05); }
.stat-card .sv { font-size:22px; font-weight:800; color:#1a2033; line-height:1; }
.stat-card .sl { font-size:11px; color:#9ca3af; font-weight:600; text-transform:uppercase; letter-spacing:.5px; margin-top:4px; }
.stat-card .si { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:13px; color:#fff; float:right; margin-top:-2px; }

/* ── Filter bar ─────────────────────────── */
.filter-bar { background:#fff; border:1px solid #e4e7ec; border-radius:10px; padding:12px 16px; margin-bottom:14px; display:flex; flex-wrap:wrap; gap:8px; align-items:center; }
.filter-bar .form-control { height:32px; font-size:12px; border-radius:6px; padding:4px 10px; }

/* ── Quote tree wrapper ──────────────────── */
.qt-wrap { background:#fff; border:1px solid #e4e7ec; border-radius:10px; overflow:hidden; box-shadow:0 1px 3px rgba(0,0,0,.05); }

/* Column grid: expand | quote info | type+status | customer | date | qty | each | total | actions */
.qt-cols { grid-template-columns: 30px 1fr 130px 130px 100px 70px 90px 100px 110px; }

/* ── Table head ─────────────────────────── */
.qt-thead {
    display:grid; padding:8px 14px; gap:0;
    background:#f8fafc; border-bottom:2px solid #e4e7ec;
    font-size:10px; font-weight:700; text-transform:uppercase; letter-spacing:.6px; color:#9ca3af;
    align-items:center;
}
@media(max-width:1100px){ .qt-thead { display:none; } }

/* ── Parent wrapper ──────────────────────── */
.qt-parent { border-bottom:1px solid #f1f5f9; }
.qt-parent:last-child { border-bottom:none; }

/* Parent main row */
.qt-prow {
    display:grid; padding:11px 14px; gap:0;
    align-items:center; cursor:pointer; user-select:none;
    transition:background .1s; min-height:54px;
}
.qt-prow:hover { background:#fafbfc; }

/* Expand button */
.exp-btn {
    width:24px; height:24px;
    border:1px solid #d1d5db; border-radius:5px;
    background:#f9fafb; color:#6b7280;
    display:flex; align-items:center; justify-content:center;
    font-size:10px; cursor:pointer; flex-shrink:0;
    transition:all .15s;
}
.exp-btn:hover { background:#e5e7eb; }
.exp-btn.open  { background:#2563eb; border-color:#2563eb; color:#fff; }
.exp-btn .fa-chevron-down { transition:transform .2s; }
.exp-btn.open .fa-chevron-down { transform:rotate(180deg); }

/* Parent cells */
.pqn  { font-weight:800; font-size:13px; color:#2563eb; font-family:monospace; }
.ppt  { font-size:11px; color:#9ca3af; margin-top:2px; }
.pcell { font-size:12px; color:#374151; }
.pamount { font-size:13px; font-weight:800; color:#1a2033; text-align:right; }
.pacts { display:flex; gap:4px; justify-content:flex-end; }
.pacts .btn { font-size:11px; padding:3px 7px; border-radius:5px; }

.chi-count { display:inline-block; background:#f1f5f9; color:#6b7280; border-radius:20px; padding:1px 7px; font-size:10px; font-weight:700; margin-left:4px; }

/* ── Children section ────────────────────── */
.qt-children { display:none; background:#f8fafb; border-top:1px dashed #e9ecef; }
.qt-children.open { display:block; }

/* Child sortable list */
.child-list {
    padding:7px 14px 9px 44px;
    display:flex; flex-direction:column; gap:5px;
    min-height:32px;
    transition:background .15s;
}
.child-list.drag-over {
    background:#eff6ff;
    outline:2px dashed #2563eb;
    outline-offset:-3px;
    border-radius:6px;
}

/* Child row */
.qt-child {
    display:grid; padding:8px 11px; gap:0;
    background:#fff; border:1px solid #e9ecef; border-radius:8px;
    align-items:center; cursor:grab;
    transition:background .1s, box-shadow .1s;
    font-size:12px;
}
.qt-child:hover  { background:#f1f5f9; }
.qt-child:active { cursor:grabbing; }
.qt-child.sortable-ghost  { opacity:.3; background:#dbeafe !important; border:2px dashed #93c5fd; }
.qt-child.sortable-chosen { box-shadow:0 4px 14px rgba(37,99,235,.18); opacity:.95; }
.qt-child.sortable-drag   { box-shadow:0 8px 30px rgba(37,99,235,.25); }

.cdrag { color:#d1d5db; font-size:11px; cursor:grab; }
.cdrag:hover { color:#9ca3af; }
.ccn   { font-weight:700; color:#374151; font-family:monospace; font-size:12px; }
.ccp   { font-size:10px; color:#9ca3af; margin-top:1px; }
.ccamt { font-weight:800; color:#1a2033; text-align:right; font-size:12px; }
.ccacts { display:flex; gap:3px; justify-content:flex-end; }
.ccacts .btn { font-size:10px; padding:2px 6px; border-radius:4px; }

/* Drop hint */
.drop-hint { font-size:11px; color:#c0c9d4; font-style:italic; padding:6px 0 2px; display:none; }
.child-list:empty + .drop-hint, .child-list.drag-over .drop-hint { display:block; }

/* ── Status / type badges ────────────────── */
.bq { display:inline-block; padding:2px 8px; border-radius:20px; font-size:10px; font-weight:700; }
.bq.draft     { background:#f1f5f9; color:#475569; }
.bq.sent      { background:#eff6ff; color:#1d4ed8; }
.bq.approved  { background:#f0fdf4; color:#166534; }
.bq.rejected  { background:#fef2f2; color:#991b1b; }
.bq.converted { background:#f5f3ff; color:#5b21b6; }
.bq.cancelled { background:#f1f5f9; color:#374151; }
.bq.quote     { background:#e0f2fe; color:#0369a1; }
.bq.job_order { background:#fef3c7; color:#92400e; }
.bq.invoice   { background:#d1fae5; color:#065f46; }

/* ── Drag result toast ───────────────────── */
#dtToast {
    display:none; position:fixed; bottom:22px; left:50%; transform:translateX(-50%);
    z-index:9999; background:#1e293b; color:#fff; border-radius:10px;
    padding:10px 20px; font-size:13px; font-weight:600;
    box-shadow:0 4px 20px rgba(0,0,0,.3); align-items:center; gap:8px; white-space:nowrap;
}
#dtToast.vis { display:flex; }
#dtToast.ok  { background:#16a34a; }
#dtToast.err { background:#dc2626; }
</style>
@endsection

@section('content')
<div class="container-fluid">

{{-- Header --}}
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap" style="gap:8px;">
    <h4 class="mb-0" style="font-weight:800;color:#1a2033;">Quotes &amp; Job Orders</h4>
    <div class="d-flex flex-wrap" style="gap:6px;">
        <button onclick="expandAll()"   class="btn btn-outline-secondary btn-sm"><i class="fas fa-expand-alt mr-1"></i>Expand All</button>
        <button onclick="collapseAll()" class="btn btn-outline-secondary btn-sm"><i class="fas fa-compress-alt mr-1"></i>Collapse All</button>
        <a href="{{ route('company.quotes.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus mr-1"></i>New Quote</a>
    </div>
</div>

{{-- Stats --}}
@php
$col   = $quotes->getCollection();
$tots  = $col->sum('grand_total_price');
$chiTot= $col->sum(fn($q)=>$q->children->count());
@endphp
<div class="stat-grid">
    @foreach([
        ['Total Quotes', $quotes->total(), '#2563eb', 'fas fa-file-alt'],
        ['Draft',        $col->where('status','draft')->count(),    '#6b7280', 'fas fa-pencil-alt'],
        ['Sent',         $col->where('status','sent')->count(),     '#0891b2', 'fas fa-paper-plane'],
        ['Approved',     $col->where('status','approved')->count(), '#16a34a', 'fas fa-check-circle'],
        ['Job Orders',   $chiTot,                                   '#ea580c', 'fas fa-hammer'],
        ['Revenue',      '$'.number_format($tots,0),               '#7c3aed', 'fas fa-dollar-sign'],
    ] as [$lbl,$val,$clr,$ico])
    <div class="stat-card">
        <span class="si" style="background:{{ $clr }};"><i class="{{ $ico }}"></i></span>
        <div class="sv">{{ $val }}</div>
        <div class="sl">{{ $lbl }}</div>
    </div>
    @endforeach
</div>

{{-- Filters --}}
<form method="GET" class="filter-bar">
    <span style="font-size:11px;font-weight:700;color:#6b7280;">Search</span>
    <input type="text" name="search" class="form-control" style="width:180px;" placeholder="Quote# / Part# / Customer" value="{{ request('search') }}">
    <span style="font-size:11px;font-weight:700;color:#6b7280;">Status</span>
    <select name="status" class="form-control" style="width:110px;" onchange="this.form.submit()">
        <option value="">All Status</option>
        @foreach(['draft','sent','approved','rejected','converted','cancelled'] as $s)
        <option value="{{ $s }}" {{ request('status')===$s?'selected':'' }}>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <span style="font-size:11px;font-weight:700;color:#6b7280;">Type</span>
    <select name="type" class="form-control" style="width:110px;" onchange="this.form.submit()">
        <option value="">All Types</option>
        @foreach(['quote','job_order','invoice'] as $t)
        <option value="{{ $t }}" {{ request('type')===$t?'selected':'' }}>{{ ucfirst(str_replace('_',' ',$t)) }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search mr-1"></i>Filter</button>
    <a href="{{ route('company.quotes.index') }}" class="btn btn-outline-secondary btn-sm">Clear</a>
</form>

{{-- Tree Table --}}
<div class="qt-wrap">
    <div class="qt-thead qt-cols">
        <div></div>
        <div>Quote / Part Number</div>
        <div>Type · Status</div>
        <div>Customer</div>
        <div>Quote Date</div>
        <div>Qty</div>
        <div>Each</div>
        <div>Total</div>
        <div style="text-align:right;">Actions</div>
    </div>

    <div id="quoteTree">
    @forelse($quotes as $quote)
    @php $kids = $quote->children; @endphp

    <div class="qt-parent" data-id="{{ $quote->id }}">

        {{-- Parent row --}}
        <div class="qt-prow qt-cols" onclick="toggleRow({{ $quote->id }})">

            {{-- Expand button --}}
            <div onclick="event.stopPropagation();">
                @if($kids->count())
                <div class="exp-btn" id="exp-{{ $quote->id }}" onclick="toggleRow({{ $quote->id }})">
                    <i class="fas fa-chevron-down"></i>
                </div>
                @else
                <div style="width:24px;height:24px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-minus" style="font-size:8px;color:#e4e7ec;"></i>
                </div>
                @endif
            </div>

            {{-- Quote info --}}
            <div>
                <div class="pqn">{{ $quote->quote_number }}</div>
                <div class="ppt">
                    @if($quote->part_number)<span>{{ $quote->part_number }}</span>@endif
                    @if($kids->count())<span class="chi-count">{{ $kids->count() }} job order{{ $kids->count()>1?'s':'' }}</span>@endif
                </div>
            </div>

            {{-- Type + Status --}}
            <div style="display:flex;flex-wrap:wrap;gap:3px;align-items:center;">
                <span class="bq {{ $quote->type }}">{{ ucfirst(str_replace('_',' ',$quote->type)) }}</span>
                <span class="bq {{ $quote->status }}">{{ ucfirst($quote->status) }}</span>
            </div>

            {{-- Customer --}}
            <div class="pcell">{{ Str::limit($quote->customer?->name ?? $quote->temp_customer_name ?? '—', 20) }}</div>

            {{-- Date --}}
            <div class="pcell">{{ $quote->quote_date?->format('M d, Y') ?? '—' }}</div>

            {{-- Qty --}}
            <div class="pcell">× {{ number_format($quote->quantity) }}</div>

            {{-- Each --}}
            <div class="pamount">${{ number_format($quote->grand_each_price, 2) }}</div>

            {{-- Total --}}
            <div class="pamount">${{ number_format($quote->grand_total_price, 2) }}</div>

            {{-- Actions --}}
            <div class="pacts" onclick="event.stopPropagation()">
                <a href="{{ route('company.quotes.show', $quote) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                <a href="{{ route('company.quotes.edit', $quote) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" style="padding:3px 7px;"><i class="fas fa-ellipsis-v"></i></button>
                    <div class="dropdown-menu dropdown-menu-right" style="font-size:12px;">
                        <a class="dropdown-item" href="{{ route('company.quotes.create') }}?parent={{ $quote->id }}">
                            <i class="fas fa-plus mr-2 text-success"></i>Add Job Order
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="#" onclick="delQuote({{ $quote->id }}, '{{ $quote->quote_number }}')">
                            <i class="fas fa-trash mr-2"></i>Delete
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Children --}}
        @if($kids->count())
        <div class="qt-children" id="ch-{{ $quote->id }}">
            <div class="child-list"
                 id="cl-{{ $quote->id }}"
                 data-parent="{{ $quote->id }}">

            @foreach($kids as $k)
            <div class="qt-child qt-cols"
                 data-id="{{ $k->id }}"
                 data-parent="{{ $quote->id }}">

                {{-- drag handle --}}
                <div class="cdrag"><i class="fas fa-grip-vertical"></i></div>

                {{-- child info --}}
                <div>
                    <div class="ccn">↳ {{ $k->quote_number }}</div>
                    <div class="ccp">{{ Str::limit($k->part_number ?? $k->engineer_notes ?? 'Job Order', 45) }}</div>
                </div>

                {{-- type + status --}}
                <div style="display:flex;flex-wrap:wrap;gap:3px;align-items:center;">
                    <span class="bq {{ $k->type }}">{{ ucfirst(str_replace('_',' ',$k->type)) }}</span>
                    <span class="bq {{ $k->status }}">{{ ucfirst($k->status) }}</span>
                </div>

                {{-- customer --}}
                <div class="pcell" style="font-size:11px;color:#9ca3af;">{{ Str::limit($k->customer?->name ?? '—', 18) }}</div>

                {{-- date --}}
                <div class="pcell">{{ $k->quote_date?->format('M d, Y') ?? '—' }}</div>

                {{-- qty --}}
                <div class="pcell">× {{ $k->quantity }}</div>

                {{-- each --}}
                <div class="ccamt">${{ number_format($k->grand_each_price, 2) }}</div>

                {{-- total --}}
                <div class="ccamt">${{ number_format($k->grand_total_price, 2) }}</div>

                {{-- actions --}}
                <div class="ccacts" onclick="event.stopPropagation()">
                    <a href="{{ route('company.quotes.show', $k) }}" class="btn btn-sm btn-info" title="View"><i class="fas fa-eye"></i></a>
                    <a href="{{ route('company.quotes.edit', $k) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                    <button class="btn btn-sm btn-outline-danger" onclick="delQuote({{ $k->id }},'{{ $k->quote_number }}')" title="Delete"><i class="fas fa-trash"></i></button>
                </div>
            </div>
            @endforeach

            </div>
            <div style="padding:4px 14px 8px 44px;font-size:11px;color:#c0c9d4;font-style:italic;">
                ↑ Drag any job order to move it under a different quote
            </div>
        </div>
        @endif

    </div>{{-- /qt-parent --}}
    @empty
    <div class="text-center py-5">
        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">No quotes yet</h5>
        <a href="{{ route('company.quotes.create') }}" class="btn btn-primary btn-sm mt-2"><i class="fas fa-plus mr-1"></i>Create First Quote</a>
    </div>
    @endforelse
    </div>{{-- /quoteTree --}}

    @if($quotes->hasPages())
    <div class="p-3 border-top">{{ $quotes->appends(request()->query())->links() }}</div>
    @endif
</div>

</div>{{-- /container --}}

{{-- Delete modal --}}
<div class="modal fade" id="delModal" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header py-2"><h6 class="modal-title mb-0">Confirm Delete</h6><button class="close" data-dismiss="modal">&times;</button></div>
            <div class="modal-body">Delete <strong id="delNum"></strong>?<br><small class="text-muted">Child job orders will also be deleted.</small></div>
            <div class="modal-footer py-2">
                <button class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <form id="delForm" method="POST" style="display:inline;">@csrf @method('DELETE')<button class="btn btn-danger btn-sm">Delete</button></form>
            </div>
        </div>
    </div>
</div>

{{-- Drag toast --}}
<div id="dtToast">
    <i id="dtIcon" class="fas fa-spinner fa-spin"></i>
    <span id="dtText">Moving…</span>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
var CSRF = '{{ csrf_token() }}';

// ── Toggle expand row ────────────────────────────────────
function toggleRow(id) {
    var ch  = document.getElementById('ch-' + id);
    var btn = document.getElementById('exp-' + id);
    if (!ch) return;
    ch.classList.toggle('open');
    if (btn) btn.classList.toggle('open');
}

function expandAll() {
    document.querySelectorAll('.qt-children').forEach(c => c.classList.add('open'));
    document.querySelectorAll('.exp-btn').forEach(b => b.classList.add('open'));
}
function collapseAll() {
    document.querySelectorAll('.qt-children').forEach(c => c.classList.remove('open'));
    document.querySelectorAll('.exp-btn').forEach(b => b.classList.remove('open'));
}

// ── Delete helper ────────────────────────────────────────
function delQuote(id, num) {
    document.getElementById('delNum').textContent = num;
    document.getElementById('delForm').action = '/company/quotes/' + id;
    $('#delModal').modal('show');
}

// ── Toast ────────────────────────────────────────────────
function toast(msg, type) {
    var t = document.getElementById('dtToast');
    t.className = 'vis' + (type ? ' ' + type : '');
    document.getElementById('dtIcon').className = type === 'ok' ? 'fas fa-check' : type === 'err' ? 'fas fa-exclamation-triangle' : 'fas fa-spinner fa-spin';
    document.getElementById('dtText').textContent = msg;
    if (type && type !== 'loading') {
        setTimeout(() => t.classList.remove('vis','ok','err'), 2800);
    }
}

// ── Update badge count ───────────────────────────────────
function updateBadge(parentId) {
    var list  = document.getElementById('cl-' + parentId);
    var badge = document.querySelector('[data-id="' + parentId + '"] .chi-count');
    if (!list) return;
    var n = list.querySelectorAll('.qt-child').length;
    if (badge) {
        badge.textContent = n + ' job order' + (n !== 1 ? 's' : '');
        badge.style.display = n ? '' : 'none';
    }
    // Show/hide the expand button
    var btn = document.getElementById('exp-' + parentId);
    if (btn) btn.style.display = n ? '' : 'none';
}

// ── Init Sortable on all child lists ─────────────────────
// group 'jobs' allows dragging BETWEEN lists (different parents)
document.querySelectorAll('.child-list').forEach(function(list) {
    Sortable.create(list, {
        group:       { name: 'jobs', pull: true, put: true },
        handle:      '.cdrag',
        animation:   200,
        ghostClass:  'sortable-ghost',
        chosenClass: 'sortable-chosen',
        dragClass:   'sortable-drag',

        // Highlight the drop target list
        onOver:  function(e) { e.to.classList.add('drag-over'); },
        onLeave: function(e) { e.to.classList.remove('drag-over'); },

        // Dropped into a DIFFERENT parent list
        onAdd: function(evt) {
            evt.to.classList.remove('drag-over');
            var childId   = evt.item.dataset.id;
            var oldParent = evt.from.dataset.parent;
            var newParent = evt.to.dataset.parent;
            evt.item.dataset.parent = newParent;

            // Make sure the new parent's children row is visible
            var newCh = document.getElementById('ch-' + newParent);
            if (newCh && !newCh.classList.contains('open')) {
                newCh.classList.add('open');
                var expBtn = document.getElementById('exp-' + newParent);
                if (expBtn) expBtn.classList.add('open');
            }

            // Collect new ordering in dest list
            var order = [];
            evt.to.querySelectorAll('.qt-child[data-id]').forEach(r => order.push(r.dataset.id));

            toast('Moving job order…', 'loading');

            fetch('/company/quotes/' + childId + '/move-parent', {
                method:  'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body:    JSON.stringify({ new_parent_id: newParent, order: order })
            })
            .then(r => r.json())
            .then(function(d) {
                if (d.ok) {
                    toast('Moved to ' + d.parent_number, 'ok');
                    updateBadge(oldParent);
                    updateBadge(newParent);
                } else {
                    toast('Failed: ' + (d.error || 'Unknown error'), 'err');
                }
            })
            .catch(() => toast('Network error', 'err'));
        },

        // Reordered within SAME parent list
        onUpdate: function(evt) {
            var parentId = evt.to.dataset.parent;
            var order = [];
            evt.to.querySelectorAll('.qt-child[data-id]').forEach(r => order.push(r.dataset.id));
            fetch('/company/quotes/reorder-children', {
                method:  'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body:    JSON.stringify({ parent_id: parentId, order: order })
            }).catch(() => {});
        }
    });
});
</script>
@endpush