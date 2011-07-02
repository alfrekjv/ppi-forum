<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Qanda Model for Questions and Answers.
 *
 * @package Qanda
 * @subpackage Post
 */

/**
 * Qanda Posts Model.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage Post
 * @uses ORM Extends class
 */
class Post_Model extends ORM
{
    protected $belongs_to = array('user');
    protected $has_and_belongs_to_many = array('tags');

    public $answers = array();
    public $comments = array();
    
    //----------------------- PUBLIC METHODS --------------------------//

    /**
     * Populate Answers for Current Question
     */
     public function load_answers()
     {
         $this->answers = $this
            ->where('is_deleted', 0)
            ->where('parent_id', $this->id)
            ->where('type', 'answer')
            ->orderby('last_activity_date', 'desc')
            ->orderby('date_created', 'desc')
            ->find_all();
     }

    /**
     * Determine Whether There are Answers to this Question
     *
     * @return bool
     */
     public function has_answers()
     {
         return (count($this->answers) > 0) ? true : false;
     }

    /**
     * Populate Comments for Current Post
     */
     public function load_comments()
     {
         $this->comments = $this
            ->where('is_deleted', 0)
            ->where('parent_id', $this->id)
            ->where('type', 'comment')
            ->orderby('date_created', 'asc')
            ->find_all();
     }

    /**
     * Determine Whether There are Comments to this Post
     *
     * @return bool
     */
     public function has_comments()
     {
         return (count($this->comments) > 0) ? true : false;
     }

    /**
     * Determine Whether There are Blurb to this Post
     *
     * @return bool
     */
     public function has_content()
     {
         return (count($this->content) > 0) ? true : false;
     }

    /**
     * Print out the truncated content (aka/ excerpt)
     *
     * @return string
     */
     public function excerpt()
     {
         echo $this->get_excerpt();
     }

    /**
     * Provide the truncated content of this post
     *
     * @return string
     */
     public function get_excerpt()
     {
         return text::truncate($this->content, 250, ' ...', false);
     }

    /**
     * Provide the summarised vote count value
     *
     * @return int
     */
     public function get_vote_count()
     {
         return $this->up_vote_count - $this->down_vote_count;
     }

    /**
     * Provide the vote label with plural consideration
     *
     * @return string
     */
     public function get_vote_label()
     {
         return inflector::plural('vote', $this->get_vote_count());
     }

    /**
     * Provide the answer count value
     *
     * @return int
     */
     public function get_answer_count()
     {
         return $this->answer_count;
     }

    /**
     * Provide the answer label with plural consideration
     *
     * @return string
     */
     public function get_answer_label()
     {
         return inflector::plural('answer', $this->get_answer_count());
     }

    /**
     * Provide the view count value
     *
     * @return int
     */
     public function get_view_count()
     {
         return $this->view_count;
     }

    /**
     * Provide the view label with plural consideration
     *
     * @return string
     */
     public function get_view_label()
     {
         return inflector::plural('view', $this->get_view_count());
     }

    //----------------------- STATIC METHODS --------------------------//

    /**
     * List of Active Questions
     *
     * @param int $page_number
     * @param int $page_size
     * @return ORM_Iterator
     * @static
     */
    public function get_active_questions($page_number, $page_size)
    {
        //-- Local Variables
        $limit = $page_size;
        $offset = ($page_number-1) * $page_size;

        //-- Query
        $questions = $this
            ->where('is_deleted', 0)
            ->where('type', 'question')
            ->orderby('last_activity_date', 'desc')
            ->orderby('date_created', 'desc')
            ->find_all($limit, $offset);

        //-- Output
        return $questions;
    }

    /**
     * Count Questions
     *
     * @return int
     * @static
     */
    public function count_all_questions()
    {
        //-- Query
        $count = $this
            ->where('is_deleted', 0)
            ->where('type', 'question')
            ->count_all();
        
        //-- Output
        return $count;
    }

    /**
     * List Unanswered Questions
     *
     * @param int $page_number
     * @param int $page_size
     * @return ORM_Iterator
     * @static
     */
    public function get_unanswered_questions($page_number, $page_size)
    {
        //-- Local Variables
        $limit = $page_size;
        $offset = ($page_number-1) * $page_size;

        //-- Query
        $questions = $this
            ->where('is_deleted', 0)
            ->where('type', 'question')
            ->where('answer_count', 0)
            ->orderby('last_activity_date', 'desc')
            ->orderby('date_created', 'desc')
            ->find_all($limit, $offset);

        //-- Output
        return $questions;
    }

