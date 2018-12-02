<?php

namespace Tests\Auth;

use App\Models\Auth\User\User;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
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

    /**
     * @test
     */
    public function createUser()
    {
        $this->loggedInAs();

        $this->post(route('backend.user.store'), $this->userData());
        $this->assertResponseStatus(201);

        $data = $this->userData();
        unset($data['password']);

        $this->seeInDatabase((new User)->getTable(), $data);
        $this->seeJson($data);
    }

    /**
     * @test
     */
    public function updateUser()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();

        $this->post(route('backend.user.update', ['id' => $user->getHashedId()]), $this->userData());
        $this->assertResponseOk();

        $data = $this->userData();
        unset($data['password']);

        $this->seeInDatabase((new User)->getTable(), array_merge($data, ['id' => $user->id]));
        $this->seeJson(array_merge($data, ['real_id' => $user->id]));
    }
}
