<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\QuoteMachine;
use App\Models\QuoteOperation;
use App\Models\QuoteItem;
use App\Models\QuoteHole;
use App\Models\QuoteTap;
use App\Models\QuoteThread;
use App\Models\QuoteSecondaryOp;
use App\Models\QuoteAttachment;
use App\Models\Customer;
use App\Models\Machine;
use App\Models\Operation;
use App\Models\Item;
use App\Models\Vendor;
use App\Models\Tap;
use App\Models\Thread;
use App\Models\Operator;
use App\Models\Chamfer;
use App\Models\Debur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuoteController extends Controller
{
    private function cid(): int
    {
        return Auth::user()->company_id;
    }

    private function nextQuoteNumber(string $type = 'quote'): string
    {
        $prefix = match ($type) {
            'job_order' => 'JO',
            'invoice'   => 'INV',
            default     => 'QT',
        };
        $last = Quote::where('company_id', $this->cid())
            ->where('type', $type)
            ->where('quote_number', 'like', $prefix . '%')
            ->orderByDesc('id')
            ->value('quote_number');

        $num = $last ? ((int) substr($last, strlen($prefix))) + 1 : 1001;
        return $prefix . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    // ── INDEX ──────────────────────────────────────────────
    public function index()
    {
        $quotes = Quote::forCompany($this->cid())
            ->whereNull('parent_id')          // top-level only
            ->with(['customer', 'children.customer'])
            ->orderByDesc('id')
            ->paginate(30);

        return view('backend.companyadmin.quotes.index', compact('quotes'));
    }

    // ── CREATE ─────────────────────────────────────────────
    public function create()
    {
        $cid = $this->cid();

        $customers  = Customer::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $machines   = Machine::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $operations = Operation::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $items      = Item::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $vendors    = Vendor::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $taps       = Tap::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $threads    = Thread::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $operators  = Operator::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $chamfers   = Chamfer::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $deburs     = Debur::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();

        $quoteNumber = $this->nextQuoteNumber('quote');

        $machinesJs = $machines->map(fn($m) => [
            'id' => $m->id,
            'name' => $m->name,
            'code' => $m->machine_code,
            'model' => $m->model ?? '',
        ])->values();

        $operationsJs = $operations->map(fn($o) => [
            'id' => $o->id,
            'name' => $o->name,
            'rate' => (float) $o->hourly_rate,
        ])->values();

        $itemsJs = $items->map(fn($i) => [
            'id' => $i->id,
            'name' => $i->name,
            'sell_price' => (float) $i->sell_price,
            'description' => $i->description ?? '',
        ])->values();

        $vendorsJs = $vendors->map(fn($v) => ['id' => $v->id, 'name' => $v->name])->values();

        $tapsJs = $taps->map(fn($t) => [
            'id' => $t->id,
            'name' => $t->name,
            'tap_price' => (float) $t->tap_price,
        ])->values();

        $threadsJs = $threads->map(fn($t) => [
            'id'             => $t->id,
            'name'           => $t->name,
            'thread_type'    => $t->thread_type   ?? '',
            'thread_standard' => $t->thread_standard ?? '',
            'direction'      => $t->direction     ?? 'right',
            'thread_sizes'   => $t->thread_sizes  ?? [],
            'thread_options' => $t->thread_options ?? [],
            'thread_price'   => (float) ($t->thread_price  ?? 0),
            'option_price'   => (float) ($t->option_price  ?? 0),
            'pitch_price'    => (float) ($t->pitch_price   ?? 0),
            'class_price'    => (float) ($t->class_price   ?? 0),
            'size_price'     => (float) ($t->size_price    ?? 0),
        ])->values();

        $operatorsJs = $operators->map(fn($o) => [
            'id' => $o->id,
            'name' => $o->name,
            'rate' => (float) ($o->hourly_rate ?? 0),
        ])->values();

        $chamfersJs = $chamfers->map(fn($c) => [
            'id' => $c->id,
            'name' => $c->name,
            'unit_price' => (float) $c->unit_price,
        ])->values();

        $debursJs = $deburs->map(fn($d) => [
            'id' => $d->id,
            'name' => $d->name,
            'unit_price' => (float) $d->unit_price,
        ])->values();

        return view('backend.companyadmin.quotes.create', compact(
            'customers',
            'vendors',
            'quoteNumber',
            'machinesJs',
            'operationsJs',
            'itemsJs',
            'vendorsJs',
            'tapsJs',
            'threadsJs',
            'operatorsJs',
            'chamfersJs',
            'debursJs',
            'machines',
            'operations',
            'items',
            'taps',
            'threads',
            'operators',
            'chamfers',
            'deburs'
        ));
    }

    // ── STORE ──────────────────────────────────────────────
    public function store(Request $request)
    {
        $cid = $this->cid();

        $request->validate([
            'type'           => 'required|in:quote,job_order,invoice',
            'quote_number'   => 'required|string|max:50|unique:quotes,quote_number',
            'quantity'       => 'required|integer|min:1',
            'quote_date_raw' => 'nullable|date',
            'due_date_raw'   => 'nullable|date',
            'valid_until_raw' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request, $cid) {

            // ── 1. Parent Quote ─────────────────────────────
            $quote = Quote::create([
                'company_id'             => $cid,
                'type'                   => $request->type,
                'quote_number'           => $request->quote_number,
                'manufacturing_method'   => $request->manufacturing_method ?? 'manufacture_in_house',
                'unit'                   => $request->unit ?? 'inch',
                'quantity'               => $request->quantity,
                'setup_price'            => $request->setup_price ?? 0,
                'quote_date'             => $request->quote_date_raw ?: null,
                'due_date'               => $request->due_date_raw ?: null,
                'valid_until'            => $request->valid_until_raw ?: null,
                'part_number'            => $request->part_number,
                'cage_number'            => $request->cage_number,
                'po_number'              => $request->po_number,
                'customer_id'            => $request->customer_id ?: null,
                'is_temp_customer'       => !empty($request->temp_customer_name),
                'temp_customer_name'     => $request->temp_customer_name,
                'temp_customer_email'    => $request->temp_customer_email,
                'temp_customer_phone'    => $request->temp_customer_phone,
                'ship_to'                => $request->ship_to,
                'bill_to'                => $request->bill_to,
                'shape'                  => $request->shape ?? 'round',
                'pin_diameter'           => $request->pin_diameter ?? 0,
                'diameter_adjustment'    => $request->pin_length_row1 ?? 0,
                'pin_length'             => $request->pin_length ?? 0,
                'material_type'          => $request->material_type,
                'material_id'            => $request->metal_alloy ?: null,
                'block_price'            => $request->block_price ?? 0,
                'metal_adjustment'       => $request->metal_adjustment ?? 0,
                'metal_real_price'       => $request->metal_real_price ?? 0,
                'width'                  => $request->width ?? null,
                'length'                 => $request->length ?? null,
                'height'                 => $request->height ?? null,
                'cubic_inch_volume'      => $request->cubic_inch_volume ?? 0,
                'cubic_mm_volume'        => $request->cubic_mm_volume ?? 0,
                'weight_lb'              => $request->weight_lb ?? 0,
                'weight_kg'              => $request->weight_kg ?? 0,
                'each_pin_price'         => $request->each_pin_price ?? 0,
                'total_pin_price'        => $request->total_pin_price ?? 0,
                'calc_weight_kg'         => $request->calc_weight_kg ?? 0,
                'calc_weight_lbs'        => $request->calc_weight_lbs ?? 0,
                'total_weight_kg'        => $request->total_weight_kg ?? 0,
                'total_weight_lb'        => $request->total_weight_lb ?? 0,
                'plating_vendor_id'      => $request->plating_vendor_id ?: null,
                'plating_type'           => $request->plating_type,
                'plating_pricing_type'   => $request->plating_pricing_type ?? 'per_each',
                'plating_count'          => $request->plating_count ?? 0,
                'plating_price_each'     => $request->plating_price_each ?? 0,
                'plating_total_pounds'   => $request->plating_total_pounds ?? 0,
                'plating_lot_charge'     => $request->plating_lot_charge ?? 0,
                'plating_per_pound'      => $request->plating_per_pound ?? 0,
                'plating_salt_testing'   => $request->plating_salt_testing ?? 0,
                'plating_surcharge'      => $request->plating_surcharge ?? 0,
                'plating_standards_price' => $request->plating_standards_price ?? 0,
                'plating_total'          => $request->plating_total ?? 0,
                'heat_vendor_id'         => $request->heat_vendor_id ?: null,
                'heat_type'              => $request->heat_type,
                'heat_pricing_type'      => $request->heat_pricing_type ?? 'per_each',
                'heat_count'             => $request->heat_count ?? 0,
                'heat_price_each'        => $request->heat_price_each ?? 0,
                'heat_total_pounds'      => $request->heat_total_pounds ?? 0,
                'heat_lot_charge'        => $request->heat_lot_charge ?? 0,
                'heat_per_pound'         => $request->heat_per_pound ?? 0,
                'heat_testing'           => $request->heat_testing ?? 0,
                'heat_surcharge'         => $request->heat_surcharge ?? 0,
                'heat_total'             => $request->heat_total ?? 0,
                'break_in_charge'        => $request->break_in_charge ?? 0,
                'override_price'         => $request->override_price ?? 0,
                'grand_each_price'       => $request->grand_each_price ?? 0,
                'grand_total_price'      => $request->grand_total_price ?? 0,
                'engineer_notes'         => $request->engineer_notes,
                'status'                 => 'draft',
            ]);

            // ── 2. Machines ─────────────────────────────────
            foreach ((array) $request->machines as $i => $row) {
                if (empty($row['machine_id']) && (float)($row['time'] ?? 0) == 0) continue;
                QuoteMachine::create([
                    'quote_id'      => $quote->id,
                    'machine_id'    => $row['machine_id'] ?: null,
                    'labour_id'     => $row['labour_id'] ?: null,
                    'model'         => $row['model'] ?? null,
                    'labor_mode'    => $row['labor_mode'] ?? 'Attended',
                    'material'      => $row['material'] ?? null,
                    'complexity'    => $row['complexity'] ?? 'Simple',
                    'priority'      => $row['priority'] ?? 'Normal',
                    'time_minutes'  => $row['time'] ?? 0,
                    'rate_per_hour' => $row['rate'] ?? 0,
                    'sub_total'     => $row['sub_total'] ?? 0,
                    'sort_order'    => $i,
                ]);
            }

            // ── 3. Operations ───────────────────────────────
            foreach ((array) $request->operations as $i => $row) {
                if (empty($row['operation_id']) && (float)($row['time'] ?? 0) == 0) continue;
                QuoteOperation::create([
                    'quote_id'      => $quote->id,
                    'operation_id'  => $row['operation_id'] ?: null,
                    'labour_id'     => $row['labour_id'] ?: null,
                    'time_minutes'  => $row['time'] ?? 0,
                    'rate_per_hour' => $row['rate'] ?? 0,
                    'sub_total'     => $row['sub_total'] ?? 0,
                    'sort_order'    => $i,
                ]);
            }

            // ── 4. Items ────────────────────────────────────
            foreach ((array) $request->items as $i => $row) {
                if (empty($row['item_id']) && (float)($row['rate'] ?? 0) == 0) continue;
                QuoteItem::create([
                    'quote_id'   => $quote->id,
                    'item_id'    => $row['item_id'] ?: null,
                    'description' => $row['description'] ?? null,
                    'qty'        => $row['qty'] ?? 1,
                    'rate'       => $row['rate'] ?? 0,
                    'sub_total'  => $row['sub_total'] ?? 0,
                    'sort_order' => $i,
                ]);
            }

            // ── 5. Holes ────────────────────────────────────
            foreach ((array) $request->holes as $i => $row) {
                if (empty($row['hole_size']) && (float)($row['hole_price'] ?? 0) == 0) continue;
                QuoteHole::create([
                    'quote_id'       => $quote->id,
                    'qty'            => $row['qty'] ?? 1,
                    'drilling_method' => $row['drilling_method'] ?? null,
                    'hole_size'      => $row['hole_size'] ?? null,
                    'hole_unit'      => $request->unit ?? 'mm',
                    'tol_plus'       => $row['tol_plus'] ?? 0.005,
                    'tol_minus'      => $row['tol_minus'] ?? 0.005,
                    'depth_type'     => $row['depth_type'] ?? 'through',
                    'depth_size'     => $row['depth_size'] ?? null,
                    'hole_price'     => $row['hole_price'] ?? 0,
                    'chamfer_id'     => $row['chamfer'] ?: null,
                    'chamfer_size'   => $row['chamfer_size'] ?? null,
                    'chamfer_price'  => $row['chamfer_price'] ?? 0,
                    'debur_id'       => $row['debur'] ?: null,
                    'debur_size'     => $row['debur_size'] ?? null,
                    'debur_price'    => $row['debur_price'] ?? 0,
                    'sub_total'      => $row['sub_total'] ?? 0,
                    'sort_order'     => $i,
                ]);
            }

            // ── 6. Taps ─────────────────────────────────────
            foreach ((array) $request->taps as $i => $row) {
                if (empty($row['tap_id']) && (float)($row['tap_price'] ?? 0) == 0) continue;
                QuoteTap::create([
                    'quote_id'     => $quote->id,
                    'tap_id'       => $row['tap_id'] ?: null,
                    'tap_price'    => $row['tap_price'] ?? 0,
                    'thread_option' => $row['thread_option'] ?? null,
                    'option_price' => $row['option_price'] ?? 0,
                    'direction'    => $row['direction'] ?? 'right',
                    'thread_size'  => $row['thread_size'] ?? null,
                    'base_price'   => $row['base_price'] ?? 0,
                    'chamfer_id'   => $row['chamfer'] ?: null,
                    'chamfer_size' => $row['chamfer_size'] ?? null,
                    'chamfer_price' => $row['chamfer_price'] ?? 0,
                    'debur_id'     => $row['debur'] ?: null,
                    'debur_size'   => $row['debur_size'] ?? null,
                    'debur_price'  => $row['debur_price'] ?? 0,
                    'sub_total'    => $row['sub_total'] ?? 0,
                    'sort_order'   => $i,
                ]);
            }

            // ── 7. Threads ──────────────────────────────────
            foreach ((array) $request->threads as $i => $row) {
                if (empty($row['thread_id']) && (float)($row['thread_price'] ?? 0) == 0) continue;
                QuoteThread::create([
                    'quote_id'     => $quote->id,
                    'thread_id'    => $row['thread_id'] ?: null,
                    'thread_price' => $row['thread_price'] ?? 0,
                    'option'       => $row['option'] ?? null,
                    'option_price' => $row['option_price'] ?? 0,
                    'direction'    => $row['direction'] ?? 'right',
                    'thread_size'  => $row['thread_size'] ?? null,
                    'size_price'   => $row['size_price'] ?? 0,
                    'standard'     => $row['standard'] ?? null,
                    'pitch'        => $row['pitch'] ?? null,
                    'pitch_price'  => $row['pitch_price'] ?? 0,
                    'class'        => $row['class'] ?? null,
                    'class_price'  => $row['class_price'] ?? 0,
                    'sub_total'    => $row['sub_total'] ?? 0,
                    'sort_order'   => $i,
                ]);
            }

            // ── 8. Secondary Ops ────────────────────────────
            foreach ((array) $request->secondary as $i => $row) {
                if (empty($row['name']) && (float)($row['unit_price'] ?? 0) == 0) continue;
                QuoteSecondaryOp::create([
                    'quote_id'   => $quote->id,
                    'vendor_id'  => $row['vendor_id'] ?: null,
                    'name'       => $row['name'] ?? 'Secondary Op',
                    'price_type' => $row['price_type'] ?? 'lot',
                    'qty'        => $row['qty'] ?? 1,
                    'unit_price' => $row['unit_price'] ?? 0,
                    'sub_total'  => $row['sub_total'] ?? 0,
                    'sort_order' => $i,
                ]);
            }

            // ── 9. Attachments ──────────────────────────────
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    if (!$file->isValid()) continue;
                    $storedName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs(
                        'quotes/' . $quote->id . '/attachments',
                        $storedName,
                        'local'
                    );
                    QuoteAttachment::create([
                        'quote_id'      => $quote->id,
                        'original_name' => $file->getClientOriginalName(),
                        'stored_name'   => $storedName,
                        'mime_type'     => $file->getMimeType(),
                        'file_size'     => $file->getSize(),
                        'disk'          => 'local',
                        'path'          => $path,
                    ]);
                }
            }

            session()->flash('toast_success', 'Quote ' . $quote->quote_number . ' saved successfully!');
        });

        return redirect()->route('company.quotes.index');
    }

    // ── SHOW ───────────────────────────────────────────────
    public function show(Quote $quote)
    {
        $this->authorizeCompany($quote);
        $quote->load([
            'customer',
            'material',
            'platingVendor',
            'heatVendor',
            'machines.machine',
            'machines.labour',
            'operations.operation',
            'operations.labour',
            'items.item',
            'holes.chamfer',
            'holes.debur',
            'taps.tap',
            'taps.chamfer',
            'taps.debur',
            'threads.thread',
            'secondaryOps.vendor',
            'attachments',
        ]);
        return view('backend.companyadmin.quotes.show', compact('quote'));
    }


    // ── EDIT ───────────────────────────────────────────────
    public function edit(Quote $quote)
    {
        $this->authorizeCompany($quote);
        $cid = $this->cid();

        $customers  = Customer::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $machines   = Machine::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $operations = Operation::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $items      = Item::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $vendors    = Vendor::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $taps       = Tap::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $threads    = Thread::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $operators  = Operator::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $chamfers   = Chamfer::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();
        $deburs     = Debur::where('company_id', $cid)->where('status', 'active')->orderBy('name')->get();

        $quoteNumber = $quote->quote_number;

        $machinesJs   = $machines->map(fn($m) => ['id' => $m->id, 'name' => $m->name, 'code' => $m->machine_code, 'model' => $m->model ?? ''])->values();
        $operationsJs = $operations->map(fn($o) => ['id' => $o->id, 'name' => $o->name, 'rate' => (float) $o->hourly_rate])->values();
        $itemsJs      = $items->map(fn($i) => ['id' => $i->id, 'name' => $i->name, 'sell_price' => (float) $i->sell_price, 'description' => $i->description ?? ''])->values();
        $vendorsJs    = $vendors->map(fn($v) => ['id' => $v->id, 'name' => $v->name])->values();
        $tapsJs       = $taps->map(fn($t) => ['id' => $t->id, 'name' => $t->name, 'tap_price' => (float) $t->tap_price])->values();
        $threadsJs    = $threads->map(fn($t) => [
            'id' => $t->id,
            'name' => $t->name,
            'thread_type' => $t->thread_type ?? '',
            'thread_standard' => $t->thread_standard ?? '',
            'direction' => $t->direction ?? 'right',
            'thread_sizes' => $t->thread_sizes ?? [],
            'thread_options' => $t->thread_options ?? [],
            'thread_price' => (float)($t->thread_price ?? 0),
            'option_price' => (float)($t->option_price ?? 0),
            'pitch_price' => (float)($t->pitch_price ?? 0),
            'class_price' => (float)($t->class_price ?? 0),
            'size_price' => (float)($t->size_price ?? 0),
        ])->values();
        $operatorsJs  = $operators->map(fn($o) => ['id' => $o->id, 'name' => $o->name, 'rate' => (float)($o->hourly_rate ?? 0)])->values();
        $chamfersJs   = $chamfers->map(fn($c) => ['id' => $c->id, 'name' => $c->name, 'unit_price' => (float) $c->unit_price])->values();
        $debursJs     = $deburs->map(fn($d) => ['id' => $d->id, 'name' => $d->name, 'unit_price' => (float) $d->unit_price])->values();

        $quote->load([
            'machines.machine',
            'machines.labour',
            'operations.operation',
            'operations.labour',
            'items.item',
            'holes.chamfer',
            'holes.debur',
            'taps.tap',
            'taps.chamfer',
            'taps.debur',
            'threads.thread',
            'secondaryOps.vendor',
            'attachments',
        ]);

        return view('backend.companyadmin.quotes.edit', compact(
            'quote',
            'customers',
            'vendors',
            'quoteNumber',
            'machinesJs',
            'operationsJs',
            'itemsJs',
            'vendorsJs',
            'tapsJs',
            'threadsJs',
            'operatorsJs',
            'chamfersJs',
            'debursJs',
            'machines',
            'operations',
            'items',
            'taps',
            'threads',
            'operators',
            'chamfers',
            'deburs'
        ));
    }

    // ── DESTROY ────────────────────────────────────────────
    public function destroy(Quote $quote)
    {
        $this->authorizeCompany($quote);
        $quote->delete();
        session()->flash('toast_success', 'Quote deleted.');
        return redirect()->route('company.quotes.index');
    }

    // ── AJAX: materials list ───────────────────────────────
    public function ajaxList()
    {
        $materials = \App\Models\Material::where('company_id', $this->cid())
            ->where('status', 'active')
            ->orderBy('name')
            ->get([
                'id',
                'name',
                'type',
                'unit',
                'price',
                'adj',
                'adj_type',
                'real_price',
                'density',
                'diameter_from',
                'diameter_to',
                'code'
            ]);
        return response()->json($materials);
    }


    // ── MOVE CHILD TO DIFFERENT PARENT ────────────────────
    public function moveParent(Request $request, Quote $quote)
    {
        $this->authorizeCompany($quote);
        $newParentId = $request->input('new_parent_id');
        $order       = $request->input('order', []);

        // Validate new parent belongs to same company
        $newParent = Quote::where('company_id', $this->cid())
            ->whereNull('parent_id')
            ->find($newParentId);

        if (!$newParent) {
            return response()->json(['ok' => false, 'error' => 'Invalid parent quote']);
        }

        // Move this quote to the new parent
        $quote->update(['parent_id' => $newParentId]);

        // Re-order all children of the new parent
        if (!empty($order)) {
            foreach ($order as $i => $id) {
                Quote::where('id', $id)
                    ->where('company_id', $this->cid())
                    ->update(['tree_order' => $i]);
            }
        }

        return response()->json([
            'ok'            => true,
            'parent_number' => $newParent->quote_number,
        ]);
    }

    // ── REORDER CHILDREN WITHIN SAME PARENT ────────────────
    public function reorderChildren(Request $request)
    {
        $parentId = $request->input('parent_id');
        $order    = $request->input('order', []);

        foreach ($order as $i => $id) {
            Quote::where('id', $id)
                ->where('company_id', $this->cid())
                ->update(['tree_order' => $i]);
        }

        return response()->json(['ok' => true]);
    }

    private function authorizeCompany(Quote $quote): void
    {
        if ($quote->company_id !== $this->cid()) abort(403);
    }
    // ── AJAX: Reorder child rows ───────────────────────────
    public function reorder(Request $request, Quote $quote)
    {
        $this->authorizeCompany($quote);
        $orders = $request->input('orders', []);

        $tableMap = [
            'quote_machines'      => \App\Models\QuoteMachine::class,
            'quote_operations'    => \App\Models\QuoteOperation::class,
            'quote_items'         => \App\Models\QuoteItem::class,
            'quote_holes'         => \App\Models\QuoteHole::class,
            'quote_taps'          => \App\Models\QuoteTap::class,
            'quote_threads'       => \App\Models\QuoteThread::class,
            'quote_secondary_ops' => \App\Models\QuoteSecondaryOp::class,
        ];

        foreach ($orders as $table => $ids) {
            if (!isset($tableMap[$table])) continue;
            $model = $tableMap[$table];
            foreach ($ids as $sortOrder => $id) {
                $model::where('id', $id)
                    ->where('quote_id', $quote->id)
                    ->update(['sort_order' => (int) $sortOrder]);
            }
        }

        return response()->json(['ok' => true]);
    }

    // ── AJAX: Change status ────────────────────────────────
    public function changeStatus(Request $request, Quote $quote)
    {
        $this->authorizeCompany($quote);
        $request->validate([
            'status' => 'required|in:draft,sent,approved,rejected,converted,cancelled'
        ]);
        $quote->update(['status' => $request->status]);
        return response()->json(['ok' => true]);
    }

    // ── Duplicate quote + all children ────────────────────
    public function duplicate(Quote $quote)
    {
        $this->authorizeCompany($quote);
        $new = $quote->replicate();
        $new->quote_number = $this->nextQuoteNumber($quote->type);
        $new->status       = 'draft';
        $new->quote_date   = now()->toDateString();
        $new->save();

        foreach (['machines', 'operations', 'items', 'holes', 'taps', 'threads', 'secondaryOps'] as $rel) {
            foreach ($quote->{$rel} as $child) {
                $copy = $child->replicate();
                $copy->quote_id = $new->id;
                $copy->save();
            }
        }

        return response()->json(['redirect' => route('company.quotes.edit', $new)]);
    }

    // ── Bulk status update ────────────────────────────────
    public function bulkStatus(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'status' => 'required|string']);
        Quote::forCompany($this->cid())
            ->whereIn('id', $request->ids)
            ->update(['status' => $request->status]);
        return response()->json(['ok' => true]);
    }

    // ── Bulk delete ───────────────────────────────────────
    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array']);
        Quote::forCompany($this->cid())
            ->whereIn('id', $request->ids)
            ->delete();
        return response()->json(['ok' => true]);
    }
}
