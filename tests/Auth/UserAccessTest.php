<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 1:14 PM
 */

namespace Tests\Auth;

use App\Models\Auth\User\User;
use Tests\TestCase;

class UserAccessTest extends TestCase
{
    /**
     * @param $method
     * @param $uri
     * @param $roleName
     * @param $statusCode
     * @test
     * @dataProvider dataResources
     */
    public function access($method, $uri, $roleName, $statusCode)
    {
        if (!empty($roleName)) {
            $this->loggedInAs($roleName);
        }

        $param = [];
        if ($method === 'post' && $uri === 'user') {
            $param = $this->userData();
        } elseif ($method === 'get' && $uri === 'user/{id}') {
            $uri = str_replace('{id}', factory(User::class)->create()->getHashedId(), $uri);
        } elseif ($method === 'put' && $uri === 'user/{id}/edit') {
            $uri = str_replace('{id}', factory(User::class)->create()->getHashedId(), $uri);
            $param = $this->userData();
        }

        $this->call($method, $uri, $param);
        $this->assertResponseStatus($statusCode);
    }

    public function dataResources(): array
    {
        return [
            // system
            'store by system' => ['post', 'user', 'system', 201],
            'index by system' => ['get', 'user', 'system', 200],
            'show by system' => ['get', 'user/{id}', 'system', 200],
            'update by system' => ['put', 'user/{id}/edit', 'system', 200],
            'destroy by system' => ['delete', 'user/{id}', 'system', 204],
            'restore by system' => ['put', 'user/{id}/restore', 'system', 200],
            'purge by system' => ['put', 'user/{id}/purge', 'system', 204],
            // admin
            'store by admin' => ['post', 'user', 'admin', 201],
            'index by admin' => ['get', 'user', 'admin', 200],
            'show by admin' => ['get', 'user/{id}', 'admin', 200],
            'update by admin' => ['put', 'user/{id}/edit', 'admin', 200],
            'destroy by admin' => ['delete', 'user/{id}', 'admin', 204],
            'restore by admin' => ['put', 'user/{id}/restore', 'admin', 200],
            'purge by admin' => ['put', 'user/{id}/purge', 'admin', 204],
            // user none role
            'store by none role' => ['post', 'user', 'user', 403],
            'index by none role' => ['get', 'user', 'user', 403],
            'show by none role' => ['get', 'user/{id}', 'user', 403],
            'update by none role' => ['put', 'user/{id}/edit', 'user', 403],
            'destroy by none role' => ['delete', 'user/{id}', 'user', 403],
            'restore by none role' => ['put', 'user/{id}/restore', 'user', 403],
            'purge by none role' => ['put', 'user/{id}/purge', 'user', 403],
            // guest
            'store by guest' => ['post', 'user', '', 401],
            'index by guest' => ['get', 'user', '', 401],
            'show by guest' => ['get', 'user/{id}', '', 401],
            'update by guest' => ['put', 'user/{id}/edit', '', 401],
            'destroy by guest' => ['delete', 'user/{id}', '', 401],
            'restore by guest' => ['put', 'user/{id}/restore', '', 401],
            'purge by guest' => ['put', 'user/{id}/purge', '', 401],
        ];
    }
}