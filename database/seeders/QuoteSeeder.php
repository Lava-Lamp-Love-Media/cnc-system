<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuoteSeeder extends Seeder
{
    private int $companyId = 1;
    private array $machines   = [];
    private array $operations = [];
    private array $items      = [];
    private array $vendors    = [];
    private array $taps       = [];
    private array $threads    = [];
    private array $operators  = [];
    private array $chamfers   = [];
    private array $deburs     = [];
    private array $customers  = [];
    private array $materials  = [];
    private int   $seq        = 1;

    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('quote_attachments')->truncate();
        DB::table('quote_secondary_ops')->truncate();
        DB::table('quote_threads')->truncate();
        DB::table('quote_taps')->truncate();
        DB::table('quote_holes')->truncate();
        DB::table('quote_items')->truncate();
        DB::table('quote_operations')->truncate();
        DB::table('quote_machines')->truncate();
        DB::table('quotes')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $cid = $this->companyId;
        $this->machines   = DB::table('machines')->where('company_id', $cid)->where('status', 'active')->pluck('id')->toArray();
        $this->operations = DB::table('operations')->where('company_id', $cid)->where('status', 'active')->pluck('id')->toArray();
        $this->items      = DB::table('items')->where('company_id', $cid)->where('status', 'active')->pluck('id')->toArray();
        $this->vendors    = DB::table('vendors')->where('company_id', $cid)->where('status', 'active')->pluck('id')->toArray();
        $this->taps       = DB::table('taps')->where('company_id', $cid)->where('status', 'active')->pluck('id')->toArray();
        $this->threads    = DB::table('threads')->where('company_id', $cid)->where('status', 'active')->pluck('id')->toArray();
        $this->operators  = DB::table('operators')->where('company_id', $cid)->where('status', 'active')->pluck('id')->toArray();
        $this->chamfers   = DB::table('chamfers')->where('company_id', $cid)->where('status', 'active')->pluck('id')->toArray();
        $this->deburs     = DB::table('deburs')->where('company_id', $cid)->where('status', 'active')->pluck('id')->toArray();
        $this->customers  = DB::table('customers')->where('company_id', $cid)->pluck('id')->toArray();
        $this->materials  = DB::table('materials')->where('company_id', $cid)->where('status', 'active')->pluck('id')->toArray();

        // ══ 15 parent quotes, each with 2-4 child job orders ══

        $p1 = $this->parent('Hydraulic Cylinder Piston Rod',  'approved', 25, 48.50);
        $this->child($p1, 'Rough Turn',     'converted', 10, 1, 3, 2, 3);
        $this->child($p1, 'Finish Grind',   'approved',  10, 2, 2, 1, 2);
        $this->child($p1, 'Thread & Tap',   'sent',       5, 3, 1, 1, 2, true);

        $p2 = $this->parent('Aerospace Mounting Bracket',     'approved', 10, 185.00);
        $this->child($p2, '5-Axis Milling', 'converted',  5, 1, 4, 3, 2);
        $this->child($p2, 'Drilling',       'approved',   5, 2, 2, 2, 4);
        $this->child($p2, 'Anodize Prep',   'draft',       0, 3, 1, 1, 1);

        $p3 = $this->parent('Custom Valve Body',              'sent',     50, 22.75);
        $this->child($p3, 'Bore & Turn',    'sent',      15, 1, 3, 2, 2);
        $this->child($p3, 'Port Drilling',  'draft',      0, 2, 2, 1, 5);
        $this->child($p3, 'Thread Ops',     'draft',      0, 3, 2, 1, 2, true);
        $this->child($p3, 'Final Deburr',   'draft',      0, 4, 1, 1, 1);

        $p4 = $this->parent('Surgical Tool Handle',           'approved', 100, 12.40);
        $this->child($p4, 'CNC Turn',       'converted', 50, 1, 2, 2, 2);
        $this->child($p4, 'Knurl & Finish', 'approved',  50, 2, 2, 1, 1);

        $p5 = $this->parent('Heavy Duty Flange',              'draft',    30, 65.00);
        $this->child($p5, 'Face Mill',      'draft',      0, 1, 3, 2, 3);
        $this->child($p5, 'Bolt Pattern',   'draft',      0, 2, 2, 1, 6);
        $this->child($p5, 'Bore Centre',    'draft',      0, 3, 2, 1, 2);

        $p6 = $this->parent('Precision Shaft Assembly',       'approved', 20, 95.00);
        $this->child($p6, 'Bar Turn',       'approved',  10, 1, 4, 2, 2);
        $this->child($p6, 'Keyway Mill',    'approved',  10, 2, 2, 2, 1);
        $this->child($p6, 'OD Grind',       'sent',       0, 3, 2, 1, 1);

        $p7 = $this->parent('Pump Impeller',                  'sent',     15, 138.00);
        $this->child($p7, '5-Axis Mill',    'sent',       8, 1, 4, 3, 2);
        $this->child($p7, 'Bore & Balance', 'draft',      0, 2, 2, 2, 2);

        $p8 = $this->parent('Gearbox Housing',                'approved',  5, 520.00);
        $this->child($p8, 'Rough Mill',     'approved',   3, 1, 4, 2, 2);
        $this->child($p8, 'Bore Array',     'approved',   2, 2, 3, 2, 8);
        $this->child($p8, 'Tap All Holes',  'sent',       0, 3, 2, 1, 4, true);
        $this->child($p8, 'Surface Grind',  'draft',      0, 4, 2, 1, 1);

        $p9 = $this->parent('Optical Lens Holder',            'rejected',  8, 210.00);
        $this->child($p9, 'Turn OD/ID',     'rejected',   0, 1, 3, 2, 2);
        $this->child($p9, 'Thread Ring',    'rejected',   0, 2, 2, 1, 2, true);

        $p10 = $this->parent('Heat Exchanger Tube Plate',     'approved',  4, 845.00);
        $this->child($p10, 'Face & Drill',  'approved',   2, 1, 3, 2, 12);
        $this->child($p10, 'Tap Grid',      'approved',   2, 2, 2, 1,  8, true);
        $this->child($p10, 'CMM Inspect',   'sent',        0, 3, 1, 1,  1);

        $p11 = $this->parent('Rifle Scope Mount',             'draft',    50, 38.00);
        $this->child($p11, 'Mill Profile',  'draft',      0, 1, 3, 2, 2);
        $this->child($p11, 'Clamp Holes',   'draft',      0, 2, 2, 1, 4);
        $this->child($p11, 'Anodize Prep',  'draft',      0, 3, 1, 1, 1);

        $p12 = $this->parent('Industrial Robot Arm Joint',    'approved',  6, 680.00);
        $this->child($p12, '5-Axis Profile', 'approved',   3, 1, 4, 3, 2);
        $this->child($p12, 'Bearing Bores', 'approved',   3, 2, 3, 2, 3);
        $this->child($p12, 'Wrist Threads', 'sent',        0, 3, 2, 1, 2, true);

        $p13 = $this->parent('Compressor Crankshaft',         'sent',      3, 1250.00);
        $this->child($p13, 'Rough Turn',    'sent',        2, 1, 5, 2, 2);
        $this->child($p13, 'Journal Grind', 'draft',       0, 2, 3, 2, 1);
        $this->child($p13, 'Oil Ports',     'draft',       0, 3, 2, 1, 4);
        $this->child($p13, 'Thread Ends',   'draft',       0, 4, 2, 1, 2, true);

        $p14 = $this->parent('Prototype Medical Implant',     'approved',  2, 3200.00);
        $this->child($p14, 'Ti Turning',    'approved',   1, 1, 4, 2, 2);
        $this->child($p14, 'Micro Holes',   'approved',   1, 2, 3, 2, 6);
        $this->child($p14, 'Surface Prep',  'sent',        0, 3, 2, 1, 1);

        $p15 = $this->parent('Automotive Throttle Body',      'draft',   200, 18.50);
        $this->child($p15, 'Die Cast Trim', 'draft',       0, 1, 3, 2, 3);
        $this->child($p15, 'Bore & Ream',   'draft',       0, 2, 3, 1, 2);
        $this->child($p15, 'Tap Bosses',    'draft',       0, 3, 2, 1, 4, true);

        $total = DB::table('quotes')->count();
        $this->command->info("✅ QuoteSeeder done: {$total} quotes total");
    }

    // ── Create parent quote ─────────────────────────────────
    private function parent(string $part, string $status, int $qty, float $each): int
    {
        $num   = 'Q-' . str_pad($this->seq++, 6, '0', STR_PAD_LEFT);
        $cust  = $this->r($this->customers);
        $matId = $this->r($this->materials);
        $days  = rand(5, 180);
        $methods = ['manufacture_in_house', 'manufacture_in_house', 'outsource', 'hybrid'];
        $shapes  = ['round', 'square', 'hexagon', 'width_length_height'];
        $pinD  = [0.25, 0.375, 0.5, 0.625, 0.75, 1.0, 1.25, 1.5, 2.0][rand(0, 8)];
        $pinL  = [2.0, 3.0, 4.0, 6.0, 8.0, 12.0][rand(0, 5)];
        $matC  = round($pinD * $pinL * rand(8, 30) / 10, 4);

        $id = DB::table('quotes')->insertGetId([
            'company_id'           => $this->companyId,
            'parent_id'            => null,
            'tree_order'           => $this->seq,
            'customer_id'          => $cust,
            'type'                 => 'quote',
            'quote_number'         => $num,
            'status'               => $status,
            'part_number'          => strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $part), 0, 4)) . '-' . rand(1000, 9999),
            'manufacturing_method' => $methods[array_rand($methods)],
            'unit'                 => 'inch',
            'quantity'             => $qty,
            'setup_price'          => rand(50, 400),
            'quote_date'           => now()->subDays($days)->toDateString(),
            'due_date'             => now()->addDays(rand(14, 60))->toDateString(),
            'valid_until'          => now()->addDays(rand(30, 90))->toDateString(),
            'shape'                => $shapes[array_rand($shapes)],
            'material_id'          => $matId,
            'pin_diameter'         => $pinD,
            'pin_length'           => $pinL,
            'block_price'          => $matC,
            'each_pin_price'       => $matC,
            'total_pin_price'      => round($matC * $qty, 2),
            'grand_each_price'     => $each,
            'grand_total_price'    => round($each * $qty, 2),
            'created_at'           => now()->subDays($days),
            'updated_at'           => now()->subDays(rand(0, $days)),
        ]);

        $this->machines($id, rand(1, 3));
        $this->ops($id,      rand(1, 2));
        $this->holes($id,    rand(1, 3));

        return $id;
    }

    // ── Create child job order ──────────────────────────────
    private function child(
        int $parentId,
        string $desc,
        string $status,
        int $completed,
        int $order,
        int $machCount,
        int $opCount,
        int $holeCount,
        bool $withTaps = false
    ): void {
        $num    = 'JO-' . str_pad($this->seq++, 6, '0', STR_PAD_LEFT);
        $parent = DB::table('quotes')->where('id', $parentId)->first();
        $qty    = max(1, $machCount * rand(1, 3));
        $each   = round(rand(15, 300) + rand(0, 99) / 100, 2);

        $id = DB::table('quotes')->insertGetId([
            'company_id'           => $this->companyId,
            'parent_id'            => $parentId,
            'tree_order'           => $order,
            'customer_id'          => $parent->customer_id,
            'type'                 => 'job_order',
            'quote_number'         => $num,
            'status'               => $status,
            'part_number'          => ($parent->part_number ?? 'PART') . '-OP' . $order,
            'manufacturing_method' => $parent->manufacturing_method ?? 'manufacture_in_house',
            'unit'                 => 'inch',
            'quantity'             => $qty,
            'setup_price'          => rand(0, 150),
            'quote_date'           => now()->subDays(rand(1, 60))->toDateString(),
            'due_date'             => now()->addDays(rand(7, 45))->toDateString(),
            'shape'                => $parent->shape ?? 'round',
            'material_id'          => $parent->material_id,
            'pin_diameter'         => $parent->pin_diameter ?? 1.0,
            'pin_length'           => $parent->pin_length   ?? 4.0,
            'block_price'          => $parent->block_price  ?? 0,
            'each_pin_price'       => $parent->each_pin_price ?? 0,
            'total_pin_price'      => round(($parent->each_pin_price ?? 0) * $qty, 2),
            'grand_each_price'     => $each,
            'grand_total_price'    => round($each * $qty, 2),
            'created_at'           => now()->subDays(rand(0, 30)),
            'updated_at'           => now(),
        ]);

        $this->machines($id, $machCount);
        $this->ops($id,      $opCount);
        $this->holes($id,    $holeCount);
        if ($withTaps) $this->taps($id, rand(2, 4));
        if (rand(0, 2) === 0) $this->items($id, rand(1, 2));
    }

    // ── quote_machines ──────────────────────────────────────
    // Real columns: quote_id, machine_id, labour_id, model,
    //               labor_mode, material, complexity, priority,
    //               time_minutes, rate_per_hour, sub_total, sort_order
    private function machines(int $qid, int $n): void
    {
        if (!$this->machines) return;
        $modes  = ['Attended', 'Unattended', 'Semi-Attended'];
        $cmplx  = ['Simple', 'Moderate', 'Complex', 'Very Complex'];
        $prios  = ['Normal', 'Normal', 'Normal', 'Rush', 'Urgent'];
        $mats   = ['Steel', 'Aluminum', 'Stainless', 'Brass', 'Titanium'];
        $models = ['VF-2', 'ST-20', 'VMC-500', 'PUMA 2100', 'EC-400', 'TL-2'];
        for ($i = 0; $i < $n; $i++) {
            $rate = rand(55, 140) + rand(0, 99) / 100;
            $mins = rand(3, 120)  + rand(0, 9) / 10;
            DB::table('quote_machines')->insert([
                'quote_id'    => $qid,
                'machine_id'  => $this->r($this->machines),
                'labour_id'   => $this->r($this->operators),
                'model'       => $models[array_rand($models)],
                'labor_mode'  => $modes[array_rand($modes)],
                'material'    => $mats[array_rand($mats)],
                'complexity'  => $cmplx[array_rand($cmplx)],
                'priority'    => $prios[array_rand($prios)],
                'time_minutes' => $mins,
                'rate_per_hour' => $rate,
                'sub_total'   => round(($rate / 60) * $mins, 2),
                'sort_order'  => $i,
                'created_at'  => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // ── quote_operations ────────────────────────────────────
    // Real columns: quote_id, operation_id, labour_id,
    //               time_minutes, rate_per_hour, sub_total, sort_order
    private function ops(int $qid, int $n): void
    {
        if (!$this->operations) return;
        for ($i = 0; $i < $n; $i++) {
            $rate = rand(45, 125) + rand(0, 99) / 100;
            $mins = rand(5, 90)   + rand(0, 9) / 10;
            DB::table('quote_operations')->insert([
                'quote_id'     => $qid,
                'operation_id' => $this->r($this->operations),
                'labour_id'    => $this->r($this->operators),
                'time_minutes' => $mins,
                'rate_per_hour' => $rate,
                'sub_total'    => round(($rate / 60) * $mins, 2),
                'sort_order'   => $i,
                'created_at'   => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // ── quote_items ─────────────────────────────────────────
    // Real columns: quote_id, item_id, description, qty, rate, sub_total, sort_order
    private function items(int $qid, int $n): void
    {
        if (!$this->items) return;
        $descs = ['Tooling insert', 'Raw stock', 'Fastener kit', 'Seal kit', 'Bearing set'];
        for ($i = 0; $i < $n; $i++) {
            $rate = rand(2, 85) + rand(0, 99) / 100;
            $qty  = rand(1, 10);
            DB::table('quote_items')->insert([
                'quote_id'    => $qid,
                'item_id'     => $this->r($this->items),
                'description' => $descs[array_rand($descs)],
                'qty'         => $qty,
                'rate'        => $rate,
                'sub_total'   => round($rate * $qty, 2),
                'sort_order'  => $i,
                'created_at'  => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // ── quote_holes ─────────────────────────────────────────
    // Real columns: quote_id, qty, drilling_method, hole_size, hole_unit,
    //               tol_plus, tol_minus, depth_type, depth_size, hole_price,
    //               chamfer_id, chamfer_size, chamfer_price,
    //               debur_id, debur_size, debur_price, sub_total, sort_order
    private function holes(int $qid, int $n): void
    {
        $methods = ['Drill', 'Reamer', 'Boring Bar', 'Gun Drill', 'Spot Drill'];
        $sizes   = [0.0625, 0.125, 0.1875, 0.25, 0.3125, 0.375, 0.5, 0.625, 0.75, 1.0];
        for ($i = 0; $i < $n; $i++) {
            $sz     = $sizes[array_rand($sizes)];
            $qty    = rand(1, 12);
            $hPrice = round($sz * rand(8, 25) + rand(0, 99) / 100, 2);
            $chId   = count($this->chamfers) && rand(0, 1) ? $this->r($this->chamfers) : null;
            $dbId   = count($this->deburs)   && rand(0, 1) ? $this->r($this->deburs)   : null;
            $chP    = $chId ? round(rand(1, 5) + rand(0, 99) / 100, 2) : 0;
            $dbP    = $dbId ? round(rand(1, 4) + rand(0, 99) / 100, 2) : 0;
            DB::table('quote_holes')->insert([
                'quote_id'       => $qid,
                'qty'            => $qty,
                'drilling_method' => $methods[array_rand($methods)],
                'hole_size'      => $sz,
                'hole_unit'      => 'inch',
                'tol_plus'       => [0.0005, 0.001, 0.002, 0.003][rand(0, 3)],
                'tol_minus'      => [0.0005, 0.001, 0.002][rand(0, 2)],
                'depth_type'     => rand(0, 1) ? 'through' : 'other',
                'depth_size'     => round($sz * rand(2, 8), 4),
                'hole_price'     => $hPrice,
                'chamfer_id'     => $chId,
                'chamfer_size'   => $chId ? 0.5 : null,
                'chamfer_price'  => $chP,
                'debur_id'       => $dbId,
                'debur_size'     => $dbId ? 0.5 : null,
                'debur_price'    => $dbP,
                'sub_total'      => round(($hPrice + $chP + $dbP) * $qty, 2),
                'sort_order'     => $i,
                'created_at'     => now(),
                'updated_at' => now(),
            ]);
        }
    }

    // ── quote_taps ──────────────────────────────────────────
    // Real columns: quote_id, tap_id, tap_price, thread_option, option_price,
    //               direction, thread_size, base_price,
    //               chamfer_id, chamfer_size, chamfer_price,
    //               debur_id, debur_size, debur_price, sub_total, sort_order
    private function taps(int $qid, int $n): void
    {
        if (!$this->taps) return;
        $opts  = ['Through', 'Blind', 'Bottoming'];
        $sizes = ['M4×0.7', 'M5×0.8', 'M6×1.0', 'M8×1.25', 'M10×1.5', '1/4-20', '5/16-18', '3/8-16', '1/2-13'];
        for ($i = 0; $i < $n; $i++) {
            $tapP  = round(rand(2, 12) + rand(0, 99) / 100, 2);
            $optP  = round(rand(1, 5) + rand(0, 99) / 100, 2);
            $chId  = count($this->chamfers) && rand(0, 1) ? $this->r($this->chamfers) : null;
            $dbId  = count($this->deburs)   && rand(0, 1) ? $this->r($this->deburs)   : null;
            $chP   = $chId ? round(rand(1, 4) + rand(0, 99) / 100, 2) : 0;
            $dbP   = $dbId ? round(rand(1, 3) + rand(0, 99) / 100, 2) : 0;
            DB::table('quote_taps')->insert([
                'quote_id'      => $qid,
                'tap_id'        => $this->r($this->taps),
                'tap_price'     => $tapP,
                'thread_option' => $opts[array_rand($opts)],
                'option_price'  => $optP,
                'direction'     => rand(0, 1) ? 'right' : 'left',
                'thread_size'   => $sizes[array_rand($sizes)],
                'base_price'    => $tapP,
                'chamfer_id'    => $chId,
                'chamfer_size'  => $chId ? 0.5 : null,
                'chamfer_price' => $chP,
                'debur_id'      => $dbId,
                'debur_size'    => $dbId ? 0.5 : null,
                'debur_price'   => $dbP,
                'sub_total'     => round($tapP + $optP + $chP + $dbP, 2),
                'sort_order'    => $i,
                'created_at'    => now(),
                'updated_at' => now(),
            ]);
        }
    }

    private function r(array $arr): mixed
    {
        return empty($arr) ? null : $arr[array_rand($arr)];
    }
}
