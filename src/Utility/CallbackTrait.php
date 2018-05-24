<?php
/**
 * Created by PhpStorm.
 * User: jeffersonsimaogoncalves
 * Date: 23/05/2018
 * Time: 23:33
 */

namespace DataTables\Utility;

use DataTables\Lib\CallbackFunction;

/**
 * Trait CallbackTrait
 *
 * @package DataTables\Utility
 */
trait CallbackTrait
{
    /**
     * Return a Javascript function wrapper to be used in DataTables configuration
     *
     * @param string $name Name of Javascript function to call
     * @param array $args Optional array of arguments to be passed when calling
     * @return \DataTables\Lib\CallbackFunction
     */
    public function callback(string $name, array $args = []): CallbackFunction
    {
        return new CallbackFunction($name, $args);
    }
}
