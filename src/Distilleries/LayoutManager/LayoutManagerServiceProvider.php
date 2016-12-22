<?php namespace Distilleries\LayoutManager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class LayoutManagerServiceProvider extends ServiceProvider {


    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Distilleries\LayoutManager\Http\Controllers';


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/config.php',
            'layout-manager'
        );
    }

    public function boot(Router $router)
    {
        parent::boot($router);
        $this->loadViewsFrom(__DIR__.'/../../views', 'layout-manager');
        $this->loadTranslationsFrom(__DIR__.'/../../lang', 'layout-manager');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->publishes([
            __DIR__.'/../../config/config.php' => config_path('layout-manager.php')
        ]);
        $this->publishes([
            __DIR__.'/../../views'             => base_path('resources/views/vendor/layout-manager'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../resources/assets'             => base_path('resources/assets/vendor/layout-manager'),
        ], 'views');
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function()
        {
            require __DIR__ . '/Http/routes.php';
        });
    }
}