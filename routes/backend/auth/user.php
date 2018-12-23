<?php
$router->group([
    'namespace' => 'Auth\User',
    'as' => 'user',
], function () use ($router) {


    // Access
    $router->get('/profile', [
        'as' => 'profile',
        'uses' => 'UserAccessController@profile',
    ]);

    $router->group([
        'prefix' => 'user',
    ], function () use ($router) {

        // deletes
        $router->get('/deleted', [
            'as' => 'deleted',
            'uses' => 'UserDeleteController@deleted',
        ]);
        $router->put('/{id}/restore', [
            'as' => 'restore',
            'uses' => 'UserDeleteController@restore',
        ]);
        $router->delete('/{id}/purge', [
            'as' => 'purge',
            'uses' => 'UserDeleteController@purge',
        ]);

        // resources
        $router->get('/', [
            'as' => 'index',
            'uses' => 'UserController@index',
        ]);
        $router->post('/', [
            'as' => 'store',
            'uses' => 'UserController@store',
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
    });
});