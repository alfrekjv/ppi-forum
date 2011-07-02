<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Qanda Tags-User Model.
 *
 * @package Qanda
 * @subpackage Tag
 */

/**
 * Qanda Tags-User Model.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage Tag
 * @uses ORM Extends class
 */
class Tags_User_Model extends ORM
{
    protected $belongs_to = array('user', 'tag');

    //----------------------- PUBLIC METHODS --------------------------//

    //----------------------- STATIC METHODS --------------------------//

    /**
     * Set Tag Involvement to an Answer
     *
     * @param int $user_id
     * @param int $question_id
     * @param int $answer_id
     * @static
     */
    public function tag_answer($user_id, $question_id, $answer_id)
    {
        //-- Check if User Already Participate in this Question...
        // ... by Creating this Question
        $question = ORM::factory('post', $question_id);
        if($question->user_id == $user_id)
            return;

        // ... by Answering this Question before
        //--NOTE: Disregard of deleted Answers as the tag involvement still count
        $answers = ORM::Factory('post')
            ->where('user_id', $user_id)
            ->where('parent_id', $question_id)
            ->where('type', 'answer')
            ->where(array('id !=' => $answer_id))
            ->find_all();
        if(count($answers) > 0)
            return;

        //-- Assign Tag Involvements
        foreach($question->tags as $index => $tag)
        {
            ORM::factory('tag')->set_user_involvement($tag->id, $user_id);
        }
    }

    //----------------------- PRIVATE METHODS --------------------------//

}//END class