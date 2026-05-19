<?php

use App\Models\Restaurant;
use App\Modules\PurchaseRequisition\Enums\PurchasePriorityEnum;
use App\Modules\PurchaseRequisition\Enums\PurchaseRequisitionStatusEnum;
use App\Modules\Restaurant\Enums\DepartmentEnum;
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
        Schema::create('purchase_requisitions', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("code", 7)->nullable();
            $table->foreignIdFor(Restaurant::class, "restaurant_id")->constrained();
            $table->integer("author_id")->unsigned()->nullable();
            $table->enum("department", array_column(DepartmentEnum::cases(), "value"))->default(DepartmentEnum::ALL->value);
            $table->date("expected_delivery_date")->nullable();
            $table->integer("approved_by")->unsigned()->nullable();
            $table->date("approved_at")->nullable();
            $table->string("observation", 255)->nullable();
            $table->enum("status", array_column(PurchaseRequisitionStatusEnum::cases(), "value"))->default(PurchaseRequisitionStatusEnum::DRAFT->value);
            $table->enum("priority", array_column(PurchasePriorityEnum::cases(), 'value'))->default(PurchasePriorityEnum::NORMAL->value);
            $table->date("delivery_at")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requisitions');
    }
};
