<?php

use App\Modules\ProductCategory\Enums\ProductUnitMeasureEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('product_categories')->insert([
            [
                'name' => 'Secos / Grãos',
                'unit_measure' => ProductUnitMeasureEnum::GRAM->value,
                'is_active' => true
            ]]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table("product_categories")
            ->where([
                ["name", "Secos / Grãos"],
                ['unit_measure', ProductUnitMeasureEnum::GRAM->value]
            ])->delete();
    }
};
