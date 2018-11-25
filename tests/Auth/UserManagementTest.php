<?php

namespace Tests;

use App\Models\Auth\User\User;

class UserManagementTest extends TestCase
{
    /**
     * @param $roleName
     * @param $statusCode
     * @test
     * @testWith        ["system", 200]
     *                  ["admin", 200]
     *                  ["user", 403]
     *                  ["", 401]
     */
    public function access($roleName, $statusCode)
    {
        if (! empty($roleName)) {
            $this->loggedInAs($roleName);
        }

        $user = factory(User::class)->create();

        $endpoints = [
            [
                'm' => 'post',
                'uri' => 'user',
            ],
            [
                'm' => 'get',
                'uri' => 'user',
            ],
            [
                'm' => 'get',
                'uri' => 'user/'.$user->id,
            ],
        ];

        foreach ($endpoints as $endpoint) {
            $param = [];
            if ($endpoint['m'] == 'post' && $endpoint['uri'] == 'user') {
                $param = $this->_userData();
            }
            $this->call($endpoint['m'], $endpoint['uri'], $param);
            $this->assertResponseStatus($statusCode);
        }
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
