<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Qanda Answers Controller.
 *
 * @package Qanda
 * @subpackage Answer
 */

/**
 * Qanda Answers Controller for all Answer Related Tasks.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage Answer
 * @uses Website_Controller Extends class
 */
class Answers_Controller extends Website_Controller
{
    
    /**
     * Answers Controller Constructor
     */
    public function __construct()
    {
        parent::__construct(); //-- This must be included
    }

    //----------------------- PUBLIC METHODS --------------------------//

    /**
     * Create a New Answer
     *
     * @uses Post_Model::create_answer()
     */
    public function create()
    {
        if($_POST)
        {//-- Detect a Post Back (ie/ Submitting an Answer)
            //TODO: Validate user input
            $post = Validation::factory($_POST);

            //-- Create Answer
            try
            {
                $answer_id = ORM::factory('post')->create_answer($post);
            }
            catch(Exception $ex)
            {
                throw new Kohana_User_Exception('Fail to Create Answer.', 'Cannot create answer. Caught exception: '.$ex->getMessage());
            }

            //-- Fetch Original Question
            $question   = ORM::factory('post', $post->target_post_id);

            //-- Redirect
            url::redirect('/questions/detail/'.$question->id.'/'.$question->slug);
        }
        else
        {//-- Direct Connection to Action Without a Post Back
            throw new Kohana_User_Exception('Bad Landing.', 'You have been direct to this location incorrectly.');
        }
    }

    /**
     * Up Vote an Answer
     *
     * @param int $answer_id
     * @uses Post_Model::vote_up()
     */
    public function vote_up($answer_id)
    {
        //-- Perform Vote Up
        try
        {
            ORM::factory('post')->vote_up($answer_id);
        }
        catch(Exception $ex)
        {
            throw new Kohana_User_Exception('Fail to Vote Up', 'Cannot vote up answer '.$answer_id.'. Caught exception: '.$ex->getMessage());
        }

        //-- Load Models
        $answer     = ORM::factory('post', $answer_id);
        $question   = ORM::factory('post', $answer->parent_id);

        //-- Redirect
        url::redirect('/questions/detail/'.$question->id.'/'.$question->slug.'#'.$answer_id);
    }

    /**
     * Down Vote an Answer
     *
     * @param int $answer_id
     * @uses Post_Model::vote_down()
     */
    public function vote_down($answer_id)
    {
        //-- Perform Vote Down
        try
        {
            ORM::factory('post')->vote_down($answer_id);
        }
        catch(Exception $ex)
        {
            throw new Kohana_User_Exception('Fail to Vote Up', 'Cannot vote up answer '.$answer_id.'. Caught exception: '.$ex->getMessage());
        }

        //-- Load Models
        $answer     = ORM::factory('post', $answer_id);
        $question   = ORM::factory('post', $answer->parent_id);

        //-- Redirect
        url::redirect('/questions/detail/'.$question->id.'/'.$question->slug.'#'.$answer_id);
    }

    /**
     * Accept an Existing Answer
     *
     * @param int $answer_id
     * @uses Post_Model::has_accepted_answer()
     * @uses User_Model::adjust_reputation()
     * @uses Activity_Model::log()
     */
    public function accept($answer_id)
    {
        //-- Perform Accept Answer
        try
        {
            ORM::factory('post')->accept_answer($answer_id);
        }
        catch(Exception $ex)
        {
            throw new Kohana_User_Exception('Fail to Accept Answer', 'Cannot accept answer ID '.$answer_id.'. Caught exception: '.$ex->getMessage());
        }

        //-- Load Models
        $answer     = ORM::factory('post', $answer_id);
        $question   = ORM::factory('post', $answer->parent_id);

        //-- Redirect
        url::redirect('/questions/detail/'.$question->id.'/'.$question->slug.'#'.$answer->id);
    }

    //----------------------- PLACE HOLDERS --------------------------//

    /**
     * Edit Answers Action
     */
    public function edit($answer_id)
    {
        $this->template->content = "Method Not Implemented Yet.";
    }

    /**
     * Delete Answers Action
     */
    public function delete($answer_id)
    {
        $this->template->content = "Method Not Implemented Yet.";
    }

}//END class