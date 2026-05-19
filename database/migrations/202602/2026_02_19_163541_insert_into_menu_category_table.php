<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table("menu_categories")->insert([
            [
                'name' => 'Entradas',
                'created_at' => now()
            ],
            [
                'name' => 'Pratos principais',
                'created_at' => now()
            ],
            [
                'name' => 'Sobremesas',
                'created_at' => now()
            ],
            [
                'name' => 'Fast Food',
                'created_at' => now()
            ],
            [
                'name' => 'Sopas',
                'created_at' => now()
            ],
            [
                'name' => 'Coqueteis',
                'created_at' => now()
            ],
            [
                'name' => 'Sucos',
                'created_at' => now()
            ],
            [
                'name' => 'Frituras',
                'created_at' => now()
            ],
            [
                'name' => 'Vinhos',
                'created_at' => now()
            ],
            [
                'name' => 'Espumantes',
                'created_at' => now()
            ],
            [
                'name' => 'Vodka',
                'created_at' => now()
            ],
            [
                'name' => 'Rhum',
                'created_at' => now()
            ],
            [
                'name' => 'Whysky',
                'created_at' => now()
            ],
            [
                'name' => 'Oriental',
                'created_at' => now()
            ],
            [
                'name' => 'Carnes',
                'created_at' => now()
            ],
            [
                'name' => 'Peixes',
                'created_at' => now()
            ],
            [
                'name' => 'Frutos de mar',
                'created_at' => now()
            ],
            [
                'name' => 'Massas',
                'created_at' => now()
            ],
            [
                'name' => 'Brasileiro',
                'created_at' => now()
            ],
            [
                'name' => 'Ocidental',
                'created_at' => now()
            ],
            [
                'name' => 'Africana',
                'created_at' => now()
            ],
            [
                'name' => 'Hambúrguer',
                'created_at' => now()
            ],
            [
                'name' => 'Cachaça',
                'created_at' => now()
            ],
            [
                'name' => 'Bourbon',
                'created_at' => now()
            ],
            [
                'name' => 'Saké',
                'created_at' => now()
            ],
        ]);
    }
};
