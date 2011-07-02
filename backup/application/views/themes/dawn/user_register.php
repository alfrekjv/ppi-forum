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
                    <h2>User Registration</h2>
                </div>

                <?php echo form::open(NULL, array('class'=>'register_form', 'method'=>'post')); ?>

                    <?php echo form::hidden('hidden_name', 'hidden_value'); ?>

                    <?php echo form::label('username', 'Username:', 'class="username"'); ?>
                    <?php echo form::input('username', ''); ?>
                    <br/>

                    <?php echo form::label('email', 'Email:', 'class="email"'); ?>
                    <?php echo form::input('email', ''); ?>
                    <br/>

                    <?php echo form::label('password', 'Password:', 'class="password"'); ?>
                    <?php echo form::password('password'); ?>
                    <br/>

                    <?php echo form::label('password_confirm', 'Repeat Password:', 'class="password"'); ?>
                    <?php echo form::password('password_confirm'); ?>
                    <br/>

                    <?php echo form::submit('submit_register', 'Register'); ?>
                <?php echo form::close(); ?>
                
            </div>

            <?php View::factory($theme_url.'module_sidebar')->render(TRUE); ?>

            <div class="clearfix"></div>

        </div><?php /* END #content */ ?>