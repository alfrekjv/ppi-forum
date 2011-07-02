<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Client Helper Class
 *
 * @package    Qanda
 * @subpackage Helper
 */
class client
{

    /**
     * Find Client IP Address
     *
     * This helper is a modified method from Input::ip_address()
     * 
     * @link    /system/libraries/Input.php
     */
    static public function ip_address()
    {
        //-- Local Variables
        $ip_address = '';

		//-- Server keys that could contain the client IP address
		$keys = array('HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP', 'REMOTE_ADDR');

        //-- Attempt to Find IP
		foreach ($keys as $key)
		{
            if(isset($_SERVER[$key]))
            {
                $ip_address = $_SERVER[$key];
                if($ip_address != '')
                {// An IP address has been found
                    break;
                }
            }
		}

        //-- If Sequenced IPs
        $comma_position = strrpos($ip_address, ',');
		if ($comma_position !== FALSE)
		{
			$ip_address = substr($ip_address, $comma_position + 1);
		}

        //-- Verify Fetched IP
		if ( ! valid::ip($ip_address))
		{
			// Use an empty IP
			$this->ip_address = '0.0.0.0';
		}

        //-- Output
		return $ip_address;
    }
    
}//END class