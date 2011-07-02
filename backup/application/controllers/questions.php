<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Qanda Questions Controller.
 *
 * @package Qanda
 * @subpackage Question
 */

/**
 * Qanda Questions Controller for all Question Related Tasks.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage Question
 * @uses Website_Controller Extends class
 */
class Questions_Controller extends Website_Controller
{

    /**
     * Questions Controller Constructor
     */
    public function __construct()
    {
        parent::__construct(); //-- This must be included
    }

    //----------------------- PUBLIC METHODS --------------------------//

    /**
     * Browse a List of Questions
     *
     * @param string $filler Does nothing
     * @param int $page_number
     * @param string $order_by
     * @param int $page_size
     * @uses browse_active()
     * @uses browse_unanswered()
     */
    public function browse($filler='page', $page_number=1, $order_by='active', $page_size=10)
    {
        //-- Determine Subcontroller
        switch($order_by)
        {
            case 'active':
                $this->browse_active($page_number, $page_size);
                break;
            case 'unanswered':
                $this->browse_unanswered($page_number, $page_size);
                break;
            default:
                throw new Kohana_User_Exception('Unknown Question Order Type.', "Cannot understand the 'order' value: $order_by");
                break;
        }
    }

    /**
     * View a Question and its Anwers
     *
     * @param int $question_id
     * @param string $slug
     * @param string $filler Does nothing
     * @param int $page_number
     * @param string $order_by
     * @param int $page_size
     * @uses increase_view_count()
     * @uses log_activity()
     * @uses set_pagination()
     * @uses Post_Model::count_all_answers()
     * @uses Post_Model::get_all_answers()
     */
    public function detail($question_id, $slug='', $filler='page', $page_number=1, $order_by='votes', $page_size=25)
    {
        //-- Get Question
        $question = ORM::factory('post', $question_id);

        //-- Event Hooks
        $this->increase_view_count($question_id);

        //-- Get Answers
        $total_items    = ORM::factory('post')->count_all_answers($question_id);
        $answers        = ORM::factory('post')->get_all_answers($question_id, $page_number, $page_size);

        //-- Display 'Accept Answer Button'
        $show_accept_button = false;
        if($this->user->id == $question->user_id)
        {
            $show_accept_button = true;
        }

        //-- Set Pagination
        $this->set_pagination("questions/detail/$question_id/$question->slug", $total_items, $page_size);

        //-- Render View
        $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/question_detail')
            ->bind('question', $question)
            ->bind('answers', $answers)
            ->bind('show_accept_button', $show_accept_button)
            ;
    }

    /**
     * Ask a Question
     *
     * @uses Post_Model::create_question()
     */
    public function create()
    {
        if($_POST)
        {//-- Detect a Post Back
            //TODO: Validate user input
            $post = Validation::factory($_POST);

            //-- Create a New Question
            try
            {
                $question_id = ORM::factory('post')->create_question($post);
            }
            catch(Exception $ex)
            {
                throw new Kohana_User_Exception('Fail to Create Question', 'Cannot create question. Caught exception: '.$ex->getMessage());
            }
            
            //-- Fetch the newly Created Question
            $question = ORM::factory('post', $question_id);
            
            //-- Redirect
            url::redirect('/questions/detail/'.$question->id.'/'.$question->slug);
        }
        else
        {
            //-- Direct Connection to Action Without a Post Back
            $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/question_ask');
        }
    }
    
    /**
     * Up Vote a Question
     *
     * @param int $question_id
     * @uses Post_Model::vote()
     */
    public function vote_up($question_id)
    {
        //-- Perform Vote Up
        try
        {
            ORM::factory('post')->vote_up($question_id);
        }
        catch(Exception $ex)
        {
            throw new Kohana_User_Exception('Fail to Vote Up', 'Cannot vote up question ID: '.$question_id.'. Caught exception: '.$ex->getMessage());
        }

        //-- Fetch Original Question
        $question = ORM::factory('post', $question_id);

        //-- Redirect
        url::redirect('/questions/detail/'.$question->id.'/'.$question->slug);
    }

    /**
     * Down Vote a Question
     *
     * @param int $question_id
     * @uses Post_Model::vote()
     */
    public function vote_down($question_id)
    {
        //-- Perform Vote Down
        try
        {
            ORM::factory('post')->vote_down($question_id);
        }
        catch(Exception $ex)
        {
            throw new Kohana_User_Exception('Fail to Vote Down', 'Cannot vote down question ID: '.$question_id.'. Caught exception: '.$ex->getMessage());
        }
        
        //-- Fetch Original Question
        $question = ORM::factory('post', $question_id);

        //-- Redirect
        url::redirect('/questions/detail/'.$question->id.'/'.$question->slug);
    }

