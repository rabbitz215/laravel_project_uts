<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::findOrCreate('admin');
        $permissionProduct = Permission::findOrCreate('form product', 'web');
        $permissionCategory = Permission::findOrCreate('form category', 'web');

        $role->givePermissionTo($permissionProduct, $permissionCategory);
    }
}
