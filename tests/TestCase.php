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
        return require __DIR__.'/../bootstrap/app.php';
    }

    protected function loggedInAsSystem(): User
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        return $user;
    }
}
