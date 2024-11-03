<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Database\Factories\PermissionFactory;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Crear permisos solo si no existen
        Permission::firstOrCreate(['name' => 'edit articles', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'delete articles', 'guard_name' => 'api']);
        Permission::firstOrCreate(['name' => 'publish articles', 'guard_name' => 'api']);

        // Crear roles solo si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
        $editorRole = Role::firstOrCreate(['name' => 'editor', 'guard_name' => 'api']);

        // Asignar permisos al rol de administrador
        $adminRole->syncPermissions(['edit articles', 'delete articles', 'publish articles']);

        // Asignar solo algunos permisos al rol de editor
        $editorRole->syncPermissions(['edit articles']);
    }
}