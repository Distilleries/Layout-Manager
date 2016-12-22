<?php

use \Route as Route;
use \View as View;
use \Auth as Auth;


Route::group(['middleware' => ['api']], function () {

    Route::controller('template', 'Api\TemplateController');

});

Route::group(array('middleware' => 'auth'), function()
{
    Route::group(array('middleware' => 'permission', 'prefix' => config('expendable.admin_base_uri')), function()
    {
        $router->controller('template', 'Admin\TemplateController');
    });
});

