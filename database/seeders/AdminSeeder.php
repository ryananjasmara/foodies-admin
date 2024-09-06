<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::where('name', 'Admin')->first();

        if ($role) {
            Admin::create([
                'username' => 'admin',
                'password' => Hash::make('password'),
                'name' => 'Foodies Super Admin',
                'role_id' => $role->id,
            ]);
        }
    }
}