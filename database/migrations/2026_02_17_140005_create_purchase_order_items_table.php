<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('vendor_id')->constrained()->onDelete('cascade');
            $table->string('po_number')->unique();
            $table->enum('type', ['draft', 'first_article', 'production'])->default('draft');
            $table->date('order_date');
            $table->date('expected_received_date')->nullable();
            $table->string('payment_terms')->nullable();
            $table->text('ship_to')->nullable();
            $table->foreignId('warehouse_id')->nullable()->constrained()->onDelete('set null');
            $table->string('cage_number')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->enum('discount_type', ['flat', 'percentage'])->default('flat');
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('grand_total', 12, 2)->default(0);
            $table->text('description')->nullable();
            $table->text('additional_notes')->nullable();
            $table->string('current_stock_level')->nullable();
            $table->string('purchase_level')->nullable();
            $table->enum('status', ['draft', 'pending', 'approved', 'received', 'cancelled'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