    /**
     * Count Unanswered Questions
     *
     * @return int
     * @static
     */
    public function count_unanswered_questions()
    {
        //-- Query
        $count = $this
            ->where('is_deleted', 0)
            ->where('type', 'question')
            ->where('answer_count', 0)
            ->count_all();
        
        //-- Output
        return $count;
    }

    /**
     * List Questions with Specified Tag
     *
     * @param int $tag_id
     * @param int $page_number
     * @param int $page_size
     * @return ORM_Iterator
     * @static
     */
    public function get_questions_by_tag($tag_id, $page_number, $page_size)
    {
        //-- Local Variables
        $limit = $page_size;
        $offset = ($page_number-1) * $page_size;

        //-- Find posts that contain this tag
        $posts_tags = ORM::factory('posts_tag')
            ->where('tag_id', $tag_id)
            ->orderby('post_id', 'asc')
            ->find_all();

        $post_ids = array();
        foreach($posts_tags as $posts_tag)
        {
            $post_ids[] = $posts_tag->post_id;
        }

        if(count($post_ids) == 0)
            return array();

        //-- Find questions with within those post IDs and sort by last activity DESC
        $questions = $this
            ->where('is_deleted', 0)
            ->where('type', 'question')
            ->in('id', $post_ids)
            ->orderby('last_activity_date', 'desc')
            ->orderby('date_created', 'desc')
            ->find_all($limit, $offset);

        //-- Output
        return $questions;
    }

    /**
     * Count Questions with Specified Tag
     *
     * @param int $tag_id
     * @return int
     * @static
     */
    public function count_questions_by_tag($tag_id)
    {
        //-- Initialise Model
        $tag = ORM::factory('tag', $tag_id);
        
        //-- Find posts that contain this tag
        $posts_tags = ORM::factory('posts_tag')
            ->where('tag_id', $tag->id)
            ->orderby('post_id', 'asc')
            ->find_all();

        $post_ids = array();
        foreach($posts_tags as $posts_tag)
        {
            $post_ids[] = $posts_tag->post_id;
        }

        if(count($post_ids) == 0)
            return 0;

        //-- Find questions with within those post IDs and sort by last activity DESC
        $count = $this
            ->where('is_deleted', 0)
            ->where('type', 'question')
            ->in('id', $post_ids)
            ->count_all();

        //-- HOOK: Update Tag->post_count
        if($tag->post_count != $count)
        {
            $tag->post_count = $count;
            $tag->save();
        }

        //-- Output
        return $count;
    }

    /**
     * List Questions Asked by Specified User
     *
     * @param int $user_id
     * @return ORM_Iterator
     * @static
     */
    public function get_asked_questions($user_id)
    {
        //-- Local Variables

        //-- Query
        $questions = $this
            ->where('is_deleted', 0)
            ->where('type', 'question')
            ->where('user_id', $user_id)
            ->orderby('date_created', 'desc')
            ->find_all();

        //-- Output
        return $questions;
    }

    /**
     * List Questions Answered by Specified User
     *
     * @param int $user_id
     * @return ORM_Iterator
     * @static
     */
    public function get_answered_questions($user_id)
    {
        //-- Local Variables

        //-- Query
        $answers = $this
            ->where('is_deleted', 0)
            ->where('type', 'answer')
            ->where('user_id', $user_id)
            ->find_all();

        //--
        $answer_ids = array();
        foreach($answers as $answer)
        {
            $answer_ids[] = $answer->parent_id;
        }
        if(count($answer_ids) <= 0)
        {//HACK: So that the array is non-empty and won't trigger syntax error when perform query
            $answer_ids[] = -1;
        }

        //--
        //TODO: Order by Answering date
        $answered_questions = $this
            ->in('id', $answer_ids)
            ->find_all();

        //-- Output
        return $answered_questions;
    }

    /**
     * List Answers of Specified Question
     *
     * @param int $question_id
     * @param int $page_number
     * @param int $page_size
     * @return ORM_Iterator
     * @static
     */
    public function get_all_answers($question_id, $page_number, $page_size)
    {
        //-- Local Variables
        $limit = $page_size;
        $offset = ($page_number-1) * $page_size;

        //-- Query
        $answers = $this
            ->where('is_deleted', 0)
            ->where('parent_id', $question_id)
            ->where('type', 'answer')
            ->orderby('last_activity_date', 'desc')
            ->orderby('date_created', 'desc')
            ->find_all($limit, $offset);

        //-- Output
        return $answers;
    }

