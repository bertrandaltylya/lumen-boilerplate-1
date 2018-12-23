<?php
$router->group([
    'namespace' => 'Auth\Permission',
    'as' => 'permission',
    'prefix' => 'permission',
], function () use ($router) {
    // resources
    $router->get('/', [
        'as' => 'index',
        'uses' => 'PermissionController@index',
    ]);
    $router->get('/{id}', [
        'as' => 'show',
        'uses' => 'PermissionController@show',
    ]);
});