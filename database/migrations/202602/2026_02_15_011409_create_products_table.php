<?php

use App\Models\ProductCategory;
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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("sku")->nullable();
            $table->string("name", 60);
            $table->string("description", 160)->nullable();
            $table->foreignIdFor(Restaurant::class, "restaurant_id")->constrained();
            $table->foreignIdFor(ProductCategory::class, "category_id")->constrained();
            $table->string("cost")->nullable();
            $table->integer("unit_contain")->nullable();
            $table->integer("min_quantity")->nullable();
            $table->float("current_stock", 2)->nullable();
            $table->float("loss_percentage", 2)->nullable();
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
