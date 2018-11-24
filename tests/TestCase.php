<?php

namespace Tests;

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
}
