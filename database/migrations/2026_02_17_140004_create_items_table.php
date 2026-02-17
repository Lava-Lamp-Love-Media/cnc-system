<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('sku')->unique();
            $table->enum('class', ['tooling', 'sellable', 'raw_stock', 'consommable']);
            $table->enum('unit', ['each', 'kg', 'lb', 'meter', 'foot', 'liter', 'gallon'])->default('each');
            $table->integer('count')->default(0);
            $table->decimal('cost_price', 10, 2)->default(0);
            $table->decimal('sell_price', 10, 2)->default(0);
            $table->integer('stock_min')->default(0);
            $table->integer('reorder_level')->default(0);
            $table->integer('current_stock')->default(0);
            $table->foreignId('warehouse_id')->nullable()->constrained()->onDelete('set null');
            $table->string('image')->nullable();
            $table->boolean('is_inventory')->default(true);
            $table->boolean('is_taxable')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