    /**
     * Count Number of Answers to a Specified Question
     *
     * @param int $question_id
     * @return int
     * @static
     */
    public function count_all_answers($question_id)
    {
        //-- Query
        $count = $this
            ->where('is_deleted', 0)
            ->where('parent_id', $question_id)
            ->where('type', 'answer')
            ->count_all();

        //-- Output
        return $count;
    }

    /**
     * Create an Answer to Specified Question
     *
     * @param Validation_Object $post
     * @static
     */
    public function create_answer($post)
    {
        //-- Local Variables
        $body           = $post->post_body;
        $question_id    = $post->target_post_id; //***travo20100327: Used to be: $post->question_id

        //-- Sanitize
        if($body == '')
            throw new Exception('Body field is required');
        if($question_id == 0 || $question_id == '')
            throw new Exception('Question ID is not provided');

        //TODO: Break this to a seperate concern
        //-- Check Authentication
        $authentic = Auth::factory();
        if ($authentic->logged_in())
        {//-- Find Current User ID
            //TODO: Try catch this
            $user = $authentic->get_user();
        }
        else
        {//TODO: Guest user management should be a seperate concern

            //TODO: Check permission for answering this question


            //TODO: Check if Existing Guest already in Database


            //-- Register as Guest
            $user               = ORM::factory('user');
            $user->display_name = $post->display_name;
            //$user->username     = 'guest-'.strtolower(text::random('alnum', 4)); //TODO: Use helper to generate guest account name
            $user->username     = url::title($user->display_name).'-'.strtolower(text::random('alnum', 4));
            $user->password     = $user->username;
            $user->email        = $post->email;
            //TODO: last activity date
            //TODO: last ip address
            //TODO: last user agent
            //TODO: question count
            $user->date_created = date::timestamp();
            $user->created_by   = 'post::create_question';
            $user->add(ORM::factory('role', 'guest'));
            try
            {
                $user->save();
            }
            catch (Exception $ex)
            {
                throw new Exception('Failed to create guest user account. Caught exception: '.$ex->getMessage());
            }
        }

        //-- Save Answer
        $answer                 = ORM::factory('post');
        $answer->user_id        = $user->id;
        $answer->parent_id      = $question_id;
        $answer->content        = $body;
        $answer->type           = 'answer';
        $answer->date_created   = date::timestamp();
        $answer->created_by     = 'question::detail';
        //TODO: Needs to handle exception
        $success                = $answer->save();


        if($success == TRUE)
        {
            //-- Update Question's answer count and last activity date
            $question = ORM::factory('post', $question_id);
            $question->answer_count        += 1;
            $question->last_activity_date   = date::timestamp();
            $question->date_modified        = date::timestamp();
            $question->modified_by          = 'post::create_answer';
            $question->save();
            
            //-- Update User's answer count
            $user->answer_count        += 1;
            //-- Update User's Last Acitivty
            $user->last_activity_date   = date::timestamp();
            $user->last_ip_address      = client::ip_address();
            $user->last_user_agent      = Kohana::user_agent();
            $user->save();

            //-- Add User activity
            ORM::factory('activity')->log($user->id, 'create', 'post', $answer->id);

            //TODO: Apply exception when 1) answer owner is also the question owner or 2) answer owner already has answer to this question
            //-- Update User's tag involvement
            ORM::factory('tags_user')->tag_answer($user->id, $question->id, $answer->id);

            //-- Output
            return $answer->id;
        }
        else
            throw new Exception('Failed to save answer.');
    }

