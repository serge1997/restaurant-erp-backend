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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name", 60);
            $table->string("email", 40)->nullable();
            $table->string("phone", 20);
            $table->foreignIdFor(Restaurant::class, 'restaurant_id')->constrained();
            $table->string("address", 100)->nullable();
            $table->string("number", 10)->nullable();
            $table->boolean("is_active")->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
