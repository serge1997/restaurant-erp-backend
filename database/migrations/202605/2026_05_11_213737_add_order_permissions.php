<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $orderGroup = DB::table('route_groups')->where('name', 'pedidos')->first();
        $restaurantGroup = DB::table('route_groups')->where('name', 'restaurantes')->first();
        $permissions = [
            [
                'name' => 'api.orders.index',
                'label' => 'Pedidos - Listar',
                'description' => 'Visualizar pedidos',
                'route_group_id' => $orderGroup->id,
                'view_path'  => '',
                'type' => 'api',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.orders.history',
                'label' => 'Historico de Pedidos',
                'description' => 'Visualizar historico produtos',
                'route_group_id' => $orderGroup->id,
                'view_path'  => 'history',
                'type' => 'api',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.orders.show',
                'label' => 'Visualizar Pedido',
                'route_group_id' => $orderGroup->id,
                'description' => 'Visualizar detalhes do pedido',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.orders.update',
                'label' => 'Atualizar Pedido',
                'route_group_id' => $orderGroup->id,
                'description' => 'Atualizar detalhes do pedido',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.orders.delete',
                'label' => 'Excluir Pedido',
                'route_group_id' => $orderGroup->id,
                'description' => 'Remover um pedido do sistema',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.orders.transfert',
                'label' => 'Transferir Pedido',
                'route_group_id' => $orderGroup->id,
                'description' => 'Transferir itens do pedido',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.orders.paymentMethod',
                'label' => 'Alterar ou adicionar Método de Pagamento',
                'route_group_id' => $orderGroup->id,
                'description' => 'Alterar método de pagamento do pedido',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.restaurants.index',
                'label' => 'Restaurantes - Listar',
                'description' => 'Visualizar restaurantes',
                'route_group_id' => $restaurantGroup->id,
                'view_path'  => 'restaurants',
                'type' => 'api',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.restaurants.show',
                'label' => 'Restaurantes - Visualizar',
                'description' => 'Visualizar detalhes do restaurante',
                'route_group_id' => $restaurantGroup->id,
                'view_path'  => 'restaurants',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.restaurants.update',
                'label' => 'Restaurantes - Atualizar',
                'description' => 'Atualizar detalhes do restaurante',
                'route_group_id' => $restaurantGroup->id,
                'view_path'  => 'restaurants',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ]
        ];
        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }
        $admin = Role::where('name', 'admin')->first();
        $admin->givePermissionTo([
            'api.orders.index',
            'api.orders.show',
            'api.orders.update',
            'api.orders.delete',
            'api.orders.transfert',
            'api.orders.paymentMethod',
            'api.restaurants.index',
            'api.restaurants.show',
            'api.restaurants.update'
        ]);
        $caixas = Role::where('name', 'caixa')->first();
        $caixas->givePermissionTo([
            'api.orders.index',
            'api.orders.show',
            'api.orders.transfert',
            'api.orders.paymentMethod'
        ]);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $admin = Role::where('name', 'admin')->first();
        $admin->revokePermissionTo([
            'api.orders.index',
            'api.orders.show',
            'api.orders.update',
            'api.orders.delete',
            'api.orders.transfert',
            'api.orders.paymentMethod',
            'api.orders.history',
            'api.restaurants.index',
            'api.restaurants.show',
            'api.restaurants.update'
        ]);
        $caixas = Role::where('name', 'caixa')->first();
        $caixas->revokePermissionTo([
            'api.orders.index',
            'api.orders.show',
            'api.orders.transfert',
            'api.orders.paymentMethod'
        ]);

        $permissions = [
            'api.orders.index',
            'api.orders.show',
            'api.orders.update',
            'api.orders.delete',
            'api.orders.transfert',
            'api.orders.paymentMethod',
            'api.orders.history',
            'api.restaurants.index',
            'api.restaurants.show',
            'api.restaurants.update'
        ];
        DB::table('permissions')->whereIn('name', $permissions)->delete();
            
    }
};
