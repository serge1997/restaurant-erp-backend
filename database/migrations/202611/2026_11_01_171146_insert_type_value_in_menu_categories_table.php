<?php

use App\Modules\MenuCategory\Enums\MenuCategoryTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table("menu_categories")->whereIn("name", [
            "Entradas", "Pratos principais", "Sobremesas",
            "Fast Food", "Sopas", "Frituras", "Oriental", "Carnes",
            "Peixes", "Frutos de mar", "Massas", "Brasileiro", "Ocidental",
            "Africana", "Hambúrguer", "Acompanhamentos"
        ])->update([
            "type"  => MenuCategoryTypeEnum::FOOD->value
        ]);

        DB::table("menu_categories")->whereIn("name", [
            "Coqueteis", "Sucos", "Vinhos", "Espumantes",
            "Vodka", "Rhum", "Whysky", "Cachaça", "Bourbon",
            "Saké", "Refrigerentes", "Cervejas"
        ])->update([
            "type"  => MenuCategoryTypeEnum::BEVERAGE->value
        ]);
    }
};
