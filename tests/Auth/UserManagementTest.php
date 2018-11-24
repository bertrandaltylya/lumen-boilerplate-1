<?php

namespace Tests;

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
    public function canAccessIndex($roleName, $statusCode)
    {
        if (! empty($roleName)) {
            $this->loggedInAs($roleName);
        }
        $this->get('/user');
        $this->assertResponseStatus($statusCode);
    }
}
