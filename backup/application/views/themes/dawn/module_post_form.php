<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

                <?php echo form::open($submit_uri, array('class'=>$form_class.' post_form', 'method'=>$form_method)); ?>

                    <?php echo form::hidden('timestamp', time()); ?>
                    <?php echo form::hidden('target_post_id', $target_post_id); ?>

                    <?php if($enable_post_title == TRUE): ?>
                        <?php echo form::label('post_title', 'Title:', 'class="post_title"'); ?>
                        <?php echo form::input('post_title', ''); ?>
                        <br/>
                    <?php endif; ?>

                    <?php echo form::label('post_body', 'Body:', 'class="post_body"'); ?>
                    <?php echo form::textarea('post_body', '', 'rows="10" cols="70"'); ?>
                    <br/>

                    <?php if($enable_post_tags == TRUE): ?>
                        <?php echo form::label('post_tags', 'Tags:', 'class="post_tags"'); ?>
                        <?php echo form::input('post_tags', ''); ?>
                        <br/>
                    <?php endif; ?>

                    <?php $authentic = Auth::factory(); ?>
                    <?php if ($authentic->logged_in()): ?>

                        <?php $user = $authentic->get_user(); ?>
                        <?php echo form::hidden('user_id', $user->id); ?>

                    <?php else: ?>

                        <?php echo form::label('display_name', 'Name:', 'class="display_name"'); ?>
                        <?php echo form::input('display_name', ''); ?>
                        <br/>
                        <?php echo form::label('email', 'Email:', 'class="email"'); ?>
                        <?php echo form::input('email', ''); ?>
                        <br/>

                    <?php endif; ?>

                    <?php echo form::submit('submit_post', $submit_label); ?>

                <?php echo form::close(); ?>
