<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Date Helper Class Extended.
 *
 * @package    Qanda
 * @subpackage Helper
 */
class date extends date_Core
{

    /**
     * Produce a Standard Timestamp for Database Logging Purpose
     */
    static public function timestamp()
    {
        $output = date('Y-m-d H:i:s', time());
        return $output;
    }
    
}//END class