    /**
     * Follow a Question
     *
     * @param int $question_id
     * @uses Post_Model::follow()
     */
    public function follow($question_id)
    {
        //-- Perform Question Follow
        try
        {
            ORM::factory('post')->follow($question_id);
        }
        catch(Exception $ex)
        {
            throw new Kohana_User_Exception('Fail to Vote Down', 'Cannot follow question ID: '.$question_id.'. Caught exception: '.$ex->getMessage());
        }

        //-- Fetch Original Question
        $question = ORM::factory('post', $question_id);

        //-- Redirect
        url::redirect('/questions/detail/'.$question->id.'/'.$question->slug);
    }

    /**
     * View Questions Contain Matching Tag
     *
     * @param string $tag_slug
     * @param int $page_number
     * @param int $page_size
     * @uses set_pagination()
     * @uses Post_Model::count_questions_by_tag()
     * @uses Post_Model::get_questions_by_tag()
     *
     */
    public function tagged($tag_slug, $filler='page', $page_number=1, $page_size=10)
    {
        //TODO: Error catching

        //-- Initialise Model
        $tag            = ORM::factory('tag')->by_slug($tag_slug);

        //TODO: Skip query if $tag->id == 0
        $total_items    = ORM::factory('post')->count_questions_by_tag($tag->id);

        //TODO: skip query if $total_items == 0
        $questions      = ORM::factory('post')->get_questions_by_tag($tag->id, $page_number, $page_size);

        //-- Set Pagination
        $this->set_pagination('questions/tagged/'.$tag_slug, $total_items, $page_size);

        //-- View Data
        $subheader = "Questions Tagged with '$tag->name'";

        //-- Render View
        $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/question_list')
            ->bind('questions', $questions)
            ->bind('subheader', $subheader);
    }
    
    //----------------------- PRIVATE METHODS --------------------------//

    /**
     * Browse a List of Questions order by its Activity
     *
     * @param int $page_number
     * @param int $page_size
     * @uses set_pagination()
     * @uses Post_Model::count_all_questions()
     * @uses Post_Model::get_active_questions()
     */
    private function browse_active($page_number, $page_size)
    {
        //TODO: Error catching
        //-- Initialise Model
        $total_items    = ORM::factory('post')->count_all_questions();
        $questions      = ORM::factory('post')->get_active_questions($page_number, $page_size);
        
        //-- Set Pagination
        $this->set_pagination('questions/browse', $total_items, $page_size);

        //-- View Data
        $subheader = 'Recent Questions';
        
        //-- Render View
        $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/question_list')
            ->bind('questions', $questions)
            ->bind('subheader', $subheader);
    }

    /**
     * Browse a List of Unanswered Questions
     *
     * @param int $page_number
     * @param int $page_size
     * @uses set_pagination()
     * @uses Post_Model::count_unanswered_questions()
     * @uses Post_Model::get_unanswered_questions()
     */
    private function browse_unanswered($page_number, $page_size)
    {
        //TODO: Error catching
        //-- Initialise Model
        $total_items    = ORM::factory('post')->count_unanswered_questions();
        $questions      = ORM::factory('post')->get_unanswered_questions($page_number, $page_size);

        //-- Set Pagination
        $this->set_pagination('questions/unanswered', $total_items, $page_size);

        //-- View Data
        $subheader = 'Unanswered Questions';

        //-- Render View
        $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/question_list')
            ->bind('questions', $questions)
            ->bind('subheader', $subheader);
    }

    /**
     * Setup Pagination Property for Website_Controller
     *
     * @param string $base_url
     * @param int $total_items
     * @param int $items_per_page
     */
    private function set_pagination($base_url, $total_items, $items_per_page)
    {
        $this->pagination = Pagination::factory();
        $this->pagination->initialize(array(
            'base_url'          => $base_url
            , 'uri_segment'     => 'page'
            , 'total_items'     => $total_items
            , 'items_per_page'  => $items_per_page
        ));
    }

    /**
     * Increase Question View Count by 1
     *
     * @param int $question_id
     */
    private function increase_view_count($question_id)
    {//TODO: This should belong in Post_Model
        //-- Initialise Model
        $question = ORM::factory('post', $question_id);

        //--NOTE: Currently using linear incremental on view count, which means every refresh will increase this count
        $question->view_count += 1;
        $question->save();
    }

    //----------------------- PLACE HOLDERS --------------------------//

    /**
     * Search Questions with Specified Criteria
     */
    public function search($query='', $page_number=1, $page_size=25)
    {
        //-- Detect a Post Back
        if($_POST)
        {
            $post = Validation::factory($_POST);
            //...
        }
        else
        {
            //...
        }
        $this->template->content = "Method Not Implemented Yet.";
    }

    /**
     * Display RSS Feed for all Questions
     */
    public function feed_all()
    {
        $this->template->content = "Method Not Implemented Yet.";
    }

    /**
     * Display RSS feed for a Question and its Answers
     */
    public function feed($question_id)
    {
        $this->template->content = "Method Not Implemented Yet.";
    }

    /**
     * Edit an Existing Question
     */
    public function edit($question_id)
    {
        $this->template->content = "Method Not Implemented Yet.";
    }
    
}//END class