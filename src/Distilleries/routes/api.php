<?php

$router->group(array('middleware' => 'auth'), function() use($router)
{
    $router->group(array('middleware' => 'permission'), function() use($router)
    {
        $router->controller('template', 'Api\TemplateController');
    });
});