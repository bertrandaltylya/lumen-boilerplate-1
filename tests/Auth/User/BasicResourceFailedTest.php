<?php

namespace Tests\Auth\User;

use App\Models\Auth\User\User;
use Tests\TestCase;

class BasicResourceFailedTest extends TestCase
{
    /**
     * @test
     */
    public function cannotDeleteSelf()
    {
        $user = $this->loggedInAs();

        $this->delete(route('backend.user.destroy', ['id' => $user->getHashedId()]));

        $this->assertResponseStatus(422);
        $this->seeJson([
            'message' => 'You cannot delete your self.',
        ]);
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
