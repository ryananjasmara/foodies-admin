<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create_users',
            'view_users',
            'edit_users',
            'delete_users',
            'create_products',
            'view_products',
            'edit_products',
            'delete_products',
            'create_orders',
            'view_orders',
            'edit_orders',
            'delete_orders',
            'export_orders',
            'create_admins',
            'view_admins',
            'edit_admins',
            'delete_admins',
            'create_roles',
            'view_roles',
            'edit_roles',
            'delete_roles',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
