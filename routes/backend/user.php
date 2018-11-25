<?php
$router->group([
    'namespace' => 'Auth',
    'prefix' => 'user',
], function () use ($router) {
    $router->get('/', 'UsersController@index');
    $router->post('/', 'UsersController@create');
    $router->get('/{userId}', 'UsersController@show');
});