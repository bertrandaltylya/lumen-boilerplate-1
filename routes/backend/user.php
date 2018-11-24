<?php
$router->group([
    'namespace' => 'Backend\Auth',
    'prefix' => 'user',
], function () use ($router) {
    $router->get('/', 'UsersController@index');
});