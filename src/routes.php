<?php
/**
 * Created by IntelliJ IDEA.
 * User: mgalicz
 * Date: 3/31/2015
 * Time: 5:21 PM
 */


Route::group([
    'prefix' => Config::get('crud-config.uri')
], function() {

    Route::get('/',[
        'as'=>'crud.home',
        function() {
            return view('crud::master');
        }
    ]);

});