<?php

use App\Models\Restaurant;
use App\Models\Room;
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
        Schema::create('tables', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name", 15);
            $table->smallInteger("number");
            $table->smallInteger("capacity");
            $table->string("shape", 60)->nullable();
            $table->foreignIdFor(Room::class, "room_id")->constrained();
            $table->foreignIdFor(Restaurant::class, "restaurant_id")->constrained();
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tables');
    }
};
