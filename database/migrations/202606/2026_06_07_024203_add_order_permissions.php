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
        $permissions = [
            [
                'name' => 'api.tables.listForOrders',
                'label' => 'Mesas',
                'description' => 'Visualizar pedidos e mesas',
                'route_group_id' => $orderGroup->id,
                'view_path'  => 'tables',
                'type' => 'web',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.orders.cancelItem',
                'label' => 'Cancelar item do pedido',
                'description' => 'Cancelar item do pedido',
                'route_group_id' => $orderGroup->id,
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.orders.cancel',
                'label' => 'Cancelar pedido',
                'description' => 'Cancelar pedido',
                'route_group_id' => $orderGroup->id,
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
            'api.tables.listForOrders',
            'api.orders.cancel',
            'api.orders.cancelItem'
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permissions = [
            'api.tables.listForOrders',
            'api.orders.cancel',
            'api.orders.cancelItem'
        ];
        $admin = Role::where('name', 'admin')->first();
        $admin->revokePermissionTo($permissions);
        DB::table('permissions')->whereIn('name', $permissions)->delete();
    }
};
