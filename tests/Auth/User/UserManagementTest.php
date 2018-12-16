<?php

namespace Tests\Auth\User;

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

        $this->put(route('backend.user.update', ['id' => $user->getHashedId()]), $this->userData());
        $this->assertResponseOk();

        $data = $this->userData();
        unset($data['password']);

        $this->seeInDatabase((new User)->getTable(), array_merge($data, ['id' => $user->id]));
        $this->seeJson(array_merge($data, ['real_id' => $user->id]));
    }

    /**
     * @test
     */
    public function destroyUser()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();

        $this->delete(route('backend.user.destroy', ['id' => $user->getHashedId()]));
        $this->assertResponseStatus(204);

        $this->notSeeInDatabase((new User)->getTable(), [
            'id' => $user->id,
            'deleted_at' => null,
        ]);
    }

    /**
     * @test
     */
    public function restoreUser()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();
        $user->delete();

        $this->put(route('backend.user.restore', ['id' => $user->getHashedId()]));
        $this->assertResponseStatus(200);

        $this->seeInDatabase((new User)->getTable(), [
            'id' => $user->id,
            'deleted_at' => null,
        ]);

        $data = $user->fresh()->toArray();
        $this->seeJson([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
        ]);
    }

    /**
     * @test
     */
    public function restoreNoneDeletedUserWillGive404()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();

        $this->put(route('backend.user.restore', ['id' => $user->getHashedId()]));
        $this->assertResponseStatus(404);

    }

    /**
     * @test
     */
    public function purgeUser()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();
        $user->delete();

        $this->delete(route('backend.user.purge', ['id' => $user->getHashedId()]));
        $this->assertResponseStatus(204);

        $this->notSeeInDatabase((new User)->getTable(), [
            'id' => $user->id,
        ]);
    }

    /**
     * @test
     */
    public function purgeNoneDeletedUserWillGive404()
    {
        $this->loggedInAs();

        $user = factory(User::class)->create();

        $this->delete(route('backend.user.purge', ['id' => $user->getHashedId()]));
        $this->assertResponseStatus(404);

    }
}
