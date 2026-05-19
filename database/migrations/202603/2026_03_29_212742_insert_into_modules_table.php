<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

use function Symfony\Component\String\b;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $modules = [
            [
                'name'        => 'Dashboard',
                'description' => 'Visão geral do dia',
                'base_view_path' => 'dashboard',
                'icon'        => 'pi pi-home',
                'order'       => 1,
            ],
            [
                'name'        => 'Pedidos',
                'description' => 'Gestão de pedidos e mesas',
                'base_view_path' => 'orders',
                'icon'        => 'pi pi-shopping-cart',
                'order'       => 2,
            ],
            [
                'name'        => 'Cozinha',
                'description' => 'KDS — exibição para cozinha',
                'base_view_path' => 'kitchen',
                'icon'        => 'pi pi-sparkles',
                'order'       => 3,
            ],
            [
                'name'        => 'Caixa',
                'description' => 'Fechamento e pagamentos',
                'base_view_path' => 'cashier',
                'icon'        => 'pi pi-wallet',
                'order'       => 4,
            ],
            [
                'name'        => 'Cardápio',
                'description' => 'Pratos, bebidas e ficha técnica',
                'base_view_path' => 'menu',
                'icon'        => 'pi pi-book',
                'order'       => 5,
            ],
            [
                'name'        => 'Estoque',
                'description' => 'Insumos, entrada e saída',
                'base_view_path' => 'stock',
                'icon'        => 'pi pi-box',
                'order'       => 6,
            ],
            [
                'name'        => 'Relatórios',
                'description' => 'Vendas, margem e performance',
                'base_view_path' => 'reports',
                'icon'        => 'pi pi-chart-bar',
                'order'       => 7,
            ],
            [
                'name'        => 'Administração',
                'description' => 'Restaurante, mesas, salas e fiscal',
                'base_view_path' => 'administrative',
                'icon'        => 'pi pi-folder-plus',
                'order'       => 8,
            ],
            [
                'name'        => 'Configurações',
                'description' => 'Restaurante, mesas, salas e fiscal...',
                'base_view_path' => 'settings',
                'icon'        => 'pi pi-cog',
                'order'       => 9,
            ],
        ];
        DB::table('modules')->insert($modules);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
