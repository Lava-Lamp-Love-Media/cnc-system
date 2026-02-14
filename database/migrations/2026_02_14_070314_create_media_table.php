<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->morphs('mediable'); // mediable_type & mediable_id
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_type'); // image, pdf, document
            $table->string('mime_type');
            $table->bigInteger('file_size'); // in bytes
            $table->enum('category', [
                'logo',
                'profile',
                'contract',
                'certificate',
                'invoice',
                'tax_document',
                'product_image',
                'other'
            ])->default('other');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->integer('order')->default(0);
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['mediable_type', 'mediable_id']);
            $table->index('category');
            $table->index('file_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
