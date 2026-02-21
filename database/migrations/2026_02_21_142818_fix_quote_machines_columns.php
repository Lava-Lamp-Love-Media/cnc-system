<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('quote_machines', function (Blueprint $table) {
            if (!Schema::hasColumn('quote_machines', 'machine_model'))
                $table->string('machine_model')->nullable()->after('machine_id');
            if (!Schema::hasColumn('quote_machines', 'utilization'))
                $table->enum('utilization', ['Low', 'Medium', 'High', 'Full'])->default('Medium')->after('labor_mode');
            if (!Schema::hasColumn('quote_machines', 'material'))
                $table->string('material')->nullable()->after('utilization');
        });
    }
    public function down(): void
    {
        Schema::table('quote_machines', function (Blueprint $table) {
            $table->dropColumn(array_filter(
                ['machine_model', 'utilization', 'material'],
                fn($c) => Schema::hasColumn('quote_machines', $c)
            ));
        });
    }
};
