<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('material_code', 50)->unique();
            $table->string('name');
            $table->enum('type', ['metal_alloy', 'plastic', 'composite', 'other'])->default('metal_alloy');
            $table->enum('unit', ['mm', 'inch'])->default('mm');
            $table->decimal('diameter_from', 10, 5)->default(0);
            $table->decimal('diameter_to',   10, 5)->default(0);
            $table->decimal('price',         10, 4)->default(0);
            $table->decimal('adj',           10, 4)->default(0);
            $table->enum('adj_type', ['amount', 'percent'])->default('amount');
            $table->decimal('real_price',    10, 4)->default(0);
            $table->decimal('density',       10, 2)->default(0);
            $table->string('code', 20)->nullable();
            $table->text('notes')->nullable();
            $table->integer('sort_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
