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
        $cities = [
            //SP
            ['name' => 'São Paulo', 'uf' => 'SP'],
            ['name' => 'Campinas', 'uf' => 'SP'],
            ['name' => 'Santos', 'uf' => 'SP'],
            ['name' => 'Guarulhos', 'uf' => 'SP'],
            ['name' => 'São Bernardo do Campo', 'uf' => 'SP'],
            ['name' => 'São José dos Campos', 'uf' => 'SP'],
            ['name' => 'Sorocaba', 'uf' => 'SP'],
            ['name' => 'Ribeirão Preto', 'uf' => 'SP'],
            ['name' => 'Osasco', 'uf' => 'SP'],
            ['name' => 'Catanduva', 'uf' => 'SP'],

            ['name' => 'Rio de Janeiro', 'uf' => 'RJ'],
            ['name' => 'Belo Horizonte', 'uf' => 'MG'],
            //PR
            ['name' => 'Curitiba', 'uf' => 'PR'],
            ['name' => 'Pinhais', 'uf' => 'PR'],
            ['name' => 'Londrina', 'uf' => 'PR'],
            ['name' => 'Porto Alegre', 'uf' => 'RS'],
            ['name' => 'Salvador', 'uf' => 'BA'],
            ['name' => 'Fortaleza', 'uf' => 'CE'],
            ['name' => 'Brasília', 'uf' => 'DF'],
            ['name' => 'Recife', 'uf' => 'PE'],
            ['name' => 'Manaus', 'uf' => 'AM'],
        ];
        \App\Models\City::insert($cities);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cities', function (Blueprint $table) {
            //
        });
    }
};
