<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
/**
* User Registration Partial View
*
* @since 1.0.0
* @package Qanda
* @subpackage View
*/
?>
        <div id="content">

            <div class="subheader"></div>

            <div class="main-bar">

                <div class="subheader">
                    <h2>Edit User Profile</h2>
                </div>

                <?php echo form::open(NULL, array('class'=>'edit_user_form', 'method'=>'post')); ?>

                    <?php echo form::hidden('hidden_name', 'hidden_value'); ?>

                    <?php echo form::label('username', 'Display Name:', 'class="display_name"'); ?>
                    <?php echo form::input('display_name', $user->display_name); ?>
                    <br/>

                    <?php /*
                    <?php echo form::label('email', 'Email:', 'class="email"'); ?>
                    <?php echo form::input('email', ''); ?>
                    <br/>
                    */ ?>

                    <?php echo form::label('website', 'Website:', 'class="website"'); ?>
                    <?php echo form::input('website', $user->website); ?>
                    <br/>

                    <?php echo form::label('location', 'Location:', 'class="location"'); ?>
                    <?php echo form::input('location', $user->location); ?>
                    <br/>

                    <?php /*
                    <?php echo form::label('birthday', 'Birthday:', 'class="birthday"'); ?>
                    <?php echo form::input('birthday', ''); ?>
                    <br/>

                    <?php echo form::label('about_me', 'About Me:', 'class="about_me"'); ?>
                    <?php echo form::input('about_me', ''); ?>
                    <br/>

                    <?php echo form::label('password', 'Password:', 'class="password"'); ?>
                    <?php echo form::password('password'); ?>
                    <br/>

                    <?php echo form::label('password_confirm', 'Repeat Password:', 'class="password"'); ?>
                    <?php echo form::password('password_confirm'); ?>
                    <br/>
                    */ ?>
                    
                    <?php echo form::submit('submit_user_edit', 'Save Profile'); ?>
                <?php echo form::close(); ?>
                
            </div>

            <?php View::factory($theme_url.'module_sidebar')->render(TRUE); ?>

            <div class="clearfix"></div>

        </div><?php /* END #content */ ?>