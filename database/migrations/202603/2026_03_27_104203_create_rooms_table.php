<?php

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
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name", 30);
            $table->string("description", 160)->nullable();
            $table->smallInteger("capacity");
            $table->string("severity", 10);
            $table->string("icon", 60);
            $table->boolean("is_active")->default(true);
            $table->unsignedSmallInteger("room_type_id");
            $table->foreign("room_type_id")
                ->references("id")
                ->on("room_types");
            $table->foreignIdFor(Restaurant::class, "restaurant_id")->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
