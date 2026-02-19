<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Chamfer;
use App\Models\Customer;
use App\Models\Debur;
use App\Models\Item;
use App\Models\Machine;
use App\Models\Operation;
use App\Models\Operator;
use App\Models\Tap;
use App\Models\Thread;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class QuoteController extends Controller
{

    public function create()
    {
        $companyId = auth()->user()->company_id;

        $customers  = Customer::where('company_id', $companyId)
            ->with(['defaultShippingAddress', 'billingAddress'])
            ->orderBy('name')
            ->get();

        $machines   = Machine::where('company_id', $companyId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $operations = Operation::where('company_id', $companyId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $items      = Item::where('company_id', $companyId)
            ->orderBy('name')
            ->get();

        $vendors    = Vendor::where('company_id', $companyId)
            ->orderBy('name')
            ->get();

        $taps       = Tap::where('company_id', $companyId)
            ->orderBy('name')
            ->get();

        $chamfers   = Chamfer::where('company_id', $companyId)
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $deburs     = Debur::where('company_id', $companyId)
            ->where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $threads    = Thread::where('company_id', $companyId)
            ->orderBy('name')
            ->get();

        $operators  = Operator::where('company_id', $companyId)
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        // ✅  generateQuoteNumber is defined on the Quote model
        // $quoteNumber = Quote::generateQuoteNumber($companyId);
        $quoteNumber = 'Q' . time();

        // Pre-built plain arrays for JS – avoids Blade ParseError with @json + closures
        $machinesJs   = $machines->map(function ($m) {
            return ['id' => $m->id, 'name' => $m->name, 'code' => $m->machine_code, 'model' => $m->model];
        })->values()->toArray();

        $operationsJs = $operations->map(function ($o) {
            return ['id' => $o->id, 'name' => $o->name, 'rate' => (float) $o->hourly_rate];
        })->values()->toArray();

        $itemsJs = $items->map(function ($i) {
            return ['id' => $i->id, 'name' => $i->name, 'sell_price' => (float) $i->sell_price, 'description' => $i->description ?? ''];
        })->values()->toArray();

        $vendorsJs = $vendors->map(function ($v) {
            return ['id' => $v->id, 'name' => $v->name];
        })->values()->toArray();

        $tapsJs = $taps->map(function ($t) {
            return ['id' => $t->id, 'name' => $t->name, 'tap_price' => (float) ($t->tap_price ?? 0)];
        })->values()->toArray();

        $operatorsJs = $operators->map(function ($o) {
            return ['id' => $o->id, 'name' => $o->name, 'rate' => 0];
        })->values()->toArray();

        $chamfersJs = $chamfers->map(function ($c) {
            return ['id' => $c->id, 'name' => $c->name, 'unit_price' => (float) $c->unit_price];
        })->values()->toArray();

        $debursJs = $deburs->map(function ($d) {
            return ['id' => $d->id, 'name' => $d->name, 'unit_price' => (float) $d->unit_price];
        })->values()->toArray();

        return view('backend.companyadmin.quotes.create', compact(
            'customers',
            'machines',
            'operations',
            'items',
            'vendors',
            'taps',
            'threads',
            'operators',
            'chamfers',
            'deburs',
            'quoteNumber',
            'machinesJs',
            'operationsJs',
            'itemsJs',
            'vendorsJs',
            'tapsJs',
            'operatorsJs',
            'chamfersJs',
            'debursJs'
        ));
    }

    public function store(Request $request) {}
    public function index(Request $request) {}
}
