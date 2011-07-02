<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Qanda Website Controller.
 *
 * @package Qanda
 * @subpackage Website
 */

/**
 * Qanda Website Controller Extending All Application Controllers
 *
 * @since 1.0.0
 * @package Qanda
 * @subpackage Website
 * @uses Template_Controller Extends class
 */
class Website_Controller extends Template_Controller
{
    //-- Global Variables
    public $template; // In application/views folder
    protected $settings;
    public $user;
    
    /**
     * Website Controller Constructor
     */
	public function __construct()
	{
        //-- Load Settings
        $this->settings = ORM::factory('setting');
        $this->settings->autoload();

        //-- Set Theme Template
        $this->template = 'themes/'.$this->settings->get('current_theme').'/master';

        //-- Initiate Template_Controller constructor
		parent::__construct();

        //-- Enable Session on All Pages
        //$this->session = Session::instance(); // Not used

        //-- Template Head
        $this->head = Head::instance();
        $this->head->css->append_file('media/themes/'.$this->settings->get('current_theme').'/css/layout');
        $this->head->title->set($this->settings->get('site_name'));
        $this->template->head = $this->head;

        //-- Set User
        $this->user = ORM::factory('user');
        $authentic = Auth::factory();
        if ($authentic->logged_in())
        {
            $this->user = $authentic->get_user();
        }

        //-- Template Global Variables
        $this->template->set_global('theme_url', 'themes/'.$this->settings->get('current_theme').'/');
        $this->template->set_global('current_version', $this->settings->get('version'));
        $this->template->set_global('current_user', $this->user);
	}

    //----------------------- PUBLIC METHODS --------------------------//

    //----------------------- STATIC METHODS --------------------------//

    /**
     * Create Log Record
     *
     * @param string $activity
     * @param string $object_type
     * @param int $object_id
     * @static
     * @uses Activity_Model::log()
     */
    protected function log_activity($activity, $object_type, $object_id)
    {
        //-- Log User View Activity
        if($this->user->is_logged_in())
        {
            ORM::factory('activity')->log($this->user->id, $activity, $object_type, $object_id);
        }
    }

    //----------------------- PRIVATE METHODS --------------------------//

}//END class