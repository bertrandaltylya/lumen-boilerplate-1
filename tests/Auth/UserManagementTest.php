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
    public function systemCanAccessIndex()
    {
        $this->loggedInAsSystem();
        $this->get('/user');
        $this->assertResponseOk();
    }
}
