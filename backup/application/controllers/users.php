<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Qanda Users Controller.
 *
 * @package Qanda
 * @subpackage User
 */

/**
 * Qanda Users Controller for all User Related Tasks.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage User
 * @uses Website_Controller Extends class
 */
class Users_Controller extends Website_Controller
{

    /**
     * Users Controller Constructor
     */
    public function __construct()
    {
        parent::__construct(); //-- This must be included
    }

    //----------------------- PUBLIC METHODS --------------------------//

    /**
     * Show a List of Users
     *
     * @uses User_Model::list_all_users()
     */
    public function browse()
    {
        //TODO: Error handling
        //TODO: Cater pagination
        //-- Model
        $users = ORM::factory('user')->list_all_users();

        //-- Render View
        $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/user_list')
            ->bind('users', $users);
    }

    /**
     * View User Details
     *
     * @param string $username
     * @uses Post_Model::get_asked_questions()
     * @uses Post_Model::get_answered_questions()
     * @uses Tag_Model::get_involved_tags()
     */
    public function detail($username)
    {
        //-- Get User
        $user = ORM::factory('user')->get($username);

        //-- Get User Involvements
        //TODO: Paginate it
        $asked_questions    = ORM::factory('post')->get_asked_questions($user->id);
        //TODO: Paginate it
        $answered_questions = ORM::factory('post')->get_answered_questions($user->id);
        //TODO: Limit Number of Tags Shown (instead of Paginate)
        $involved_tags      = ORM::factory('tag')->get_inolved_tags($user->id);

        //-- Event Hooks
        $this->increase_view_count($user->id);
        
        //-- Render View
        $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/user_detail')
            ->bind('user', $user)
            ->bind('asked_questions', $asked_questions)
            ->bind('answered_questions', $answered_questions)
            ->bind('involved_tags', $involved_tags)
            ;
    }

    /**
     * User Login
     *
     * @uses User_Model::authenticate()
     */
    public function login()
    {
        if($this->user->is_logged_in() == TRUE)
        {//-- Already logged in as someone
            //TODO: Display 'Already Logged In' Error Page
            throw new Kohana_User_Exception('Already Logged In.', 'You have already logged in to the website');
        }
        elseif($_POST)
        {//-- Detect a Post Back
            $post = Validation::factory($_POST);

            //-- Attemp to Login
            try
            {
                ORM::factory('user')->authenticate($post);
            }
            catch(Exception $ex)
            {
                //TODO: Instead of throw Kohana Error page, redirect back to this method with error message displayed.
                throw new Kohana_User_Exception('Fail to Login.', 'Cannot login. Caught exception: '.$ex->getMessage());
            }

            //-- Login Success, Redirect
            if(isset($post->redirect_url))
                url::redirect($post->redirect_url);
            else
                url::redirect('/');
        }
        else
        {
            //-- Show Login Form
            $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/user_login');
        }
    }

    /**
     * User Log Out
     */
    public function logout()
    {
        //-- Log Out
        Auth::instance()->logout();

        //-- Redirect
        $get = Validation::factory($_GET);
        if(isset($get->redirect_url))
        {
            url::redirect($get->redirect_url);
        }
        else
        {
            url::redirect('/');
        }
    }

    /**
     * Register as a new User
     */
    public function register()
    {
        //-- Verify Current Authentication
        if($this->user->is_logged_in() == TRUE)
        {//-- Display 'Already Logged In' message
            //TODO: Display proper 'Already Logged In' page and provide link to log out
            throw new Kohana_User_Exception('Already Logged In.', 'You have already logged in to the website');
        }
        elseif($_POST)
        {//-- Detects a Post Back
            $post = Validation::factory($_POST);

            //-- Create new User
            try
            {
                $user_id    = ORM::factory('user')->create($post);
            }
            catch(Exception $ex)
            {
                //TODO: Instead of throw Kohana Error page, redirect back to this method with error message displayed.
                throw new Kohana_User_Exception('Fail to Create User.', 'Cannot create user. Caught exception: '.$ex->getMessage());
            }

            //-- Load this User
            $user = ORM::factory('user', $user_id);

            //-- Login using the collected data
            Auth::instance()->login($user->username, $post->password);

            //-- Redirect
            url::redirect('/users/detail/'.$user->username);
        }
        else
        {
            //-- Display User Registration Form
            $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/user_register');
        }
    }

    /**
     * Edit an Existing Self Profile
     *
     * @param int $user_id
     */
    public function edit($user_id = 0)
    {
        //-- Verify Current Authentication
        if($this->user->is_logged_in() == FALSE)
        {
            throw new Kohana_User_Exception('User Not Logged In.', 'You are required to login to edit your profile.');
        }
        else
        {
            if($_POST)
            {//-- Detect a Post Back
                //TODO: Validate user input
                $post = Validation::factory($_POST);
                
                //-- Update User Profile
                try
                {
                    $this->user->update($post);
                }
                catch(Exception $ex)
                {
                    throw new Kohana_User_Exception('Fail to Edit User Profile', 'Cannot update user profile. Caught exception: '.$ex->getMessage());
                }

                //-- Redirect
                url::redirect('/users/detail/'.$this->user->username);
            }
            else
            {//-- Show Update Form
                if($user_id == 0)
                {//-- Load Own Profile
                    $user = $this->user;
                }
                else
                {//-- For Admin who has ability to edit all users
                    //$user = ORM::factory('user', $user_id);
                }
                
                $this->template->content = View::factory('themes/'.$this->settings->get('current_theme').'/user_edit')
                    ->bind('user', $user)
                    ;
            }
        }
    }

    //----------------------- PRIVATE METHODS --------------------------//

    /**
     * Increase User View Count by 1
     *
     * @param int $user_id
     */
    private function increase_view_count($user_id)
    {
        //-- Initialise Model
        $user = ORM::factory('user', $user_id);

        //--NOTE: Currently using linear incremental on view count, which means every refresh will increase this count
        $user->profile_view_count += 1;
        $user->save();
    }

    //----------------------- PLACE HOLDERS --------------------------//

}//END class