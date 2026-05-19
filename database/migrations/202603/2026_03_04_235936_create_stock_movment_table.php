<?php

use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Supplier;
use App\Modules\StockMovment\Enums\StockMovmentDirectionEnum;
use App\Modules\StockMovment\Enums\StockMovmentReferenceTypeEnum;
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
        Schema::create('stock_movments', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignIdFor(Restaurant::class, "restaurant_id")->constrained();
            $table->foreignIdFor(Product::class, "product_id")->constrained();
            $table->foreignIdFor(Supplier::class, "supplier_id")->nullable();
            $table->integer("quantity");
            $table->enum("direction", array_column(StockMovmentDirectionEnum::cases(), 'value'));
            $table->enum("reference_type", array_column(StockMovmentReferenceTypeEnum::cases(), "value"));
            $table->integer("reference_id");
            $table->date('moved_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movments');
    }
};
