<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Qanda Comments Controller.
 *
 * @package Qanda
 * @subpackage Comment
 */

/**
 * Qanda Comments Controller for all Comment Related Tasks.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage Comment
 * @uses Website_Controller Extends class
 */
class Comments_Controller extends Website_Controller
{

    /**
     * Comments Controller Constructor
     */
    public function __construct()
    {
        parent::__construct(); //-- This must be included
    }

    //----------------------- PUBLIC METHODS --------------------------//

    /**
     * Post a comment
     *
     * @uses Post_Model::create_comment()
     */
    public function create($post_type, $post_id=0)
    {
        if($_POST)
        {//-- Detect a Post Back
            $post = Validation::factory($_POST);

            //-- Instantiate New Question Model
            try
            {
                $comment_id     = ORM::factory('post')->create_comment($post);
            }
            catch(Exception $ex)
            {
                //TODO: Instead of throw Kohana Error page, redirect back to this method with error message displayed.
                throw new Kohana_User_Exception('Fail to Create Question', 'Cannot create question. Caught exception: '.$ex->getMessage());
            }

            //-- Load this Comment
            $comment        = ORM::factory('post', $comment_id);

            //-- Load related Models
            if($post_type == 'answer')
            {
                $answer     = ORM::factory('post', $comment->parent_id);
                $question   = ORM::factory('post', $answer->parent_id);
            }
            elseif($post_type == 'question')
            {
                $question   = ORM::factory('post', $comment->parent_id);
            }

            //-- Redirect
            url::redirect('/questions/detail/'.$question->id.'/'.$question->slug);
        }
        else
        {//-- Landing, Show Comment Form
            //-- Obtain models
            if($post_type == 'question')
            {
                //-- Get Question
                $answer     = null;
                $question   = ORM::factory('post', $post_id);
            }
            elseif($post_type == 'answer')
            {
                //-- Get both Question and Answer
                $answer     = ORM::factory('post', $post_id);
                $question   = ORM::factory('post', $answer->parent_id);
            }
            else
            {
                //-- Nothing
            }

            //-- Render View
            $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/comment_create')
                ->bind('answer', $answer)
                ->bind('question', $question)
                ->bind('post_type', $post_type)
                ->bind('target_post_id', $post_id)
                ;
        }
    }

    //----------------------- PLACE HOLDERS --------------------------//

    /**
     * Show comments of a Question or an Answer
     */
    public function show($post_id)
    {
        $this->template->content = "Method Not Implemented Yet.";
    }

    /**
     * Edit an Existing Comment
     */
    public function edit($comment_id)
    {
        $this->template->content = "Method Not Implemented Yet.";
    }

    /**
     * Delete an Existing Comment
     */
    public function delete($comment_id)
    {
        $this->template->content = "Method Not Implemented Yet.";
    }

}//END class