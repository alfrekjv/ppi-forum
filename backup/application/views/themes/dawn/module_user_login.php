<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
                <?php /* Login Form */ ?>
                <div id="login-widget" class="widget">
                    <h3>Login</h3>
                    <?php echo form::open('users/login', array('class'=>'login_form', 'method'=>'post')); ?>

                        <?php echo form::hidden('redirect_url', url::current()); ?>

                        <?php echo form::label('username', 'Username:'); ?>
                        <?php echo form::input('username', ''); ?>
                        <br/>
                        <?php echo form::label('password', 'Password:'); ?>
                        <?php echo form::password('password', ''); ?>
                        <br/>
                        <?php echo form::submit('submit-login', 'Login'); ?>
                        or <?php echo html::anchor('/users/register', 'Register'); ?>.
                    <?php echo form::close(); ?>
                </div>