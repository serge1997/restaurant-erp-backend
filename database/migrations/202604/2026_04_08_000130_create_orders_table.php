<?php

use App\Modules\Order\Enums\OrderStatusEnum;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignIdFor(\App\Models\Restaurant::class, 'restaurant_id')->constrained();
            $table->foreignIdFor(\App\Models\User::class, 'waiter_id')->constrained();
            $table->foreignIdFor(\App\Models\Table::class, 'table_id')->constrained();
            $table->enum('status', array_column(OrderStatusEnum::cases(), 'value'))->default(OrderStatusEnum::OPEN->value);
            $table->string('customer_name')->nullable();
            $table->enum('payment_status', array_column(\App\Modules\Payment\Enums\PaymentStatusEnum::cases(), 'value'))->default(\App\Modules\Payment\Enums\PaymentStatusEnum::PENDING->value);
            $table->enum('payment_method', array_column(\App\Modules\Payment\Enums\PaymentMethodEnum::cases(), 'value'))->nullable();
            $table->text('observation')->nullable();
            $table->unsignedBigInteger('fiscal_document_id')->nullable();
            $table->smallInteger('fiscal_status')->nullable();
            $table->unsignedBigInteger('parent_order_id')->nullable();
            $table->string('transfert_reason')->nullable();
            $table->timestamp('close_at')->nullable();
            $table->date('business_day');
            $table->foreignIdFor(\App\Models\User::class, 'created_by')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
