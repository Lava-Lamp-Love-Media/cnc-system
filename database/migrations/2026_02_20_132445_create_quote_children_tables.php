<?php
// ══════════════════════════════════════════════════════
// 2026_02_20_000002_create_quote_children_tables.php
// All 6 child tables in one migration
// ══════════════════════════════════════════════════════

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Quote Machines ──────────────────────────────
        Schema::create('quote_machines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');
            $table->unsignedBigInteger('machine_id')->nullable();
            $table->unsignedBigInteger('labour_id')->nullable();
            $table->string('model', 100)->nullable();
            $table->enum('labor_mode', ['Attended', 'Unattended', 'Semi-Attended'])->default('Attended');
            $table->string('material', 50)->nullable();
            $table->enum('complexity', ['Simple', 'Moderate', 'Complex', 'Very Complex'])->default('Simple');
            $table->enum('priority', ['Normal', 'Rush', 'Urgent'])->default('Normal');
            $table->decimal('time_minutes', 10, 2)->default(0);
            $table->decimal('rate_per_hour', 10, 2)->default(0);
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index('quote_id');
        });

        // ── 2. Quote Operations ────────────────────────────
        Schema::create('quote_operations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');
            $table->unsignedBigInteger('operation_id')->nullable();
            $table->unsignedBigInteger('labour_id')->nullable();
            $table->decimal('time_minutes', 10, 2)->default(0);
            $table->decimal('rate_per_hour', 10, 2)->default(0);
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index('quote_id');
        });

        // ── 3. Quote Items ─────────────────────────────────
        Schema::create('quote_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('qty')->default(1);
            $table->decimal('rate', 10, 2)->default(0);
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index('quote_id');
        });

        // ── 4. Quote Holes ─────────────────────────────────
        Schema::create('quote_holes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');
            $table->unsignedInteger('qty')->default(1);
            $table->string('drilling_method', 50)->nullable();
            $table->decimal('hole_size', 10, 4)->nullable();
            $table->string('hole_unit', 10)->default('mm');
            $table->decimal('tol_plus', 10, 4)->default(0.005);
            $table->decimal('tol_minus', 10, 4)->default(0.005);
            $table->enum('depth_type', ['through', 'other'])->default('through');
            $table->decimal('depth_size', 10, 4)->nullable();
            $table->decimal('hole_price', 10, 2)->default(0);
            $table->unsignedBigInteger('chamfer_id')->nullable();
            $table->decimal('chamfer_size', 10, 4)->nullable();
            $table->decimal('chamfer_price', 10, 2)->default(0);
            $table->unsignedBigInteger('debur_id')->nullable();
            $table->decimal('debur_size', 10, 4)->nullable();
            $table->decimal('debur_price', 10, 2)->default(0);
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index('quote_id');
        });

        // ── 5. Quote Taps ──────────────────────────────────
        Schema::create('quote_taps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');
            $table->unsignedBigInteger('tap_id')->nullable();
            $table->decimal('tap_price', 10, 2)->default(0);
            $table->string('thread_option', 50)->nullable();
            $table->decimal('option_price', 10, 2)->default(0);
            $table->enum('direction', ['right', 'left'])->default('right');
            $table->string('thread_size', 50)->nullable();
            $table->decimal('base_price', 10, 2)->default(0);
            $table->unsignedBigInteger('chamfer_id')->nullable();
            $table->decimal('chamfer_size', 10, 4)->nullable();
            $table->decimal('chamfer_price', 10, 2)->default(0);
            $table->unsignedBigInteger('debur_id')->nullable();
            $table->decimal('debur_size', 10, 4)->nullable();
            $table->decimal('debur_price', 10, 2)->default(0);
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index('quote_id');
        });

        // ── 6. Quote Threads ───────────────────────────────
        Schema::create('quote_threads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');
            $table->unsignedBigInteger('thread_id')->nullable();
            $table->decimal('thread_price', 10, 2)->default(0);
            $table->string('option', 100)->nullable();
            $table->decimal('option_price', 10, 2)->default(0);
            $table->enum('direction', ['right', 'left'])->default('right');
            $table->string('thread_size', 50)->nullable();
            $table->decimal('size_price', 10, 2)->default(0);
            $table->string('standard', 50)->nullable();
            $table->string('pitch', 20)->nullable();
            $table->decimal('pitch_price', 10, 2)->default(0);
            $table->string('class', 20)->nullable();
            $table->decimal('class_price', 10, 2)->default(0);
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index('quote_id');
        });

        // ── 7. Quote Secondary Operations ─────────────────
        Schema::create('quote_secondary_ops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('name', 150);
            $table->enum('price_type', ['lot', 'per_piece', 'per_pound'])->default('lot');
            $table->unsignedInteger('qty')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('sub_total', 10, 2)->default(0);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->index('quote_id');
        });

        // ── 8. Quote Attachments ───────────────────────────
        Schema::create('quote_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quote_id');
            $table->foreign('quote_id')->references('id')->on('quotes')->onDelete('cascade');
            $table->string('original_name', 255);
            $table->string('stored_name', 255);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('file_size')->default(0);
            $table->string('disk', 20)->default('local');
            $table->string('path', 500);
            $table->timestamps();
            $table->index('quote_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quote_attachments');
        Schema::dropIfExists('quote_secondary_ops');
        Schema::dropIfExists('quote_threads');
        Schema::dropIfExists('quote_taps');
        Schema::dropIfExists('quote_holes');
        Schema::dropIfExists('quote_items');
        Schema::dropIfExists('quote_operations');
        Schema::dropIfExists('quote_machines');
    }
};
