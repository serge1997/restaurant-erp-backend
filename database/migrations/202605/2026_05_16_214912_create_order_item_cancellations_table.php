<?php

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Modules\Order\Enums\OrderCancelItemReasonEnum;
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
        Schema::create('order_item_cancellations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(OrderItem::class, 'order_item_id')->constrained();
            $table->foreignIdFor(Order::class, 'order_id')->constrained();
            $table->foreignIdFor(User::class, "cancelled_by")->constrained();
            $table->integer("quantity");
            $table->enum("reason", array_column(OrderCancelItemReasonEnum::cases(), 'value'));
            $table->string("observation", 255)->nullable();
            $table->boolean("restock")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_cancellations');
    }
};
