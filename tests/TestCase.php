<?php

namespace Tests;

use App\Models\Auth\User\User;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use UsesDatabase;

    public function setUp()
    {
        $this->prepareDatabase();
        parent::setUp();
        $this->setUpDatabase(function () {
            $this->artisan('db:seed');
            $this->artisan('passport:install');
        });
        $this->beginDatabaseTransaction();
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }

    protected function loggedInAs(string $roleName = 'system'): User
    {
        if ($roleName == 'user') {
            $user = factory(User::class)->create();
        } else {
            $user = User::role(config("access.role_names.$roleName"))->first();
        }
        $this->actingAs($user);

        return $user;
    }

    protected function userData(): array
    {
        return [
            'first_name' => 'Lloric',
            'last_name' => 'Garcia',
            'email' => 'lloricode@gmail.com',
            'password' => app('hash')->make('secret'),
        ];
    }
}
