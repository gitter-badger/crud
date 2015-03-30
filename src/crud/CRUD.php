<?php
/**
 * Created by IntelliJ IDEA.
 * User: Meki
 * Date: 2015.03.30.
 * Time: 22:40
 */

namespace BlackfyreSudio\CRUD;


class CRUD {
    /**
     * Laravel application
     *
     * @var \Illuminate\Foundation\Application
     */
    public $app;

    /**
     * Create a new confide instance.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
    }
}