<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('trial_requests', function (Blueprint $table) {
            $table->id();

            $table->string('company_name');
            $table->string('company_email');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('phone')->nullable();

            // preferred plan (optional) - we will map slug to plans table on approve
            $table->string('preferred_plan_slug')->nullable(); // basic / pro / enterprise

            $table->text('message')->nullable();

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            // after approve
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('approved_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trial_requests');
    }
};
