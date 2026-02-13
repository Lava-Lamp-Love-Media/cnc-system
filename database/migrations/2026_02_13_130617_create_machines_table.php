<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('machine_code')->unique(); // e.g., CNC-001, LATHE-002
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->year('year_of_manufacture')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 12, 2)->nullable();
            $table->enum('status', ['active', 'maintenance', 'inactive', 'broken'])->default('active');
            $table->text('description')->nullable();
            $table->text('specifications')->nullable(); // JSON field for detailed specs
            $table->string('location')->nullable(); // Shop floor location
            $table->integer('operating_hours')->default(0); // Total operating hours
            $table->date('last_maintenance_date')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->string('image')->nullable(); // Machine photo
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index('company_id');
            $table->index('machine_code');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('machines');
    }
};
