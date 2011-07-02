<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Qanda Tags Controller.
 *
 * @package Qanda
 * @subpackage Tag
 */

/**
 * Qanda Tags Controller for all Tag Related Tasks.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage Tag
 * @uses Website_Controller Extends class
 */
class Tags_Controller extends Website_Controller
{

    /**
     * Tags Controller Constructor
     */
    public function __construct()
    {
        parent::__construct(); //-- This must be included
    }

    //----------------------- PUBLIC METHODS --------------------------//

    /**
     * Show a List of Tags
     * 
     * @param string $filler
     * @param int $page_number
     * @param string $order_by
     * @param int $page_size
     * @uses Tag_Model::get_active_tags()
     */
    public function browse($filler='page', $page_number=1, $order_by='active', $page_size=25)
    {
        //TODO: Error handling
        $tags = ORM::factory('tag')->get_active_tags($page_number, $page_size);

        //-- Render View
        $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/tag_list')
            ->bind('tags', $tags);
    }

    //----------------------- PRIVATE METHODS --------------------------//

    //----------------------- PLACE HOLDERS --------------------------//

    /**
     * Edit an Existing Tag
     */
    public function edit($tag_id)
    {
        $this->template->content = "Method Not Implemented Yet.";
    }

    /**
     * Merge an Existing Tag into another Tag
     *
     * There will be no 'delete' method for tags. Merge will be the
     * only method to remove them.
     */
    public function merge($unwanted_tag_id, $merge_tag_id)
    {
        $this->template->content = "Method Not Implemented Yet.";
    }

}//END class