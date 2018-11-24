<?php

namespace Tests;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function example()
    {
        $this->get('/');
        $this->assertEquals($this->app->version(), $this->response->getContent());
    }
}
