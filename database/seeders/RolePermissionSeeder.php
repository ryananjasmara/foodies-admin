<?php
// database/seeders/RolePermissionTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = Permission::all();

        $rolePermissions = [
            'Admin' => $permissions->pluck('id')->toArray(),
            'Editor' => $permissions->filter(function ($permission) {
                return preg_match('/^(view_|edit_|create_)/', $permission->name);
            })->pluck('id')->toArray(),
            'Viewer' => $permissions->filter(function ($permission) {
                return preg_match('/view/', $permission->name);
            })->pluck('id')->toArray(),
        ];

        foreach ($rolePermissions as $roleName => $permissionIds) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $role->permissions()->sync($permissionIds);
            }
        }
    }
}