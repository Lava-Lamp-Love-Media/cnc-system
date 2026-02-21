<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');

            // ── Header ──
            $table->enum('type', ['quote', 'job_order', 'invoice'])->default('quote');
            $table->string('quote_number', 50)->unique();
            $table->enum('manufacturing_method', ['manufacture_in_house', 'outsource', 'hybrid'])->default('manufacture_in_house');
            $table->enum('unit', ['inch', 'mm'])->default('inch');
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('setup_price', 10, 2)->default(0);
            $table->date('quote_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('valid_until')->nullable();
            $table->string('part_number', 100)->nullable();
            $table->string('cage_number', 50)->nullable();
            $table->string('po_number', 100)->nullable();

            // ── Customer ──
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->boolean('is_temp_customer')->default(false);
            $table->string('temp_customer_name', 150)->nullable();
            $table->string('temp_customer_email', 150)->nullable();
            $table->string('temp_customer_phone', 50)->nullable();
            $table->text('ship_to')->nullable();
            $table->text('bill_to')->nullable();

            // ── Shape & Material ──
            $table->enum('shape', ['round', 'square', 'hexagon', 'width_length_height'])->default('round');
            $table->decimal('pin_diameter', 12, 4)->default(0);
            $table->decimal('diameter_adjustment', 12, 4)->default(0);
            $table->decimal('pin_length', 12, 4)->default(0);
            $table->string('material_type', 50)->nullable();
            $table->unsignedBigInteger('material_id')->nullable();
            $table->decimal('block_price', 12, 4)->default(0);
            $table->decimal('metal_adjustment', 12, 4)->default(0);
            $table->decimal('metal_real_price', 12, 4)->default(0);

            // W×L×H shape fields
            $table->decimal('width', 12, 4)->nullable();
            $table->decimal('length', 12, 4)->nullable();
            $table->decimal('height', 12, 4)->nullable();

            // Calculated volumes & weights
            $table->decimal('cubic_inch_volume', 14, 4)->default(0);
            $table->decimal('cubic_mm_volume', 14, 2)->default(0);
            $table->decimal('weight_lb', 12, 4)->default(0);
            $table->decimal('weight_kg', 12, 4)->default(0);
            $table->decimal('each_pin_price', 12, 4)->default(0);
            $table->decimal('total_pin_price', 12, 2)->default(0);
            $table->decimal('calc_weight_kg', 12, 4)->default(0);
            $table->decimal('calc_weight_lbs', 12, 4)->default(0);
            $table->decimal('total_weight_kg', 12, 4)->default(0);
            $table->decimal('total_weight_lb', 12, 4)->default(0);

            // ── Plating ──
            $table->unsignedBigInteger('plating_vendor_id')->nullable();
            $table->string('plating_type', 100)->nullable();
            $table->enum('plating_pricing_type', ['per_each', 'per_pound'])->default('per_each');
            $table->unsignedInteger('plating_count')->default(0);
            $table->decimal('plating_price_each', 10, 2)->default(0);
            $table->decimal('plating_total_pounds', 10, 2)->default(0);
            $table->decimal('plating_lot_charge', 10, 2)->default(0);
            $table->decimal('plating_per_pound', 10, 4)->default(0);
            $table->decimal('plating_salt_testing', 10, 2)->default(0);
            $table->decimal('plating_surcharge', 10, 2)->default(0);
            $table->decimal('plating_standards_price', 10, 2)->default(0);
            $table->decimal('plating_total', 10, 2)->default(0);

            // ── Heat Treatment ──
            $table->unsignedBigInteger('heat_vendor_id')->nullable();
            $table->string('heat_type', 100)->nullable();
            $table->enum('heat_pricing_type', ['per_each', 'per_pound'])->default('per_each');
            $table->unsignedInteger('heat_count')->default(0);
            $table->decimal('heat_price_each', 10, 2)->default(0);
            $table->decimal('heat_total_pounds', 10, 2)->default(0);
            $table->decimal('heat_lot_charge', 10, 2)->default(0);
            $table->decimal('heat_per_pound', 10, 4)->default(0);
            $table->decimal('heat_testing', 10, 2)->default(0);
            $table->decimal('heat_surcharge', 10, 2)->default(0);
            $table->decimal('heat_total', 10, 2)->default(0);

            // ── Final Pricing ──
            $table->decimal('break_in_charge', 10, 2)->default(0);
            $table->decimal('override_price', 10, 2)->default(0);
            $table->decimal('grand_each_price', 10, 2)->default(0);
            $table->decimal('grand_total_price', 10, 2)->default(0);
            $table->text('engineer_notes')->nullable();

            // ── Status ──
            $table->enum('status', ['draft', 'sent', 'approved', 'rejected', 'converted', 'cancelled'])->default('draft');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'type']);
            $table->index('quote_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};
