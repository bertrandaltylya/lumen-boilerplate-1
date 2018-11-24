<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $viewBackend = Permission::create([
            'name' => 'view backend',
        ]);
        foreach (['system', 'admin',] as $roleName) {
            Role::create([
                'name' => $roleName,
            ])->givePermissionTo($viewBackend);
        }
    }
}
