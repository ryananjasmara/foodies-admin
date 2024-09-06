<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Admin'],
            ['name' => 'Editor'],
            ['name' => 'Viewer'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}