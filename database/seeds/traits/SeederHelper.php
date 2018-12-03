<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

trait SeederHelper
{
    public function seederPermission(array $permissionNames, bool $isAddToAdminRole = true, array $except = [])
    {
        foreach ($permissionNames as $permissionName) {
            $permission = Permission::create([
                'name' => $permissionName,
            ]);
            Role::findByName('system')->givePermissionTo($permission);
            if ($isAddToAdminRole) {
                if (!in_array($permissionName, $except)) {
                    Role::findByName('admin')->givePermissionTo($permission);
                }
            }
        }
    }
}