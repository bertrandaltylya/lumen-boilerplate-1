<?php

namespace Tests;

use App\Models\Auth\User\User;

class UserManagementTest extends TestCase
{
    /**
     * @param $method
     * @param $uri
     * @param $roleName
     * @param $statusCode
     * @test
     * @testWith        ["post", "user", "system", 200]
     *                  ["get", "user", "system", 200]
     *                  ["get", "user/{userId}", "system", 200]
     *                  ["post", "user", "admin", 200]
     *                  ["get", "user", "admin", 200]
     *                  ["get", "user/{userId}", "admin", 200]
     *                  ["post", "user", "user", 403]
     *                  ["get", "user", "user", 403]
     *                  ["get", "user/{userId}", "user", 403]
     *                  ["post", "user", "", 401]
     *                  ["get", "user", "", 401]
     *                  ["get", "user/{userId}", "", 401]
     */
    public function access($method, $uri, $roleName, $statusCode)
    {
        if (! empty($roleName)) {
            $this->loggedInAs($roleName);
        }

        $param = [];
        if ($method == 'post' && $uri == 'user') {
            $param = $this->_userData();
        } elseif ($method == 'get' && $uri == 'user/{userId}') {
            $user = factory(User::class)->create();
            $uri = 'user/'.$user->id;
        }

        $this->call($method, $uri, $param);
        $this->assertResponseStatus($statusCode);
    }

    private function _userData()
    {
        return [
            'first_name' => 'Lloric',
            'last_name' => 'Garcia',
            'email' => 'lloricode@gmail.com',
            'password' => app('hash')->make('secret'),
        ];
    }
}
