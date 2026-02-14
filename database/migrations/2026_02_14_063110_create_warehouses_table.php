<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('warehouse_code')->unique(); // WH-001
            $table->string('name');
            $table->string('location')->nullable(); // Physical location/address
            $table->string('manager_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->decimal('storage_capacity', 10, 2)->nullable(); // In square meters or cubic meters
            $table->string('capacity_unit')->default('sqm'); // sqm, cbm
            $table->enum('warehouse_type', ['main', 'secondary', 'raw_material', 'finished_goods', 'tools'])->default('main');
            $table->enum('status', ['active', 'inactive', 'maintenance'])->default('active');
            $table->text('description')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->default('USA');
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('company_id');
            $table->index('warehouse_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};
