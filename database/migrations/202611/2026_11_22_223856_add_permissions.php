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
                'api.purchaseRequisitions.show'
            ]);
            $waiter = Role::where('name', 'garcom')->first();
            $waiter->givePermissionTo([
                'api.orders.store',
                'api.orders.homeKpis',
                'api.tables.listAvailables',
                'api.tables.listAllWithOrderStatus',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $admin = Role::where('name', 'admin')->first();
        $admin->revokePermissionTo([
            'api.users.show',
            'api.orders.store',
            'api.orders.homeKpis',
            'api.orders.history',
            'api.tables.listAvailables',
            'api.tables.listAllWithOrderStatus',
            'api.purchaseRequisitions.pdf',
            'api.purchaseRequisitions.show'
        ]);
        $waiter = Role::where('name', 'garcom')->first();
        $waiter->revokePermissionTo([
            'api.orders.store',
            'api.orders.homeKpis',
            'api.tables.listAvailables',
            'api.tables.listAllWithOrderStatus',
        ]);
        DB::table("permissions")->whereIn('name', [
            'api.users.show',
            'api.orders.store',
            'api.orders.homeKpis',
            'api.tables.listAvailables',
            'api.tables.listAllWithOrderStatus',
            'api.purchaseRequisitions.pdf',
            'api.purchaseRequisitions.show'
        ])->delete();
    }
};
