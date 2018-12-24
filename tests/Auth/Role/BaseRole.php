<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/24/18
 * Time: 11:30 AM
 */

namespace Tests\Auth\Role;

use App\Models\Auth\Role\Role;
use Tests\TestCase;

abstract class BaseRole extends TestCase
{
    protected function getByRoleName(string $accessRoleName = 'system'): Role
    {
        return app(config('permission.models.role'))
            ->findByName(config("access.role_names.$accessRoleName"));
    }

    protected function replaceRoleUri($uri, Role $role = null): string
    {
        $role = is_null($role) ? app(config('permission.models.role'))->first() : $role;

        return str_replace('{id}', $role->getHashedId(), $uri);
    }

    protected function createRole($name = 'test role name'): Role
    {
        return app(config('permission.models.role'))::create([
            'name' => $name,
        ]);
    }

}