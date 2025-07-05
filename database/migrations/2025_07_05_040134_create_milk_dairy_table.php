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
        Schema::create('milk_dairy', function (Blueprint $table) {
            $table->id();
            $table->string('customer_no_in_dairy');
            $table->enum('shift', ['morning', 'evening']);
            $table->decimal('milk_weight', 8, 2);
            $table->decimal('fat_in_percentage', 5, 2);
            $table->decimal('rate_per_liter', 8, 2);
            $table->decimal('amount', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_dairy');
    }
};