    /**
     * Create a New Question
     *
     * @param Validation_Object $post
     * @return int Id of the newly created question
     * @static
     */
    public function create_question($post)
    {
        //-- Local Variables
        $title          = $post->post_title;
        $body           = $post->post_body;
        $tags_string    = $post->post_tags;
        

        //-- Sanitize
        if($title == '')
            throw new Exception('Title field is required');
        if($tags_string == '')
            throw new Exception('Tags are not provided');

        //-- Setup User Details
        $authentic = Auth::factory();
        if ($authentic->logged_in())
        {//-- Check Authentication
            $user = $authentic->get_user();
        }
        else
        {//TODO: Guest user management should be a seperate concern

            //TODO: Check permission for asking question

            
            //TODO: Check if Existing Guest already in Database

            
            //-- Register as Guest
            $user               = ORM::factory('user');
            $user->display_name = $post->display_name;
            $user->username     = url::title($user->display_name).'-'.strtolower(text::random('alnum', 4));
            $user->password     = $user->username;
            $user->email        = $post->email;
            $user->date_created = date::timestamp();
            $user->created_by   = 'post::create_question';
            $user->add(ORM::factory('role', 'guest'));
            try
            {
                $user->save();
            }
            catch (Exception $ex)
            {
                throw new Exception('Failed to create guest user account. Caught exception: '.$ex->getMessage());
            }
        }

        //-- Save Question
        $question               = ORM::factory('post');
        $question->user_id      = $user->id;
        $question->title        = $title;
        $question->slug         = url::title($title);
        $question->content      = $body;
        $question->type         = 'question';
        $question->last_activity_date = date::timestamp();
        $question->date_created = date::timestamp();
        $question->created_by   = 'post::create_question';

        //TODO: Tag management should be a seperate concern

        //TODO: Need to handle max tags per post

        //TODO: Sanitize

        $tags = explode(',', $tags_string);
        foreach($tags as $tag_name)
        {
            $tag_name = trim($tag_name);

            //-- Sanitize
            if($tag_name == '')
                continue;
            
            $tag_slug = url::title($tag_name);

            //-- Get tag ID (check if it exist)
            $tag = ORM::factory('tag')->where('slug', $tag_slug)
                ->find();

            if($tag->id == 0)
            {
                $tag->name          = $tag_name;
                $tag->slug          = $tag_slug;
                $tag->post_count    = 1;
                $tag->date_created  = date::timestamp();
                $tag->created_by    = 'post::create_question';
                try
                {
                    $tag->save();
                }
                catch(Exception $ex)
                {
                    throw new Exception('Failed to create new tag. Caught exception: '.$ex->getMessage());
                }
            }
            else if($tag->is_deleted == 1)
            {//-- Revitalise deleted tag
                $tag->is_deleted    = 0;
                $tag->post_count    = 1;
                $tag->date_modified = date::timestamp();
                $tag->modified_by   = 'post::create_question';
                try
                {
                    $tag->save();
                }
                catch(Exception $ex)
                {
                    throw new Exception('Failed to update existing tag. Caught exception: '.$ex->getMessage());
                }
            }
            else
            {//-- Increment Tag count
                $tag->post_count   += 1;
                $tag->date_modified = date::timestamp();
                $tag->modified_by   = 'post::create_question';
                try
                {
                    $tag->save();
                }
                catch(Exception $ex)
                {
                    throw new Exception('Failed to update existing tag. Caught exception: '.$ex->getMessage());
                }
            }

            //-- User Tag Involvement
            ORM::factory('tag')->set_user_involvement($tag->id, $user->id);

            //-- Add Tag to Qustion
            //TODO: Needs to handle exception
            $question->add(ORM::factory('tag', $tag->id));
        }

        //-- Save Question
        //TODO: Needs to handle exception
        $success = $question->save();

        if($success == TRUE)
        {
            //-- Increase User's Question Count
            $user->question_count      += 1;
            //-- Update User's Last Acitivty
            $user->last_activity_date   = date::timestamp();
            $user->last_ip_address      = client::ip_address();
            $user->last_user_agent      = Kohana::user_agent();
            $user->save();

            //-- Output
            return $question->id;
        }
        else
            throw new Exception('Failed to save question.');
    }


