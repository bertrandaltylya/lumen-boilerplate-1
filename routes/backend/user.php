<?php
$router->group([
    'namespace' => 'Backend\Auth',
    'prefix' => 'user',
], function () use ($router) {
    $router->get('/', 'UsersController@index');
    $router->get('/{userId}', 'UsersController@show');
});