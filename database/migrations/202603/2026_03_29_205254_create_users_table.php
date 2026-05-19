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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->foreignIdFor(Restaurant::class, 'restaurant_id')->constrained();
            $table->string('name');
            $table->string('username');
            $table->string('email')->unique()->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('cpf', 14)->nullable();
            $table->string('password');
            $table->enum('gender', ['M', 'F', 'other'])->nullable();
            $table->date('birth_date')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
