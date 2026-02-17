<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_order_id')->constrained()->onDelete('cascade');
            $table->foreignId('item_id')->constrained()->onDelete('cascade');
            $table->string('item_sku');
            $table->integer('count_of')->default(1);
            $table->enum('unit', ['each', 'kg', 'lb', 'meter', 'foot', 'liter', 'gallon'])->default('each');
            $table->decimal('count_price', 10, 2)->default(0);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->integer('quantity');
            $table->text('notes')->nullable();
            $table->enum('discount_type', ['flat', 'percentage'])->default('flat');
            $table->decimal('discount', 10, 2)->default(0);
            $table->boolean('taxable')->default(true);
            $table->decimal('total', 10, 2)->default(0);
            $table->boolean('inventory')->default(true);
            $table->string('receiving_status')->nullable();
            $table->string('commodity_class')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_order_items');
    }
};
