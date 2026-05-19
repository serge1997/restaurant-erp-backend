<?php

use App\Modules\ProductCategory\Enums\ProductUnitMeasureEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('product_categories')->insert([
            [
                'name' => 'Aguas',
                'unit_measure' => ProductUnitMeasureEnum::UNIT->value,
                'is_active' => true
            ],
            [
                'name' => 'Carnes',
                'unit_measure' => ProductUnitMeasureEnum::GRAM->value,
                'is_active' => true
            ],
            [
                'name' => 'Peixes',
                'unit_measure' => ProductUnitMeasureEnum::GRAM->value,
                'is_active' => true
            ],
            [
                'name' => 'Legumes',
                'unit_measure' => ProductUnitMeasureEnum::GRAM->value,
                'is_active' => true
            ],
            [
                'name' => 'Frutas',
                'unit_measure' => ProductUnitMeasureEnum::GRAM->value,
                'is_active' => true
            ],
            [
                'name' => 'Molhos',
                'unit_measure' => ProductUnitMeasureEnum::ML->value,
                'is_active' => true
            ],
            [
                'name' => 'Pastas',
                'unit_measure' => ProductUnitMeasureEnum::GRAM->value,
                'is_active' => true
            ],
            [
                'name' => 'Vodka',
                'unit_measure' => ProductUnitMeasureEnum::ML->value,
                'is_active' => true
            ],
            [
                'name' => 'Whisky',
                'unit_measure' => ProductUnitMeasureEnum::ML->value,
                'is_active' => true
            ],
            [
                'name' => 'Rhum',
                'unit_measure' => ProductUnitMeasureEnum::ML->value,
                'is_active' => true
            ],
            [
                'name' => 'Licor',
                'unit_measure' => ProductUnitMeasureEnum::ML->value,
                'is_active' => true
            ],
            [
                'name' => 'Temperos',
                'unit_measure' => ProductUnitMeasureEnum::GRAM->value,
                'is_active' => true
            ],
            [
                'name' => 'Cervejas',
                'unit_measure' => ProductUnitMeasureEnum::UNIT->value,
                'is_active' => true
            ],
            [
                'name' => 'Sucos',
                'unit_measure' => ProductUnitMeasureEnum::UNIT->value,
                'is_active' => true
            ],
            [
                'name' => 'Vinhos',
                'unit_measure' => ProductUnitMeasureEnum::ML->value,
                'is_active' => true
            ],
            [
                'name' => 'Espumantes',
                'unit_measure' => ProductUnitMeasureEnum::ML->value,
                'is_active' => true
            ],
            [
                'name' => 'Refrigerantes',
                'unit_measure' => ProductUnitMeasureEnum::UNIT->value,
                'is_active' => true
            ],
            [
                'name' => 'Cafés',
                'unit_measure' => ProductUnitMeasureEnum::UNIT->value,
                'is_active' => true
            ],
            [
                'name' => 'Chás',
                'unit_measure' => ProductUnitMeasureEnum::UNIT->value,
                'is_active' => true
            ],
            [
                'name' => 'Energéticos',
                'unit_measure' => ProductUnitMeasureEnum::UNIT->value,
                'is_active' => true
            ],
            [
                'name' => 'Chope (Baril)',
                'unit_measure' => ProductUnitMeasureEnum::ML->value,
                'is_active' => true
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table("product_categories")->delete();
    }
};
