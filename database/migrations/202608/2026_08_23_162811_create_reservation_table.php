<?php

use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use App\Modules\Reservation\Enums\ReservationStatusEnum;
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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('customer');
            $table->string('state_registration')->nullable();
            $table->string("phone", 20)->nullable();
            $table->string("email", 60)->nullable();
            $table->date('date');
            $table->time('hour');
            $table->integer('quantity_of_person');
            $table->text('observation')->nullable();
            $table->foreignIdFor(Table::class)->constrained();
            $table->foreignIdFor(Restaurant::class)->constrained();
            $table->foreignIdFor(User::class,'created_by')->constrained();
            $table->foreignIdFor(User::class, 'waiter_id')->nullable()->constrained();
            $table->time('duration')->nullable();
            $table->enum('status', array_column(ReservationStatusEnum::cases(), 'value'))->default(ReservationStatusEnum::PENDING->value);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
