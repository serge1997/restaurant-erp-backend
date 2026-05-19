<?php

use App\Models\Product;
use App\Models\PurchaseRequisition;
use App\Models\Supplier;
use App\Modules\ProductCategory\Enums\ProductUnitMeasureEnum;
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
        Schema::create('purchase_requisition_items', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignIdFor(PurchaseRequisition::class, "purchase_requisition_id");
            $table->foreignIdFor(Product::class, "product_id")->constrained();
            $table->foreignIdFor(Supplier::class, "supplier_id")->nullable();
            $table->integer("ordered_quantity")->unsigned();
            $table->integer("received_quantity")->nullable()->unsigned();
            $table->float("cost")->nullable();
            $table->float("total_cost", 2)->nullable();
            $table->integer("unit_size");
            $table->enum("unit_of_measure", array_column(ProductUnitMeasureEnum::cases(), "value"));
            $table->boolean("approved")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisition_items');
    }
};
