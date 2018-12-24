<?php
$router->group([
    'namespace' => 'Auth\Role',
    'as' => 'role',
    'prefix' => 'role',
], function () use ($router) {
    // resources
    $router->get('/', [
        'as' => 'index',
        'uses' => 'RoleController@index',
    ]);
    $router->post('/', [
        'as' => 'store',
        'uses' => 'RoleController@store',
    ]);
    $router->get('/{id}', [
        'as' => 'show',
        'uses' => 'RoleController@show',
    ]);
    $router->put('/{id}/edit', [
        'as' => 'update',
        'uses' => 'RoleController@update',
    ]);
    $router->delete('/{id}', [
        'as' => 'destroy',
        'uses' => 'RoleController@destroy',
    ]);
});