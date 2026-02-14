<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->morphs('addressable'); // addressable_type & addressable_id
            $table->enum('address_type', ['billing', 'shipping', 'warehouse', 'office'])->default('billing');
            $table->boolean('is_default')->default(false);
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('address_line_1');
            $table->string('address_line_2')->nullable();
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->default('USA');
            $table->text('notes')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['addressable_type', 'addressable_id']);
            $table->index('address_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
