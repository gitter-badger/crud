<?php
/**
 * Created by IntelliJ IDEA.
 * User: Meki
 * Date: 2015.03.30.
 * Time: 22:40
 */

namespace BlackfyreStudio\CRUD;

use GrahamCampbell\Markdown\Facades\Markdown;
use GrahamCampbell\Markdown\MarkdownServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;

class CRUDProvider extends ServiceProvider {
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->setupDependencies();
        $this->registerCommands();
    }

    private function registerCommands() {
        $this->app->singleton('command.crud.scaffold', function($app) {
            return $app[Console\ScaffoldCommand::class];
        });

        $this->app->singleton('command.crud.model', function($app) {
            return $app[Console\ModelCommand::class];
        });

        $this->commands([
            'command.crud.scaffold',
            'command.crud.model'
        ]);
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

        if (! $this->app->routesAreCached()) {
            require __DIR__.'/routes.php';
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array([
            'command.crud.scaffold',
            'command.crud.model'
        ]);
    }

    private function setupDependencies() {
        /*
         * Registering dependencies, so the user won't have to
         */
        $this->app->register(ImageServiceProvider::class);
        $this->app->register(MarkdownServiceProvider::class);

        if ($this->app->environment() == 'local') {
            $this->app->register(\Laracasts\Generators\GeneratorsServiceProvider::class);
        }

        /*
         * Adding aliases so the user won't have to
         */
        $loader = AliasLoader::getInstance();
        $loader->alias('InterventionImage', Image::class);
        $loader->alias('Markdown', Markdown::class);
    }
}
