<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('milk_delivery', function (Blueprint $table) {
            $table->decimal('total_rate', 10, 2)->after('rate');
            $table->decimal('weight', 8, 2)->change();
            $table->decimal('rate', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('milk_delivery', function (Blueprint $table) {
            $table->dropColumn('total_rate');
            $table->string('weight')->change();
            $table->string('rate')->change();
        });
    }
};
