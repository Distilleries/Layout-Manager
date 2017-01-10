<?php

$router->group(array('middleware' => 'auth'), function() use($router)
{
    $router->group(array('middleware' => 'permission', 'prefix' => config('expendable.admin_base_uri')), function() use($router)
    {
        $router->controller('template', 'Admin\TemplateController');
    });
});

