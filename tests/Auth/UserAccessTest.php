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
     * @testWith        ["post", "user", "system", 201]
     *                  ["get", "user", "system", 200]
     *                  ["get", "user/{id}", "system", 200]
     *                  ["post", "user", "admin", 201]
     *                  ["get", "user", "admin", 200]
     *                  ["get", "user/{id}", "admin", 200]
     *                  ["post", "user", "user", 403]
     *                  ["get", "user", "user", 403]
     *                  ["get", "user/{id}", "user", 403]
     *                  ["post", "user", "", 401]
     *                  ["get", "user", "", 401]
     *                  ["get", "user/{id}", "", 401]
     */
    public function access($method, $uri, $roleName, $statusCode)
    {
        if (! empty($roleName)) {
            $this->loggedInAs($roleName);
        }

        $param = [];
        if ($method === 'post' && $uri === 'user') {
            $param = $this->userData();
        } elseif ($method === 'get' && $uri === 'user/{id}') {
            $user = factory(User::class)->create();
            $uri = 'user/'.$user->getHashedId();
        }

        $this->call($method, $uri, $param);
        $this->assertResponseStatus($statusCode);
    }
}