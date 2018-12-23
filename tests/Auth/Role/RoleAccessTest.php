<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 1:14 PM
 */

namespace Tests\Auth\Role;

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
        } elseif ($method === 'get' && $uri === 'auth/role/{id}'
//            || $method === 'delete' && $uri === 'role/{id}'
        ) {
            // only uri
            $uri = $this->replaceUserUri($uri);
        }
// elseif ($method === 'put' && $uri === 'role/{id}/restore' ||
//            $method === 'delete' && $uri === 'role/{id}/purge') {
//            // only uri
//            $uri = $this->replaceUserUri($uri, true);
//        } elseif ($method === 'put' && $uri === 'role/{id}/edit') {
//            // both uri and param
//            $uri = $this->replaceUserUri($uri);
//            $param = [
//                'name' => 'test role name',
//            ];
//        }

        $this->call($method, $uri, $param);
        $this->assertResponseStatus($statusCode);
    }

    public function dataResources(): array
    {
        return [
            // system
            'store by system' => ['post', 'role', 'system', 201],
            'index by system' => ['get', 'role', 'system', 200],
            'show by system' => ['get', 'role/{id}', 'system', 200],
//            'update by system' => ['put', 'role/{id}/edit', 'system', 200],
            // admin
            'store by admin' => ['post', 'role', 'admin', 201],
            'index by admin' => ['get', 'role', 'admin', 200],
            'show by admin' => ['get', 'role/{id}', 'admin', 200],
//            'update by admin' => ['put', 'role/{id}/edit', 'admin', 200],
            // role none role
            'store by none role' => ['post', 'role', 'user', 403],
            'index by none role' => ['get', 'role', 'user', 403],
            'show by none role' => ['get', 'role/{id}', 'user', 403],
//            'update by none role' => ['put', 'role/{id}/edit', 'user', 403],
            // guest
            'store by guest' => ['post', 'role', '', 401],
            'index by guest' => ['get', 'role', '', 401],
            'show by guest' => ['get', 'role/{id}', '', 401],
//            'update by guest' => ['put', 'role/{id}/edit', '', 401],
        ];
    }

    private function replaceUserUri($uri, bool $isDeleted = false): string
    {
        $role = app(config('permission.models.role'))->first();
        if ($isDeleted) {
            $role->delete();
        }
        return str_replace('{id}', $role->getHashedId(), $uri);
    }
}