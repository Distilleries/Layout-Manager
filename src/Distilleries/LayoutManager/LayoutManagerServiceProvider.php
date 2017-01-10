<?php namespace Distilleries\LayoutManager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class LayoutManagerServiceProvider extends ServiceProvider
{


  

    protected $router;


    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views', 'layout-manager');
        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'layout-manager');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->publishes([
            __DIR__ . '/../../config/config.php' => config_path('layout-manager.php')
        ]);
        $this->publishes([
            __DIR__ . '/../../views' => base_path('resources/views/vendor/layout-manager'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../../resources/assets' => base_path('resources/assets/vendor/layout-manager'),
        ], 'views');
    }


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

    public function alias() {

        AliasLoader::getInstance()->alias(
            'View',
            'Illuminate\Support\Facades\View'
        );

        AliasLoader::getInstance()->alias(
            'FormBuilder',
            'Distilleries\FormBuilder\Facades\FormBuilder'
        );

        AliasLoader::getInstance()->alias(
            'Datatable',
            'Distilleries\DatatableBuilder\Facades\DatatableBuilder'
        );
        
        AliasLoader::getInstance()->alias(
            'Route',
            'Illuminate\Support\Facades\Route'
        );
    }
}