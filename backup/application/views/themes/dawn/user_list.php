<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
/**
* User List Partial View
*
* @since 1.0.0
* @package Qanda
* @subpackage View
*/
?>
        <div id="content">
            
            <div class="main-bar">

                <div class="subheader">
                    <h2>Users</h2>
                </div>

                <div class="users-list clearfix">
                    <?php foreach($users as $index => $user): ?>

                        <?php
                            $form       = View::factory($theme_url.'module_user_thumbnail');
                            $form->user = $user;
                            $form->render(TRUE);
                        ?>

                    <?php endforeach; ?>
                </div>

            </div><?php /* END .main-bar */ ?>

            
            <?php View::factory($theme_url.'module_sidebar')->render(TRUE); ?>

            <div class="clearfix"></div>

        </div><?php /* END #content */ ?>