<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RBACSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $user = Role::updateOrCreate(['name' => 'user']);
        $admin = Role::updateOrCreate(['name' => 'admin']);
        $permissions = [];
        collect(['list', 'create', 'edit', 'view', 'delete'])->each(function ($action) {
            $permission[] = Permission::updateOrCreate([
                'name' => 'users.' . $action,
                'guard_name' => 'web',
            ]);
        });
        $admin->syncPermissions($permissions);
    }
}
