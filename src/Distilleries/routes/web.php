<?php

$router->group(['middleware' => ['api']], function () use($router) {

    $router->controller('template', 'Api\TemplateController');

});

$router->group(array('middleware' => 'auth'), function() use($router)
{
    $router->group(array('middleware' => 'permission', 'prefix' => config('expendable.admin_base_uri')), function() use($router)
    {
        $router->controller('template', 'Admin\TemplateController');
    });
});

