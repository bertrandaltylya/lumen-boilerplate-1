<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 1:14 PM
 */

namespace Tests\Auth\Role;

use Tests\TestCase;

class PermissionAccessTest extends TestCase
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
        if (!empty($roleName)) {
            $this->loggedInAs($roleName);
        }
        $uri = "auth/$uri";
        if ($uri == 'auth/permission/{id}') {
            $p = app(config('permission.models.permission'))->first();
            $uri = str_replace('{id}', $p->getHashedId(), $uri);
        }
        $this->call($method, $uri);
        $this->assertResponseStatus($statusCode);
    }

    public function dataResources(): array
    {
        return [
            // system
            'index by system' => ['get', 'permission', 'system', 200],
            'show by system' => ['get', 'permission/{id}', 'system', 200],
            // admin
            'index by admin' => ['get', 'permission', 'admin', 200],
            'show by admin' => ['get', 'permission/{id}', 'admin', 200],
            // role none role
            'index by none role' => ['get', 'permission', 'user', 403],
            'show by none role' => ['get', 'permission/{id}', 'user', 403],
            // guest
            'index by guest' => ['get', 'permission', '', 401],
            'show by guest' => ['get', 'permission/{id}', '', 401],
        ];
    }

}