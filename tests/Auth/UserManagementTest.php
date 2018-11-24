<?php

namespace Tests;

use Symfony\Component\HttpFoundation\Response;

class UserManagementTest extends TestCase
{
    /**
     * @test
     */
    public function cannotAccessByGuest()
    {
        $this->get('/user');
        $this->assertResponseStatus(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @test
     */
    public function cannotAccessByNoRoles()
    {
        $this->loggedInAs('user');
        $this->get('/user');
        $this->assertResponseStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * @test
     * @testWith        ["system"]
     *                  ["admin"]
     */
    public function canAccessIndex($roleName)
    {
        $this->loggedInAs($roleName);
        $this->get('/user');
        $this->assertResponseOk();
    }
}
