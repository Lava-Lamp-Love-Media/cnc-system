<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('thread_code', 50)->unique();
            $table->string('name'); // "M10×1.5 External Thread"

            // Thread Type
            $table->enum('thread_type', ['external', 'internal'])->default('external');

            // Thread Specifications
            $table->decimal('diameter', 10, 3); // Major diameter in mm
            $table->decimal('pitch', 10, 3); // Thread pitch in mm
            $table->string('thread_standard')->default('metric'); // metric, UNC, UNF, etc.
            $table->string('thread_class')->nullable(); // 6g, 2A, etc.
            $table->enum('direction', ['right', 'left'])->default('right');

            // Thread Size Options (JSON for flexibility)
            $table->json('thread_sizes')->nullable(); // ["M10×1.5", "M10×1.25"]
            $table->json('thread_options')->nullable(); // Special options

            // Pricing
            $table->decimal('thread_price', 10, 2)->default(0);
            $table->decimal('option_price', 10, 2)->default(0);
            $table->decimal('pitch_price', 10, 2)->default(0);
            $table->decimal('class_price', 10, 2)->default(0);
            $table->decimal('size_price', 10, 2)->default(0);

            $table->text('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['company_id', 'status']);
            $table->index(['company_id', 'thread_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('threads');
    }
};
