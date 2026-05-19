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
        Schema::table('stock_movments', function (Blueprint $table) {
            $table->string("description")->nullable()->after("created_by");
            $table->integer("reference_id")->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_movments', function (Blueprint $table) {
            $table->dropColumn("description");
            $table->integer("reference_id")->nullable(false)->change();
        });
    }
};
