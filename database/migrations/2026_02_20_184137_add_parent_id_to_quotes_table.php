<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            if (!Schema::hasColumn('quotes', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')
                    ->nullable()
                    ->default(null)
                    ->after('id');

                $table->foreign('parent_id')
                    ->references('id')
                    ->on('quotes')
                    ->onDelete('set null');
            }

            if (!Schema::hasColumn('quotes', 'tree_order')) {
                $table->integer('tree_order')->default(0)->after('parent_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            if (Schema::hasColumn('quotes', 'parent_id')) {
                $table->dropForeign(['parent_id']);
                $table->dropColumn('parent_id');
            }
            if (Schema::hasColumn('quotes', 'tree_order')) {
                $table->dropColumn('tree_order');
            }
        });
    }
};
