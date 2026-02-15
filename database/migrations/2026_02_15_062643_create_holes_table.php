<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('holes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('hole_code', 50)->unique();
            $table->string('name'); // "Ø5.0mm Through Hole"
            $table->decimal('size', 10, 3); // Diameter in mm
            $table->enum('hole_type', ['through', 'blind', 'countersink', 'counterbore'])->default('through');
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
        Schema::dropIfExists('holes');
    }
};
