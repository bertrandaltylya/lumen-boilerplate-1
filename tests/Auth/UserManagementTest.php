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
     *                  ["get", "user/{id}", "system", 200]
     *                  ["post", "user", "admin", 200]
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
            $param = $this->_userData();
        } elseif ($method === 'get' && $uri === 'user/{id}') {
            $user = factory(User::class)->create($this->_userData());
            $uri = 'user/'.$user->getHashedId();
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

    /**
     * @test
     */
    public function getUserWithWrongHashedId()
    {
        $this->loggedInAs();

        $hashedId = factory(User::class)->create()->getHashedId();

        // remove last char
        $id = substr($hashedId, 0, strlen($hashedId) - 1);

        $this->get(route('backend.user.show', ['id' => $id]));
        $this->assertResponseStatus(404);
    }

    /**
     * @test
     */
    public function getNoneExistedUser()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();

        $hashedId = $user->getHashedId();

        $user->delete();

        $this->get(route('backend.user.show', ['id' => $hashedId]));
        $this->assertResponseStatus(404);
    }
}
