<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
/**
* User Login Partial View
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
                    <h2>User Login</h2>
                </div>

                <?php echo form::open(NULL, array('class'=>'login_form', 'method'=>'post')); ?>

                    <?php echo form::label('username', 'Username:', 'class="username"'); ?>
                    <?php echo form::input('username', ''); ?>
                    <br/>

                    <?php echo form::label('password', 'Password:', 'class="password"'); ?>
                    <?php echo form::password('password'); ?>
                    <br/>

                    <?php echo form::submit('submit_login', 'Login'); ?>
                <?php echo form::close(); ?>
                
            </div>

            <?php View::factory($theme_url.'module_sidebar')->render(TRUE); ?>

            <div class="clearfix"></div>

        </div><?php /* END #content */ ?>