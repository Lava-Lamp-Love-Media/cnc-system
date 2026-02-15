<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chamfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('chamfer_code', 50)->unique();
            $table->string('name'); // "0.5mm × 45°"
            $table->decimal('size', 10, 3); // Width in mm
            $table->decimal('angle', 5, 2)->nullable(); // Angle in degrees
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['company_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chamfers');
    }
};
