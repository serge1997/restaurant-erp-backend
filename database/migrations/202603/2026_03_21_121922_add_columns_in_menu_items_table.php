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
        Schema::table('menu_items', function (Blueprint $table) {
            $table->time("cooking_time")->nullable();
            $table->smallInteger("for_quantity_of_person")->nullable();
            $table->float("promotional_price", 2)->nullable();
            $table->string("featured_types")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropColumn(["cooking_time", "for_quantity_of_person", "promotional_price", "featured_types"]);
        });
    }
};
