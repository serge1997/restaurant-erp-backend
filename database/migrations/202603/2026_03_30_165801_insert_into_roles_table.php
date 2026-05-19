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
        DB::table("roles")->insert([
            ["name" => "super_admin", "guard_name" => "api"],
            ["name" => "admin", "guard_name" => "api"],
            ["name" => "gerente", "guard_name" => "api"],
            ["name" => "caixa", "guard_name" => "api"],
            ["name" => "garcom", "guard_name" => "api"],
            ["name" => "cozinha", "guard_name" => "api"],
        ]);

        DB::table("route_groups")->insert([
            ["name" => "produtos", 'module_id'  => 6],
            ["name" => "mesas", 'module_id'  => 8],
            ["name" => "salas", 'module_id'  => 8],
            ["name" => "pedidos", 'module_id'  => 2],
            ["name" => "itens do menu", 'module_id'  => 5],
            ["name" => "ficha técnica", 'module_id'  => 5],
            ["name" => "fornecedores", 'module_id'  => 8],
            ["name" => "relatórios", 'module_id'  => 1],
            ["name" => "requisicao de compra", 'module_id'  => 8],
            ["name" => "usuarios-colaboradores", 'module_id'  => 9],
            ["name" => "estoque", 'module_id'  => 6],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table("roles")->whereIn("name", ["super_admin", "admin", "garcom", "gerente", "caixa", "cozinha"])->delete();
    }
};
