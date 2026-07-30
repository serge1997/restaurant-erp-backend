<?php

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
        Schema::create('pre_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('corporate_name');
            $table->string('cnpj');
            $table->string('phone')->nullable();
            $table->string('comercial_contact');
            $table->string('email')->nullable();
            $table->string('account_responsable_phone');
            $table->string('account_responsable_email');
            $table->string('account_responsable_name');
            $table->string('account_responsable_cpf');
            $table->boolean('is_chain');
            $table->string('confirmation_token');
            $table->string('meta')->nullable();
            $table->dateTime("confirmation_token_expired_at");
            $table->boolean("is_confirmed")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_registrations');
    }
};
