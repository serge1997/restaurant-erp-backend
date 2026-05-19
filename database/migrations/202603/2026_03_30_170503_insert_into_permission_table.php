<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $productGroup = DB::table('route_groups')->where('name', 'produtos')->first();
        $roomGroup = DB::table('route_groups')->where('name', 'salas')->first();
        $tableGroup = DB::table('route_groups')->where('name', 'mesas')->first();
        $menuItemGroup = DB::table('route_groups')->where('name', 'itens do menu')->first();
        $userGroup = DB::table('route_groups')->where('name', 'usuarios-colaboradores')->first();
        $stock = DB::table('route_groups')->where('name', 'estoque')->first();
        $fornecedorGroup = DB::table('route_groups')->where('name', 'fornecedores')->first();
        $permissions = [
            //products
            [
                'name' => 'api.products.index',
                'label' => 'Produtos',
                'description' => 'Visualizar produtos',
                'route_group_id' => $productGroup->id,
                'view_path'  => 'products',
                'type' => 'api',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.products.show',
                'label' => 'Visualizar Produto',
                'route_group_id' => $productGroup->id,
                'description' => 'Visualizar detalhes do produto',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.products.update',
                'label' => 'Atualizar Produto',
                'route_group_id' => $productGroup->id,
                'description' => 'Atualizar detalhes do produto',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.products.delete',
                'label' => 'Excluir Produto',
                'route_group_id' => $productGroup->id,
                'description' => 'Remover um produto do sistema',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            //rooms
            //menu items
            [
                'name' => 'api.menuItems.index',
                'label' => 'Cadastro',
                'route_group_id' => $menuItemGroup->id,
                'description' => 'Visualizar itens do cardápio',
                'view_path'  => 'items',
                'type' => 'api',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.menuItems.index.items',
                'label' => 'Cardápio',
                'route_group_id' => $menuItemGroup->id,
                'description' => 'Visualizar itens do cardápio',
                'view_path'  => '',
                'type' => 'api',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.menuItems.show',
                'label' => 'Visualizar itens do cardápio',
                'route_group_id' => $menuItemGroup->id,
                'description' => 'Visualizar detalhes do item do cardápio',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.menuItems.update',
                'label' => 'Atualizar Produto',
                'route_group_id' => $menuItemGroup->id,
                'description' => 'Atualizar detalhes do item do cardápio',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.menuItems.delete',
                'label' => 'Excluir item do cardápio',
                'route_group_id' => $menuItemGroup->id,
                'description' => 'Remover um item do cardapio do sistema',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            //menu items
            [
                'name' => 'api.rooms.index',
                'label' => 'Salas',
                'route_group_id' => $roomGroup->id,
                'description' => 'Visualizar salas',
                'view_path'  => 'rooms',
                'type' => 'api',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.rooms.show',
                'label' => 'Visualizar sala',
                'route_group_id' => $roomGroup->id,
                'description' => 'Visualizar detalhes da sala',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.rooms.update',
                'label' => 'Atualizar sala',
                'route_group_id' => $roomGroup->id,
                'description' => 'Atualizar detalhes da sala',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.rooms.delete',
                'label' => 'Excluir Produto',
                'route_group_id' => $roomGroup->id,
                'description' => 'Remover uma sala do sistema',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            //rooms
            //tables
            [
                'name' => 'api.tables.index',
                'label' => 'Mesas',
                'route_group_id' => $tableGroup->id,
                'description' => 'Visualizar mesas',
                'view_path'  => 'tables',
                'type' => 'api',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.tables.store',
                'label' => 'Criar Mesas',
                'route_group_id' => $tableGroup->id,
                'description' => 'Adicionar uma nova mesa ao sistema',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.tables.update',
                'label' => 'Editar Mesas',
                'route_group_id' => $tableGroup->id,
                'description' => 'Atualizar detalhes da mesa',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.tables.delete',
                'label' => 'Excluir Mesas',
                'route_group_id' => $tableGroup->id,
                'description' => 'Remover uma mesa do sistema',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            //users
            [
                'name' => 'api.users.index',
                'label' => 'Usuários',
                'route_group_id' => $userGroup->id,
                'description' => 'Visualizar usuários/colaboradores',
                'view_path'  => 'users',
                'type' => 'api',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.users.store',
                'label' => 'Criar Usuário',
                'route_group_id' => $userGroup->id,
                'description' => 'Adicionar um novo usuário/colaborador ao sistema',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.users.update',
                'label' => 'Editar Usuário',
                'route_group_id' => $userGroup->id,
                'description' => 'Atualizar detalhes do usuário/colaborador',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.users.delete',
                'label' => 'Excluir Usuário',
                'route_group_id' => $userGroup->id,
                'description' => 'Remover um usuário/colaborador do sistema',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            //purchase requisitions
            [
                'name' => 'api.purchaseRequisitions.index',
                'label' => 'Requisições de Compra',
                'route_group_id' => $stock->id,
                'description' => 'Visualizar requisições de compra',
                'view_path'  => 'purchase-requisitions',
                'type' => 'api',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.purchaseRequisitions.store',
                'label' => 'Criar Requisição de Compra',
                'route_group_id' => $stock->id,
                'description' => 'Adicionar uma nova requisição de compra ao sistema',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.purchaseRequisitions.update',
                'label' => 'Editar Requisição de Compra',
                'route_group_id' => $stock->id,
                'description' => 'Atualizar detalhes da requisição de compra',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.purchaseRequisitions.delete',
                'label' => 'Excluir Requisição de Compra',
                'route_group_id' => $stock->id,
                'description' => 'Remover uma requisição de compra do sistema',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.purchaseRequisitions.attacheStatus',
                'label' => 'Anexar Status à Requisição de Compra',
                'route_group_id' => $stock->id,
                'description' => 'Anexar um status a uma requisição de compra',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            //stock movements
            [
                'name' => 'api.stockMovements.index',
                'label' => 'Movimentações de Estoque',
                'route_group_id' => $stock->id,
                'description' => 'Visualizar movimentações de estoque',
                'view_path'  => 'stock-movements',
                'type' => 'api',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.stockMovements.store',
                'label' => 'Criar Movimentação de Estoque',
                'route_group_id' => $stock->id,
                'description' => 'Adicionar uma nova movimentação de estoque ao sistema',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.stockMovements.update',
                'label' => 'Editar Movimentação de Estoque',
                'route_group_id' => $stock->id,
                'description' => 'Atualizar detalhes da movimentação de estoque',
                'type' => 'api',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            //suppliers
            [
                'name' => 'api.suppliers.index',
                'label' => 'Fornecedores',
                'route_group_id' => $fornecedorGroup->id,
                'description' => 'Visualizar fornecedores',
                'view_path'  => 'suppliers',
                'type' => 'web',
                'show_in_menu' => true,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.suppliers.store',
                'label' => 'Criar Fornecedor',
                'route_group_id' => $fornecedorGroup->id,
                'description' => 'Adicionar um novo fornecedor ao sistema',
                'type' => 'web',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.suppliers.update',
                'label' => 'Editar Fornecedor',
                'route_group_id' => $fornecedorGroup->id,
                'description' => 'Atualizar detalhes do fornecedor',
                'type' => 'web',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
            [
                'name' => 'api.suppliers.delete',
                'label' => 'Excluir Fornecedor',
                'route_group_id' => $fornecedorGroup->id,
                'description' => 'Remover um fornecedor do sistema',
                'type' => 'web',
                'show_in_menu' => false,
                'guard_name' => 'api',
            ],
        ];
        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }
        $admin = Role::where('name', 'admin')->first();
        $admin->givePermissionTo([
            'api.tables.index',
            'api.tables.store',
            'api.tables.update',
            'api.tables.delete',
            'api.products.index',
            'api.products.show',
            'api.products.update',
            'api.products.delete',
            'api.menuItems.index',
            'api.menuItems.index.items',
            'api.menuItems.show',
            'api.menuItems.update',
            'api.menuItems.delete',
            'api.rooms.index',
            'api.rooms.show',
            'api.rooms.update',
            'api.rooms.delete',
            'api.users.index',
            'api.users.store',
            'api.users.update',
            'api.users.delete',
            'api.purchaseRequisitions.index',
            'api.purchaseRequisitions.store',
            'api.purchaseRequisitions.update',
            'api.purchaseRequisitions.delete',
            'api.purchaseRequisitions.attacheStatus',
            'api.stockMovements.index',
            'api.stockMovements.store',
            'api.stockMovements.update',
            'api.suppliers.index',
            'api.suppliers.store',
            'api.suppliers.update',
            'api.suppliers.delete',
        ]);
        $kicken = Role::where('name', 'cozinha')->first();
        $kicken->givePermissionTo([
            'api.products.index',
            'api.products.show',
            'api.menuItems.index',
            'api.menuItems.show',
            'api.purchaseRequisitions.index',
            'api.purchaseRequisitions.store',
            'api.purchaseRequisitions.update',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::whereIn('name', ['api.tables.index', 'api.tables.store', 'api.tables.update', 'api.tables.delete'])->delete();
        Role::where('name', 'super_admin')->first()->revokePermissionTo(['api.tables.index', 'api.tables.store', 'api.tables.update', 'api.tables.delete']);
    }
};
