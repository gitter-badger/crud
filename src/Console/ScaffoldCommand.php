<?php
/**
 * Created by IntelliJ IDEA.
 * User: Meki
 * Date: 2015.04.02.
 * Time: 7:12
 */

namespace BlackfyreStudio\CRUD\Console;

use Illuminate\Console\Command;

class ScaffoldCommand extends Command {
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'crud:scaffold';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new set of Models, Controllers and Migrations';

    public function __construct() {
        parent::__construct();
    }
}