<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
/**
* Sidebar Partial View
*
* @since 1.0.0
* @package Qanda
* @subpackage View
*/
?>
            <div class="side-bar">
                
                <?php View::factory($theme_url.'module_welcome')->render(TRUE); ?>

                <?php
                    $authentic = Auth::factory();
                    if ($authentic->logged_in())
                    {//-- A Login Session Exists
                        View::factory($theme_url.'module_user_detail')->render(TRUE);
                    }
                    else
                    {//-- Not Logged In Yet
                        if((Router::$controller == 'users' AND Router::$method == 'login')
                            OR (Router::$controller == 'users' AND Router::$method == 'register'))
                        {
                            //-- Do Nothing, Avoid Login Widget
                        }
                        else
                        {
                            View::factory($theme_url.'module_user_login')->render(TRUE);
                        }
                    }
                ?>

            </div><?php /* END #content */ ?>