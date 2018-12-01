<?php
$router->group([
    'namespace' => 'Auth\User',
    'prefix' => 'user',
    'as' => 'user',
], function () use ($router) {
    $router->get('/', [
        'as' => 'index',
        'uses' => 'UserController@index',
    ]);
    $router->post('/', [
        'as' => 'store',
        'uses' => 'UserController@create',
    ]);
    $router->get('/{id}', [
        'as' => 'show',
        'uses' => 'UserController@show',
    ]);
});