    /**
     * Create a Comment to Specified Question/Answer
     *
     * @param Validation_Object $post
     * @static
     */
    public function create_comment($post)
    {
        //-- Local Variables
        $body           = $post->post_body;
        $post_parent_id = $post->target_post_id;

        //-- Sanitize
        if($body == '')
            throw new Exception('Body field is required');
        if($post_parent_id == 0 || $post_parent_id == '')
            throw new Exception('Parent Post ID is not provided');

        //TODO: Break this to a seperate concern
        //-- Check Authentication
        $authentic = Auth::factory();
        if ($authentic->logged_in())
        {//-- Find Current User ID
            //TODO: Try catch this
            $user = $authentic->get_user();
        }
        else
        {//TODO: Guest user management should be a seperate concern

            //TODO: Check permission for answering this question


            //TODO: Check if Existing Guest already in Database


            //-- Register as Guest
            $user               = ORM::factory('user');
            $user->display_name = $post->display_name;
            //$user->username     = 'guest-'.strtolower(text::random('alnum', 4)); //TODO: Use helper to generate guest account name
            $user->username     = url::title($user->display_name).'-'.strtolower(text::random('alnum', 4));
            $user->password     = $user->username;
            $user->email        = $post->email;
            //TODO: last activity date
            //TODO: last ip address
            //TODO: last user agent
            //TODO: question count
            $user->date_created = date::timestamp();
            $user->created_by   = 'post::create_question';
            $user->add(ORM::factory('role', 'guest'));
            try
            {
                $user->save();
            }
            catch (Exception $ex)
            {
                throw new Exception('Failed to create guest user account. Caught exception: '.$ex->getMessage());
            }
        }

        //-- Save Comment
        $comment                = ORM::factory('post');
        $comment->user_id       = $user->id;
        $comment->parent_id     = $post_parent_id;
        $comment->content       = $body;
        $comment->type          = 'comment';
        $comment->date_created  = date::timestamp();
        $comment->created_by    = 'post::create_comment';
        //TODO: Needs to handle exception
        $success                = $comment->save();

        if($success == TRUE)
        {
            //-- Add User activity
            ORM::factory('activity')->log($user->id, 'create', 'post', $comment->id);

            //-- Update User's Last Activity
            $user->last_activity_date   = date::timestamp();
            $user->last_ip_address      = client::ip_address();
            $user->last_user_agent      = Kohana::user_agent();
            $user->save();

            //-- Update Posts Comment Count
            $post = ORM::factory('post', $post_parent_id);
            $post->comment_count += 1;
            $post->save();

            //-- Output
            return $comment->id;
        }
        else
            throw new Exception('Failed to save answer.');
    }

    /**
     * Cast a Up Vote to a Question or Answer
     *
     * @param int $post_id
     * @static
     */
    public function vote_up($post_id)
    {
        //-- Authentic User
        $authentic = Auth::factory();
        if ($authentic->logged_in())
        {//-- Find Current User ID
            //TODO: Try catch this
            $user = $authentic->get_user();
        }
        else
            throw new Exception('User has not yet authenticated.');

        //-- Verify Question/Answer
        $post = ORM::factory('post', $post_id);
        if($post->id == 0)
            throw new Exception('Post ID '.$post_id.' not found.');

        //-- Initialise Activity Log
        $action_key = 'vote_up';

        //-- Check Activity Already Exist
        if(ORM::factory('activity')->has_log($user->id, $action_key, 'post', $post_id))
            throw new Exception('User '.$user->id.' has already '.$action_key.' this post.');

        //-- Increase Up Vote Count
        $post->up_vote_count   += 1;
        $post->date_modified    = date::timestamp();
        $post->modified_by      = 'post::vote_up';
        $post->save();

        //-- Increment Author's Score
        $reputation_score   = 10;
        ORM::factory('user')->adjust_reputation($post->user_id, $reputation_score);

        //-- Increment Caster's Cast Count
        ORM::factory('user')->increment_up_vote_casted($user->id);

        //-- Log activity
        ORM::factory('activity')->log($user->id, $action_key, 'post', $post_id);

        //-- Increase User's Down Vote Cast Count
        $user->down_vote_casted    += 1;
        //-- Update User's Last Activity
        $user->last_activity_date   = date::timestamp();
        $user->last_ip_address      = client::ip_address();
        $user->last_user_agent      = Kohana::user_agent();
        $user->save();
    }

    /**
     * Cast a Down Vote to a Question or Answer
     *
     * @param int $post_id
     * @static
     */
    public function vote_down($post_id)
    {
        //-- Authentic User
        $authentic = Auth::factory();
        if ($authentic->logged_in())
        {//-- Find Current User ID
            //TODO: Try catch this
            $user = $authentic->get_user();
        }
        else
            throw new Exception('User has not yet authenticated.');

        //-- Verify Question/Answer
        $post = ORM::factory('post', $post_id);
        if($post->id == 0)
            throw new Exception('Post ID '.$post_id.' not found.');

        //-- Initialise Activity Log
        $action_key = 'vote_down';

        //-- Check Activity Already Exist
        if(ORM::factory('activity')->has_log($user->id, $action_key, 'post', $post_id))
            throw new Exception('User '.$user->id.' has already '.$action_key.' this post.');

        //-- Increase Down Vote Count
        $post->down_vote_count += 1;
        $post->date_modified    = date::timestamp();
        $post->modified_by      = 'post::vote_down';
        $post->save();

        //-- Increment Author's Score
        $reputation_score   = -2;
        ORM::factory('user')->adjust_reputation($post->user_id, $reputation_score);

        //-- Increment Caster's Cast Count
        ORM::factory('user')->increment_down_vote_casted($user->id);

        //-- Log activity
        ORM::factory('activity')->log($user->id, $action_key, 'post', $post_id);

        //-- Increase User's Down Vote Cast Count
        $user->down_vote_casted    += 1;
        //-- Update User's Last Activity
        $user->last_activity_date   = date::timestamp();
        $user->last_ip_address      = client::ip_address();
        $user->last_user_agent      = Kohana::user_agent();
        $user->save();
    }

