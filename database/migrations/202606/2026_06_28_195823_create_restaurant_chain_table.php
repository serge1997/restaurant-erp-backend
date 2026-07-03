<?php

use App\Models\User;
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
        Schema::create('restaurant_chains', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("corporate_name");
            $table->string("cpf_cnpj");
            $table->string("email")->nullable();
            $table->string("phone")->nullable();
            $table->string("comercial_contact")->nullable();
            $table->string("account_responsable_name");
            $table->string("account_responsable_phone");
            $table->string("account_responsable_email")->nullable();
            $table->foreignIdFor(User::class, "created_by");
            $table->boolean("is_active")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_chain');
    }
};
