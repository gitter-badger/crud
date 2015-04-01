<?php
/**
 * Created by IntelliJ IDEA.
 * User: Meki
 * Date: 2015.03.30.
 * Time: 22:40
 */

namespace BlackfyreStudio\CRUD;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Str;

class CRUDProvider extends ServiceProvider {
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->setupDependencies();
    }

    public function boot() {

        /*
         * Setting up view for publishing
         */
        $viewPath = __DIR__.'/../views';
        $this->publishes([$viewPath => base_path('resources/views/vendor/crud')], 'views');
        $this->loadViewsFrom($viewPath, 'crud');

        /*
         * Setting up asset publishing (css, javascript, fonts, images, ...)
         */
        $publicPath = __DIR__.'/../public';
        $this->publishes([$publicPath => public_path('vendor/blackfyrestudio/crud')], 'public');

        /*
         * Setting up config files for publishing
         */
        $configPath = __DIR__ . '/../config/';
        $this->publishes([$configPath=>config_path('crud.php')],'config');
        $this->mergeConfigFrom($configPath . 'crud.php','crud');

        /*
         * Setting up translations
         */

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'crud');

        \Route::group([
            'prefix' => \Config::get('crud.uri')
        ], function() {

            \Route::get('/',[
                'as'=>'crud.home',
                'uses'=>'BlackfyreStudio\CRUD\DashboardController@index'
            ]);

            \Route::post('slugger',[
                'as'=>'crud.slugger',
                function() {
                    return \Response::json(['response'=>Str::slug(\Input::get('toSlug'))]);
                }
            ]);

        });
    }

    private function setupDependencies() {
        /*
         * Registering dependencies, so the user won't have to
         */
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('GrahamCampbell\Markdown\MarkdownServiceProvider');

        /*
         * Adding aliases so the user won't have to
         */
        $loader = AliasLoader::getInstance();
        $loader->alias('InterventionImage','Intervention\Image\Facades\Image');
        $loader->alias('Markdown','GrahamCampbell\Markdown\Facades\Markdown');
    }
}