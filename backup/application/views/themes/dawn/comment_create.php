<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
/**
* Comment Create Partial View
*
* @since 1.0.0
* @package Qanda
* @subpackage View
*/
?>
        <div id="content">
            
            <div class="main-bar">

                <?php if(isset($answer)): ?>

                    <div class="subheader">
                        <h2>Comment on an Answer</h2>
                    </div>
                    <div id="answer_<?php echo $answer->id; ?>" class="post_recap">
                        <p>
                            <strong>Question:</strong>
                            <?php echo $question->title; ?>
                        </p>
                        <p>
                            <strong>Answer:</strong>
                            <?php echo $answer->content; ?>
                        </p>
                    </div>

                <?php else: ?>
                
                    <div class="subheader">
                        <h2>Comment on a Question</h2>
                    </div>
                    <div id="answer_<?php echo $question->id; ?>" class="post_recap">
                        <p>
                            <strong>Question:</strong>
                            <?php echo $question->title; ?>
                            <br/>
                            <br/>
                            <?php echo $question->content; ?>
                        </p>
                    </div>

                <?php endif; ?>

                <?php
                    $form                       = View::factory($theme_url.'module_post_form');
                    $form->submit_uri           = 'comments/create/'.$post_type;
                    $form->form_class           = 'comment-post';
                    $form->form_method          = 'post';
                    $form->target_post_id       = $target_post_id;
                    $form->enable_post_title    = FALSE;
                    $form->enable_post_tags     = FALSE;
                    $form->submit_label         = 'Post Comment';
                    $form->render(TRUE);
                ?>

            </div><?php /* END #main-bar */ ?>

            <?php View::factory($theme_url.'module_sidebar')->render(TRUE); ?>

            <div class="clearfix"></div>

        </div><?php /* END #content */ ?>