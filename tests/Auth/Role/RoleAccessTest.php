<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 1:14 PM
 */

namespace Tests\Auth\Role;

use App\Models\Auth\Role\Role;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    /**
     * @param $method
     * @param $uri
     * @param $roleName
     * @param $statusCode
     *
     * @test
     * @dataProvider dataResources
     */
    public function access($method, $uri, $roleName, $statusCode)
    {
        $uri = "auth/$uri";
        if (!empty($roleName)) {
            $this->loggedInAs($roleName);
        }

        $param = [];
        if ($method === 'post' && $uri === 'auth/role') {
            // only param
            $param = [
                'name' => 'test role name',
            ];
        } elseif ($method === 'get' && $uri === 'auth/role/{id}') {
            // only uri
            $uri = $this->replaceRoleUri($uri);
        } elseif ($method === 'delete' && $uri === 'auth/role/{id}') {
            // only uri
            $uri = $this->replaceRoleUri($uri, $this->createRole('test role 123'));
        } elseif ($method === 'put' && $uri === 'auth/role/{id}/edit') {
            // both uri and param
            $uri = $this->replaceRoleUri($uri, $this->createRole('test role 123'));
            $param = [
                'name' => 'test new role name',
            ];
        }

        $this->call($method, $uri, $param);
        $this->assertResponseStatus($statusCode);
    }

    private function replaceRoleUri($uri, Role $role = null): string
    {
        $role = is_null($role) ? app(config('permission.models.role'))->first() : $role;

        return str_replace('{id}', $role->getHashedId(), $uri);
    }

    private function createRole($name): Role
    {
        return app(config('permission.models.role'))::create([
            'name' => $name,
        ]);
    }

    public function dataResources(): array
    {
        return [
            // system
            'store by system' => ['post', 'role', 'system', 201],
            'index by system' => ['get', 'role', 'system', 200],
            'show by system' => ['get', 'role/{id}', 'system', 200],
            'update by system' => ['put', 'role/{id}/edit', 'system', 200],
            'destroy by system' => ['delete', 'role/{id}', 'system', 204],
            // admin
            'store by admin' => ['post', 'role', 'admin', 201],
            'index by admin' => ['get', 'role', 'admin', 200],
            'show by admin' => ['get', 'role/{id}', 'admin', 200],
            'update by admin' => ['put', 'role/{id}/edit', 'admin', 200],
            'destroy by admin' => ['delete', 'role/{id}', 'admin', 204],
            // role none role
            'store by none role' => ['post', 'role', 'user', 403],
            'index by none role' => ['get', 'role', 'user', 403],
            'show by none role' => ['get', 'role/{id}', 'user', 403],
            'update by none role' => ['put', 'role/{id}/edit', 'user', 403],
            'destroy by none role' => ['delete', 'role/{id}', 'user', 403],
            // guest
            'store by guest' => ['post', 'role', '', 401],
            'index by guest' => ['get', 'role', '', 401],
            'show by guest' => ['get', 'role/{id}', '', 401],
            'update by guest' => ['put', 'role/{id}/edit', '', 401],
            'destroy by guest' => ['delete', 'role/{id}', '', 401],
        ];
    }
}