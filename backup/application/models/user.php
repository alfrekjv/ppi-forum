<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Qanda Users Model.
 *
 * @package Qanda
 * @subpackage User
 */

/**
 * Qanda Users Model.
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage User
 * @uses ORM Extends class
 */
class User_Model extends Auth_User_Model
{
    //----------------------- PUBLIC METHODS --------------------------//

    /**
     * Determine whether the current user is logged in (oppose to guest)
     *
     * @return bool
     */
    public function is_logged_in()
    {
        return ($this->id > 0) ? true : false;
    }
    
    /**
     * Generate the Gravatar URL as instructed at http://en.gravatar.com/site/implement/url
     *
     * @param int $size
     * @return string
     */
    public function get_gravatar_url($size=80)
    {
        $base_url = 'http://www.gravatar.com/avatar/';
        $output = $base_url.md5($this->email).'?s='.$size.'&amp;d=identicon';
        
        return $output;
    }

    /**
     * Check Whether this User has Followed Specified Question
     *
     * @param int $question_id
     * @return bool
     */
    public function has_followed($question_id)
    {
        //-- Validate Current User
        if($this->id == 0)
            return false;

        //-- Check Log
        if(ORM::factory('activity')->has_log($this->id, 'follow', 'post', $question_id))
            return true;
        else
            return false;
    }

    /**
     * Check Whether this User has Up Voted Specified Question/Answer
     *
     * @param int $post_id
     * @return bool
     */
    public function has_up_voted($post_id)
    {
        //-- Validate Current User
        if($this->id == 0)
            return false;

        //-- Check Log
        if(ORM::factory('activity')->has_log($this->id, 'vote_up', 'post', $post_id))
            return true;
        else
            return false;
    }
    
    /**
     * Check Whether this User has Down Voted Specified Question/Answer
     *
     * @param int $post_id
     * @return bool
     */
    public function has_down_voted($post_id)
    {
        //-- Validate Current User
        if($this->id == 0)
            return false;

        //-- Check Log
        if(ORM::factory('activity')->has_log($this->id, 'vote_down', 'post', $post_id))
            return true;
        else
            return false;
    }

    /**
     * Update user profile
     *
     * @param Validation_Object $post
     */
    public function update($post)
    {
        //-- Fetch User Input
        $display_name   = $post->display_name;
        $website        = $post->website;
        $location       = $post->location;
        
        //-- Sanitize
        if($display_name == '')
            throw new Exception('Display Name is required.');

        //-- Update Profile
        $this->display_name         = $display_name;
        $this->website              = $website;
        $this->location             = $location;

        $this->last_activity_date   = date::timestamp();
        $this->last_ip_address      = Input::instance()->ip_address();
        $this->last_user_agent      = Kohana::user_agent();
        $this->date_modified        = date::timestamp();
        $this->modified_by          = 'user::update';
        //$this->save();

        //-- Update User Details
        if(!$this->save())
        {
            throw new Exception('Failed to save user.');
        }
    }
    
    //----------------------- STATIC METHODS --------------------------//

    /**
     * List All Users
     *
     * @return ORM_Iterator
     * @static
     */
    public function list_all_users()
    {
        //-- Query
        $users = $this->orderby('reputation_score', 'desc')
            ->where('is_deleted', 0)
            ->find_all();

        //-- Output
        return $users;
    }

    /**
     * List All Users
     *
     * @param string $username
     * @return User_Model
     * @static
     */
    public function get($username)
    {
        //-- Query
        $user = $this->where('username', $username)
            ->where('is_deleted', 0)
            ->find();
        
        //-- Output
        return $user;
    }

    /**
     * Create a New User
     *
     * @param Validation_Object $post
     * @return int Id of the newly created user
     * @static
     */
    public function create($post)
    {
        //-- Fetch User Input
        $username           = $post->username;
        $email              = $post->email;
        $password           = $post->password;
        $password_confirm   = $post->password_confirm;
        $role_name          = 'login';

        //-- Sanitize
        if($username == '')
            throw new Exception('Username field is required.');
        //TODO: Verify existance of this username
        if($email == '')
            throw new Exception('Email field is required.');
        if(valid::email_rfc($email) == FALSE)
            throw new Exception('Invalid email address format.');
        //TODO: Verify existance of this email
        if($password == '')
            throw new Exception('Password field is required.');
        if($password != $password_confirm)
        {
            throw new Exception('Retype password does not match.');
        }

        //-- Create new user
        $user = ORM::factory('user');
        $user->username             = $username;
        $user->display_name         = $username; // NOTE: Temperary until user able to assign display name upon registration
        $user->email                = $email;
        $user->password             = $password;
        $user->activation_key       = strtolower(text::random('alnum', 32));
        $user->last_activity_date   = date::timestamp();
        $user->last_ip_address      = Input::instance()->ip_address();
        $user->last_user_agent      = Kohana::user_agent();
        $user->date_created         = date::timestamp();
        $user->created_by           = 'user::create_user';
        
        //-- Insert user and its role
        if($user->add(ORM::factory('role', $role_name)) AND $user->save())
        {
            return $user->id;
        }
        else
        {
            throw new Exception('Failed to save user and/or create its role.');
        }
    }

    /**
     * Authenticate an User
     *
     * @param Validation_Object $post
     * @static
     */
    public function authenticate($post)
    {
        //-- Local Variables
        $username = $post->username;
        $password = $post->password;

        //-- Sanitize
        if($username == '')
            throw new Exception('Username field is required');
        if($password == '')
            throw new Exception('Password field is required');

        //-- Authorise
        //TODO: Catch error upon $auth->login()
        $user = ORM::factory('user', $username);
        $auth = Auth::factory();

        if (!$user->loaded)
        {//-- No matching Username
            throw new Exception('Username not found.');
        }
        elseif ($auth->login($user, $password))
        {//-- Login Success
            return;
        }
        else
        {//-- Incorrect Password
            throw new Exception('Incorrect password.');
        }
    }

    /**
     * Adjust User's Reputation
     *
     * @param int $user_id
     * @param int $reputation_score
     * @static
     */
    public function adjust_reputation($user_id, $reputation_score)
    {
        $user = ORM::factory('user', $user_id);
        $user->reputation_score    += $reputation_score;
        $user->date_modified        = date::timestamp();
        $user->modified_by          = 'user::adjust_reputation';
        $user->save();
    }
    
    /**
     * Increase number of Up Vote Casted Count
     *
     * @param int $user_id
     * @static
     */
    public function increment_up_vote_casted($user_id)
    {
        $user = ORM::factory('user', $user_id);
        $user->up_vote_casted  += 1;
        $user->date_modified    = date::timestamp();
        $user->modified_by      = 'user::increment_up_vote_casted';
        $user->save();
    }

    /**
     * Increase number of Down Vote Casted Count
     *
     * @param int $user_id
     * @static
     */
    public function increment_down_vote_casted($user_id)
    {
        $user = ORM::factory('user', $user_id);
        $user->down_vote_casted    += 1;
        $user->date_modified        = date::timestamp();
        $user->modified_by          = 'user::increment_down_vote_casted';
        $user->save();
    }

    //----------------------- PRIVATE METHODS --------------------------//

}//END class