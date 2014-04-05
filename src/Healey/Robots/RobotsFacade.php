<?php namespace Healey\Robots;

use Illuminate\Support\Facades\Facade;

class RobotsFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'robots'; }

}