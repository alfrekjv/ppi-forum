<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Qanda Posts-Tag Model.
 *
 * @package Qanda
 * @subpackage Tag
 */

/**
 * Qanda Posts-Tag Model.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage Tag
 * @uses ORM Extends class
 */
class Posts_Tag_Model extends ORM
{
    protected $belongs_to = array('post', 'tag');

    //----------------------- PUBLIC METHODS --------------------------//

    //----------------------- STATIC METHODS --------------------------//

    //----------------------- PRIVATE METHODS --------------------------//

}//END class