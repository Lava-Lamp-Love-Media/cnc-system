<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('taps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('tap_code', 50)->unique();
            $table->string('name'); // "M8×1.25 Plug Tap"

            // Thread Specifications
            $table->decimal('diameter', 10, 3); // Major diameter in mm
            $table->decimal('pitch', 10, 3); // Thread pitch in mm
            $table->string('thread_standard')->default('metric'); // metric, UNC, UNF, etc.
            $table->string('thread_class')->nullable(); // 2B, 6H, etc.
            $table->enum('direction', ['right', 'left'])->default('right');

            // Thread Size Options (JSON for flexibility)
            $table->json('thread_sizes')->nullable(); // ["0-80", "2-56", "4-40"]
            $table->json('thread_options')->nullable(); // ["internal", "external"]

            // Pricing
            $table->decimal('tap_price', 10, 2)->default(0);
            $table->decimal('thread_option_price', 10, 2)->default(0);
            $table->decimal('pitch_price', 10, 2)->default(0);
            $table->decimal('class_price', 10, 2)->default(0);
            $table->decimal('size_price', 10, 2)->default(0);

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
        Schema::dropIfExists('taps');
    }
};
