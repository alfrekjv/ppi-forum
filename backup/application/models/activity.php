<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Qanda Activity Model.
 *
 * @package Qanda
 * @subpackage Activity
 */

/**
 * Qanda Activity Model.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage Activity
 * @uses ORM Extends class
 */
class Activity_Model extends ORM
{

    //----------------------- PUBLIC METHODS --------------------------//

    //----------------------- STATIC METHODS --------------------------//


    /**
     * Log an User Action
     *
     * @param int $user_id
     * @param string $action_key
     * @param string $object_type
     * @param int $object_id
     * @static
     */
    public function log($user_id, $action_key, $object_type, $object_id)
    {
        //-- Fetch Activity
        $activity = ORM::factory('activity')
            ->where('user_id', $user_id)
            ->where('action_key', $action_key)
            ->where('object_type', $object_type)
            ->where('object_id', $object_id)
            ->find();

        if($activity->id == 0)
        {//-- Insert New Activity
            $activity->user_id      = $user_id;
            $activity->action_key   = $action_key;
            $activity->object_type  = $object_type;
            $activity->object_id    = $object_id;
            $activity->date_created = date::timestamp();
            $activity->created_by   = 'activity::log';
            $activity->save();
        }
        elseif($activity->is_deleted == 1)
        {//-- Revitalise Activity
            $activity->date_modified = date::timestamp();
            $activity->modified_by = 'activity::log';
            $activity->is_deleted = 0;
        }
        else
        {
            //-- Activity already exist, do nothing...
        }

        return;
    }

    /**
     * Check if Log Exists
     *
     * @param int $user_id
     * @param string $action_key
     * @param string $object_type
     * @param int $object_id
     * @static
     */
    public function has_log($user_id, $action_key, $object_type, $object_id)
    {
        //-- Fetch Activity
        $activity = ORM::factory('activity')
            ->where('user_id', $user_id)
            ->where('action_key', $action_key)
            ->where('object_type', $object_type)
            ->where('object_id', $object_id)
            ->where('is_deleted', 0)
            ->find();

        //-- Output
        if($activity->id == 0)
            return false;
        else
            return true;
    }

    //----------------------- PRIVATE METHODS --------------------------//

}//END class