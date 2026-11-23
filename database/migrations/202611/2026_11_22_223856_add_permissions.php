<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $userGroup = DB::table('route_groups')->where('name', 'usuarios-colaboradores')->first();
        $orderGroup = DB::table('route_groups')->where('name', 'pedidos')->first();
        $tableGroup = DB::table('route_groups')->where('name', 'mesas')->first();
        $stock = DB::table('route_groups')->where('name', 'estoque')->first();
        $menuItemGroup = DB::table('route_groups')->where('name', 'itens do menu')->first();
        $permissions = [
            [
                'name' => 'api.users.show',
                'label' => 'Usuários',
                'route_group_id' => $userGroup->id,
                'description' => 'Visualizar usuário/colaborador',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.orders.store',
                'label' => 'Criar Pedido',
                'route_group_id' => $orderGroup->id,
                'description' => 'Criar um pedido',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.orders.homeKpis',
                'label' => 'Visualizar KPI da paginas inicial',
                'route_group_id' => $orderGroup->id,
                'description' => 'Visualizar KPI da paginas inicial',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.tables.listAvailables',
                'label' => 'Listar mesas disponíveis',
                'route_group_id' => $tableGroup->id,
                'description' => 'Listar mesas disponíveis',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.tables.listAllWithOrderStatus',
                'label' => 'Visualizar mesas com pedidos',
                'route_group_id' => $tableGroup->id,
                'description' => 'Visualizar mesas com pedidos',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.purchaseRequisitions.pdf',
                'label' => 'Pdf da requisiçao de estoque',
                'route_group_id' => $stock->id,
                'description' => 'Pdf da requisiçao de estoque', 
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.purchaseRequisitions.show',
                'label' => 'Mostrar uma requisiçao de estoque',
                'route_group_id' => $stock->id,
                'description' => 'Visualizar uma requisiçao de estoque', 
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.menuCategories.index',
                'label' => 'Categorias do menu',
                'route_group_id' => $menuItemGroup->id,
                'description' => 'Visualizar Categorias do menu',
                'type' => 'api',
                'view_path'  => 'menu-categories',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.menuCategories.show',
                'label' => 'Categorias do menu',
                'route_group_id' => $menuItemGroup->id,
                'description' => 'Visualizar Categoria do menu',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.menuCategories.store',
                'label' => 'Criar Categoria do menu',
                'route_group_id' => $menuItemGroup->id,
                'description' => 'Criar Categoria do menu',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.menuCategories.update',
                'label' => 'Alterar Categoria do menu',
                'route_group_id' => $menuItemGroup->id,
                'description' => 'Alterar Categoria do menu',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.menuCategories.delete',
                'label' => 'Remover Categoria do menu',
                'route_group_id' => $menuItemGroup->id,
                'description' => 'Remover Categoria do menu',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
        ];
        DB::transaction(function() use($permissions){
            foreach ($permissions as $permission) {
                DB::table('permissions')->insert($permission);
            }

            DB::table("permissions")->where('name', 'api.orders.history')
                ->update(['description' => 'Visualizar historico de pedidos']);


            $admin = Role::where('name', 'admin')->first();
            $admin->givePermissionTo([
                'api.users.show',
                'api.orders.store',
                'api.orders.homeKpis',
                'api.orders.show',
                'api.orders.history',
                'api.tables.listAvailables',
                'api.tables.listAllWithOrderStatus',
                'api.purchaseRequisitions.pdf',
                'api.purchaseRequisitions.show',
                'api.menuCategories.index',
                'api.menuCategories.show'
            ]);
            $waiter = Role::where('name', 'garcom')->first();
            $waiter->givePermissionTo([
                'api.orders.store',
                'api.orders.homeKpis',
                'api.tables.listAvailables',
                'api.tables.listAllWithOrderStatus',
                'api.menuCategories.index',
                'api.menuCategories.show',
            ]);
            $kicken = Role::where('name', 'cozinha')->first();
            $kicken->givePermissionTo([
                'api.menuCategories.index',
                'api.menuCategories.show'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $kicken = Role::where('name', 'cozinha')->first();
        $admin = Role::where('name', 'admin')->first();
        $admin->revokePermissionTo([
            'api.users.show',
            'api.orders.store',
            'api.orders.homeKpis',
            'api.orders.history',
            'api.tables.listAvailables',
            'api.tables.listAllWithOrderStatus',
            'api.purchaseRequisitions.pdf',
            'api.purchaseRequisitions.show',
            'api.menuCategories.index'
        ]);
        $waiter = Role::where('name', 'garcom')->first();
        $waiter->revokePermissionTo([
            'api.orders.store',
            'api.orders.homeKpis',
            'api.tables.listAvailables',
            'api.tables.listAllWithOrderStatus',
            'api.menuCategories.index'
        ]);
        $kicken->revokePermissionTo([
            'api.menuCategories.index',
            'api.menuCategories.show',
        ]);
        DB::table("permissions")->whereIn('name', [
            'api.users.show',
            'api.orders.store',
            'api.orders.homeKpis',
            'api.tables.listAvailables',
            'api.tables.listAllWithOrderStatus',
            'api.purchaseRequisitions.pdf',
            'api.purchaseRequisitions.show',
            'api.menuCategories.index',
            'api.menuCategories.store',
            'api.menuCategories.update',
            'api.menuCategories.show',
            'api.menuCategories.delete'
        ])->delete();
    }
};
