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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("name", 60);
            $table->string("corporate_name", 60);
            $table->string("description", 130)->nullable();
            $table->string("address", 100);
            $table->string("number", 10);
            $table->string("phone", 60);
            $table->string("email", 40);
            $table->string("corporate_registration", 20)->comment("government ID registration like CPF / CNPJ in Brazil");
            $table->string("logo")->nullable();
            $table->float("loss_margim", 2)->nullable();
            $table->float("variable_margim", 2)->nullable();
            $table->float("fix_margim", 2)->nullable();
            $table->boolean("enable_technical_sheet")->default(true);
            $table->boolean("is_active")->default(false);
            $table->decimal("latitude", 10, 7)->nullable();
            $table->decimal("longitude", 10, 7)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
