<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permisos = [
            // //NOTE: Permisos de Categorias
            'ver-categoria',
            'crear-categoria',
            'editar-categoria',
            'eliminar-categoria',
            // //NOTE: Permisos de Clientes
            'ver-cliente',
            'crear-cliente',
            'editar-cliente',
            'eliminar-cliente',
            // //NOTE: Permisos de Compra 
            'ver-compra',
            'crear-compra',
            'mostrar-compra',
            'eliminar-compra',
            // //NOTE: Permisos de Marca
            'ver-marca',
            'crear-marca',
            'editar-marca',
            'eliminar-marca',
            // //NOTE: Permisos de Presentacion 
            'ver-presentacion',
            'crear-presentacion',
            'editar-presentacion',
            'eliminar-presentacion',
            // //NOTE: Permisos de Producto
            'ver-producto',
            'crear-producto',
            'editar-producto',
            'eliminar-producto',
            // //NOTE: Permisos de Proveedor
            'ver-proveedore',
            'crear-proveedore',
            'editar-proveedore',
            'eliminar-proveedore',
            // //NOTE: Permisos de Venta
            'ver-venta',
            'crear-venta',
            'mostrar-venta',
            'eliminar-venta',
            //NOTE: Permisos de Roles
            'ver-role',
            'crear-role',
            'editar-role',
            'eliminar-role',
            //NOTE: Permisos de Usuarios
            'ver-user',
            'crear-user',
            'editar-user',
            'eliminar-user',
        ];
        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }
    }
}
