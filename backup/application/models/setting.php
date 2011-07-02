<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Qanda Settings Model.
 *
 * @package Qanda
 * @subpackage Setting
 */

/**
 * Qanda Settings Model.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage Setting
 * @uses ORM Extends class
 */
class Setting_Model extends ORM
{
    //-- Global Variables
    private $dataset = array();
    
    //----------------------- PUBLIC METHODS --------------------------//

    /**
     * Get Value by Setting Name
     *
     * If a setting cannot be found in $dataset array and $load_databae is set
     * to true, then try to find this value from settings table
     *
     * @param string $key
     * @param bool $load_database
     * @return string
     */
    public function get($key, $load_database = false)
    {
        //-- Load for Preloaded Dataset
        if(isset($this->dataset[$key]))
            return $this->dataset[$key];

        if($load_database == true)
        {//-- Attempt to find value from database
            $datarow = $this
                ->where('is_deleted', 0)
                ->where('name', $key)
                ->orderby('date_created', 'desc')
                ->find();

            if($datarow->id != 0)
                return $datarow->value;
        }

        return '';
    }

    /**
     * Fetch and Load All Settings Designated as Autoload
     */
    public function autoload()
    {
        //-- Query
        $settings = $this
            ->where('is_deleted', 0)
            ->where('autoload', 1)
            ->find_all();

        //-- Translate
        foreach($settings as $setting)
        {
            $this->dataset[$setting->name] = $setting->value;
        }
    }
    
    //----------------------- STATIC METHODS --------------------------//

    //----------------------- PRIVATE METHODS --------------------------//

}//END class