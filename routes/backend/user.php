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
    $router->put('/{id}/edit', [
        'as' => 'update',
        'uses' => 'UserController@update',
    ]);
    $router->delete('/{id}', [
        'as' => 'destroy',
        'uses' => 'UserController@destroy',
    ]);

    // status
    $router->put('/{id}/restore', [
        'as' => 'restore',
        'uses' => 'UserStatusController@restore',
    ]);
    $router->put('/{id}/purge', [
        'as' => 'purge',
        'uses' => 'UserStatusController@purge',
    ]);
});