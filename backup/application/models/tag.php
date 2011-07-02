<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Qanda Tags Model.
 *
 * @package Qanda
 * @subpackage Tag
 */

/**
 * Qanda Tags Model.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage Tag
 * @uses ORM Extends class
 */
class Tag_Model extends ORM
{
    protected $has_and_belongs_to_many = array('posts');

    //----------------------- PUBLIC METHODS --------------------------//

    //----------------------- STATIC METHODS --------------------------//

    /**
     * List of Active Tags
     *
     * @param int $page_number
     * @param int $page_size
     * @return ORM_Iterator
     * @static
     */
    public function get_active_tags($page_number, $page_size)
    {
        //-- Query
        $tags = $this
            ->where('is_deleted', 0)
            ->where(array('post_count >' => 0))
            ->orderby('post_count', 'desc')
            ->find_all();

        //-- Output
        return $tags;
    }

    /**
     * Find a Tag by its slug
     *
     * @param string $slug
     * @return Tag
     * @static
     */
    public function by_slug($slug)
    {
        //-- Query
        $tag = $this
            ->where('is_deleted', 0)
            ->where('slug', $slug)
            ->orderby('id', 'desc')
            ->find();

        //-- Output
        return $tag;
    }

    /**
     * Set Tag Involvement of User
     *
     * @param int $tag_id
     * @param int $user_id
     * @static
     */
    public function set_user_involvement($tag_id, $user_id)
    {
        //-- Attempt to Fetch Existing Tag Involvement
        $tags_user = ORM::factory('tags_user')
            ->where('tag_id', $tag_id)
            ->where('user_id', $user_id)
            ->where('relation_type', 'involved')
            ->find();

        if($tags_user->id == 0)
        {//-- Create new Tag Involvement
            $tags_user->user_id         = $user_id;
            $tags_user->tag_id          = $tag_id;
            $tags_user->relation_type   = 'involved';
            $tags_user->post_count      = 1;
            $tags_user->date_created    = date::timestamp();
            $tags_user->created_by      = 'tag::set_user_involvement';
            $tags_user->save();
        }
        else
        {
            //-- Check Tag Involvement Status
            if($tags_user->is_deleted == 1)
            {//-- Revitalise it
                $tags_user->post_count      = 1;
                $tags_user->date_modified   = date::timestamp();
                $tags_user->modified_by     = 'tag::set_user_involvement';
                $tags_user->is_deleted      = 0;
                $tags_user->save();
            }
            else
            {//-- Increment Count
                $tags_user->post_count     += 1;
                $tags_user->date_modified   = date::timestamp();
                $tags_user->modified_by     = 'tag::set_user_involvement';
                $tags_user->save();
            }
        }
    }

    /**
     * Get Tags that Specified User Involved it
     *
     * Involvement includes asking questions or anwering questions belongs
     * to those tags
     * 
     * @param int $user_id
     * @static
     */
    public function get_inolved_tags($user_id)
    {
        //-- Get Tag Relations
        $tags_user = ORM::factory('tags_user')
            ->where('user_id', $user_id)
            ->where('relation_type', 'involved')
            ->where('is_deleted', 0)
            ->find_all();

        //-- Extract IDs
        $tag_ids = array();
        foreach($tags_user as $tag_user)
        {
            $tag_ids[] = $tag_user->tag_id;
        }
        if(count($tag_ids) <= 0)
        {//HACK: So that the array is non-empty and won't trigger syntax error when perform query
            $tag_ids[] = -1;
        }
        
        //-- Get Tags
        $tags = ORM::factory('tag')
            ->in('id', $tag_ids)
            ->orderby('name', 'asc')
            ->find_all();
        
        //-- Output
        return $tags;
    }

    //----------------------- PRIVATE METHODS --------------------------//

}//END class