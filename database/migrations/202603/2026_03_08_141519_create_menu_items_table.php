<?php

use App\Models\MenuCategory;
use App\Models\Restaurant;
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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("code", 12)->nullable();
            $table->string("name", 40);
            $table->string("description", 250);
            $table->float("price", 2);
            $table->string("image")->nullable();
            $table->foreignIdFor(Restaurant::class, "restaurant_id")->constrained();
            $table->foreignIdFor(MenuCategory::class, "category_id")->constrained();
            $table->boolean("is_active")->default(true);
            $table->boolean('enable_technical_sheet');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