    /**
     * Follow a Question
     *
     * @param int $question_id
     * @static
     */
    public function follow($question_id)
    {
        //-- Authentic User
        $authentic = Auth::factory();
        if ($authentic->logged_in())
        {//-- Find Current User ID
            //TODO: Try catch this
            $user = $authentic->get_user();
        }
        else
            throw new Exception('User has not yet authenticated.');

        //-- Verify Question
        $question = ORM::factory('post', $question_id);
        if($question->id == 0)
            throw new Exception('Question ID '.$question_id.' not found.');

        //-- Check Activity Already Exist
        if(ORM::factory('activity')->has_log($user->id, 'follow', 'post', $question_id))
            throw new Exception('User '.$user->id.' has already follow this question.');

        //-- Log activity
        ORM::factory('activity')->log($user->id, 'follow', 'post', $question_id);

        //-- Increase Question's Follow Count
        $question->follow_count    += 1;
        $question->save();
        
        //-- Increase User's Follow Count
        $user->post_followed       += 1;
        //-- Update User's Last Activity
        $user->last_activity_date   = date::timestamp();
        $user->last_ip_address      = client::ip_address();
        $user->last_user_agent      = Kohana::user_agent();
        $user->save();
    }

    /**
     * Accept Specified Answer
     *
     * @param int $answer_id
     * @static
     */
    public function accept_answer($answer_id)
    {
        //-- Validate Answer
        $answer = ORM::factory('post', $answer_id);
        if($answer->id == 0)
        {
            throw new Exception('Failed validating answer. Cannot find answer ID: '.$answer_id);
        }

        //-- Validate Question
        $question = ORM::factory('post', $answer->parent_id);
        if($question->id == 0)
        {
            throw new Exception('Failed validating question. Cannot find the Question to answer ID: '.$answer_id);
        }

        //-- Validate Logged In User
        $authentic = Auth::factory();
        if ($authentic->logged_in())
        {
            $user = $authentic->get_user();
        }
        else
        {
            throw new Exception('You are required to login before accept an answer.');
        }

        //-- Authenticate Current User, make sure current user is same as Question author
        if($user->id != $question->user_id)
        {
            throw new Exception('Authentication Failed. You can only accept answer if it is your question.');
        }

        //-- Verify no Answers has been Previously Accepted
        $has_accepted_answer = ORM::factory('post')->has_accepted_answer($question->id);
        if($has_accepted_answer == true)
        {
            throw new Kohana_User_Exception('Already has Accepted Answer', 'You Already has Accepted Answer for Question ID: '.$question->id);
        }

        //-- Set Answer as accepted
        $answer->status         = 'accepted';
        $answer->date_modified  = date::timestamp();
        $answer->modified_by    = 'post::accept_answer';
        $answer->save();

        //-- Update Question Status (to 'answer-accepted')
        $question->status           = 'answered';
        $question->date_modified    = date::timestamp();
        $question->modified_by      = 'post::accept_answer';
        $question->save();

        //-- Update User's Last Activity
        $user->last_activity_date   = date::timestamp();
        $user->last_ip_address      = client::ip_address();
        $user->last_user_agent      = Kohana::user_agent();
        $user->save();

        //-- Update Answer Author's Reputation
        $reputation = 5;
        ORM::factory('user')->adjust_reputation($answer->user_id, $reputation);

        //-- Log Question Acceptance Activity (for Question Author)
        ORM::factory('activity')->log($question->user_id, 'answer-accepted', 'post', $question->id);
    }

    /**
     * Check if a Question Already has an Accepted Answer
     *
     * @param int $question_id
     * @return bool
     * @static
     */
     public function has_accepted_answer($question_id)
     {
        //-- Attempt to find Answers
        $count = $this
            ->where('is_deleted', 0)
            ->where('parent_id', $question_id)
            ->where('type', 'answer')
            ->where('status', 'accepted')
            ->count_all();

        return ($count > 0) ? true : false;
     }

    //----------------------- PRIVATE METHODS --------------------------//
     
}//END class