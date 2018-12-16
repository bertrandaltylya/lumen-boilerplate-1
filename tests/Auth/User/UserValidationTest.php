<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/13/18
 * Time: 10:03 PM
 */

namespace Tests\Auth\User;

use App\Models\Auth\User\User;
use Tests\TestCase;

class UserValidationTest extends TestCase
{
    /**
     * @test
     */
    public function uniqueEmail()
    {
        $this->loggedInAs();

        $uniqueEmail = 'my@email.com';

        factory(User::class)->create([
            'email' => $uniqueEmail,
        ]);

        $user = factory(User::class)->create([
            'email' => 'xx' . $uniqueEmail,
        ]);

        $this->put(route('backend.user.update', ['id' => $user->getHashedId()]), [
            'email' => $uniqueEmail,
        ]);

        $this->assertResponseStatus(422);
        $this->seeJson([
            'email' => ['The email has already been taken.'],
        ]);
    }
}