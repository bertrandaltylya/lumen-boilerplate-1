<?php
$router->group([
    'namespace' => 'Auth',
    'prefix' => 'user',
    'as' => 'user',
], function () use ($router) {
    $router->get('/', [
        'as' => 'index',
        'uses' => 'UsersController@index',
    ]);
    $router->post('/', [
        'as' => 'store',
        'uses' => 'UsersController@create',
    ]);
    $router->get('/{id}', [
        'as' => 'show',
        'uses' => 'UsersController@show',
    ]);
});