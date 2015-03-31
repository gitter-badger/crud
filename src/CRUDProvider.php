<?php
/**
 * Created by IntelliJ IDEA.
 * User: Meki
 * Date: 2015.03.30.
 * Time: 22:40
 */

namespace BlackfyreStudio\CRUD;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class CRUDProvider extends ServiceProvider {
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Registering dependencies, so the user won't have to
         */
        $this->app->register('Intervention\Image\ImageServiceProvider');
        $this->app->register('GrahamCampbell\Markdown\MarkdownServiceProvider');

        /*
         * Adding aliases so the user won't have to
         */
        $loader = AliasLoader::getInstance();
        $loader->alias('Image','Intervention\Image\Facades\Image');
        $loader->alias('Markdown','GrahamCampbell\Markdown\Facades\Markdown');
    }
}