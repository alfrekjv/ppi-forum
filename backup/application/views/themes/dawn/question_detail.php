<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
/**
* Question Details Partial View
*
* @since 1.0.0
* @package Qanda
* @subpackage View
*/
?>
        <div id="content">

            <script type="text/javascript">
            <!--
                (function($)
                {
                    $(document).ready(function()
                    {
                        if(user_role == 'guest')
                        {
                            $('.up-vote a, .down-vote a, .follow a').bind('click', function(){ return false; });
                            $('.up-vote a, .down-vote a, .follow a').tooltip({
                                showURL: false
                                , bodyHandler: function(){ return 'Please login first'; }
                            });
                        }
                    });
                }(jQuery));
            //-->
            </script>


            
            <div class="main-bar">

                <div class="subheader">
                    <h2><?php echo html::anchor('/questions/detail/'.$question->id.'/'.$question->slug, $question->title); ?></h2>
                </div>

                <div id="question-<?php echo $question->id; ?>" class="post-detail question clearfix">
                    <div class="panel">

                        <?php
                            $up_vote_class = 'up-vote';
                            if($current_user->has_up_voted($question->id))
                                $up_vote_class = 'up-voted';
                        ?>
                        <div class="<?php echo $up_vote_class; ?> ir">
                            <?php echo html::anchor('questions/vote_up/'.$question->id, 'Up'); ?>
                        </div>

                        <div class="score">
                            <?php echo $question->up_vote_count - $question->down_vote_count; ?>
                        </div>

                        <?php
                            $down_vote_class = 'down-vote';
                            if($current_user->has_down_voted($question->id))
                                $down_vote_class = 'down-voted';
                        ?>
                        <div class="<?php echo $down_vote_class; ?> ir">
                            <?php echo html::anchor('questions/vote_down/'.$question->id, 'Down'); ?>
                        </div>
                        
                        <?php
                            $follow_class = 'follow';
                            if($current_user->has_followed($question->id))
                                $follow_class = 'followed';
                        ?>
                        <div class="<?php echo $follow_class; ?>">
                            <?php echo html::anchor('questions/follow/'.$question->id, $question->follow_count); ?>
                        </div>
                        <div class="view">
                            <small>
                                <?php echo $question->get_view_count(); ?>
                                <?php echo $question->get_view_label(); ?>
                            </small>
                        </div>
                    </div><?php /* END .panel */ ?>

                    <div class="detail">
                        <div class="content">
                            <?php
                                echo nl2br($question->content);
                            ?>
                        </div>
                        
                        <ul class="tags clearfix">
                            <?php foreach($question->tags as $index => $tag): ?>
                                <li class="tag">
                                    <?php echo html::anchor('questions/tagged/'.$tag->slug, $tag->name, array('rel'=>'tag')); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        <?php
                            $form       = View::factory($theme_url.'module_user_thumbnail');
                            $form->user = $question->user;
                            $form->render(TRUE);
                        ?>

                        <?php /***travo20100227: Not Implemented
                        <div class="meta">
                            <span><?php echo html::anchor('#', 'mod'); ?></span>
                            | <span><?php echo html::anchor('#', 'edit'); ?></span>
                            | <span><?php echo html::anchor('#', 'close'); ?></span>
                            | <span><?php echo html::anchor('#', 'delete'); ?></span>
                            | <span><?php echo html::anchor('#', 'flag'); ?></span>
                        </div>
                        */ ?>
                        
                        <div class="add-comment">
                            <span><?php echo html::anchor('comments/create/question/'.$question->id, 'Add comment'); ?></span>
                        </div>
                    </div><?php /* END .detail */ ?>

                    
                    <?php $question->load_comments(); ?>
                    <?php if($question->has_comments()): ?>
                    <div class="comments">
                        <?php foreach($question->comments as $index => $comment): ?>
                        <div class="comment clearfix">
                            <?php /***travo20100426: Not Implemented yet
                            <div class="comment-panel">
                                <span class="score">[<?php echo $comment->up_vote_count - $comment->down_vote_count; ?>]</span>
                                <span class="up-vote"><?php echo html::anchor('comments/vote_down/'.$comment->id, '[V]'); ?></span>
                                <span class="flag"><?php echo html::anchor('comments/flag/'.$comment->id, '[F]'); ?></span>
                            </div>
                            */ ?>
                            <div class="content">
                                <span class="blurb"><?php echo $comment->content; ?></span>
                                <span class="signature">
                                    <small>- by</small>
                                    <a href="<?php echo url::site('users/detail/'.$comment->user->username); ?>">
                                        <?php echo $comment->user->display_name; ?>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div><?php /* END .comments */ ?>
                    <?php endif; ?>

                </div><?php /* END .post-detail */ ?>

                

                <?php /********************* ANSWER LISTING ******************/ ?>

                <?php /***travo20100328: Not ready yet
                <?php $question->load_answers(); ?>
                <?php $answers = $question->answers; ?>
                */ ?>
                
                <div id="answers-to-<?php echo $question->id; ?>" class="answers-list">

                    <div class="subheader">
                        <h2><?php echo count($answers).' '.inflector::plural('answer', count($answers)); ?></h2>
                    </div>

                    <?php foreach($answers as $index => $answer): ?>
                        <div id="answer-<?php echo $answer->id; ?>" class="post-detail answer clearfix">

                            <div class="panel">

                                <?php
                                    $up_vote_class = 'up-vote';
                                    if($current_user->has_up_voted($answer->id))
                                        $up_vote_class = 'up-voted';
                                ?>
                                <div class="<?php echo $up_vote_class; ?> ir">
                                    <?php echo html::anchor('answers/vote_up/'.$answer->id, 'Up'); ?>
                                </div>

                                <div class="score">
                                    <?php echo $answer->up_vote_count - $answer->down_vote_count; ?>
                                </div>

                                <?php
                                    $down_vote_class = 'down-vote';
                                    if($current_user->has_down_voted($answer->id))
                                        $down_vote_class = 'down-voted';
                                ?>
                                <div class="<?php echo $down_vote_class; ?> ir">
                                    <?php echo html::anchor('answers/vote_down/'.$answer->id, 'Down'); ?>
                                </div>

                                <?php /* Accept Answer Tick */ ?>
                                <?php if($show_accept_button == true && $answer->status == 'accepted'): ?>
                                    <div class="answer-accepted ir">
                                        <?php echo html::anchor('answers/accept/'.$answer->id, 'Answer Accepted'); ?>
                                    </div>
                                <?php elseif($answer->status == 'accepted'): ?>
                                    <div class="answer-accepted ir">
                                        <span>
                                            'Answer Accepted'
                                        </span>
                                    </div>
                                <?php elseif($show_accept_button == true): ?>
                                    <div class="accept-answer ir">
                                        <?php echo html::anchor('answers/accept/'.$answer->id, 'Accept Answer'); ?>
                                    </div>
                                <?php endif; ?>

                                
                            </div><?php /* END .panel */ ?>


                            <div class="detail">
                                <div class="content">
                                    <?php
                                        //echo text::auto_p($answer->content);
                                        echo nl2br($answer->content);
                                    ?>
                                </div>

                                <?php
                                    $form       = View::factory($theme_url.'module_user_thumbnail');
                                    $form->user = $answer->user;
                                    $form->render(TRUE);
                                ?>

                                <?php /***travo20100227: Not Implemented
                                <div class="meta">
                                    <span><?php echo html::anchor('#', 'mod'); ?></span>
                                    | <span><?php echo html::anchor('#', 'edit'); ?></span>
                                    | <span><?php echo html::anchor('#', 'close'); ?></span>
                                    | <span><?php echo html::anchor('#', 'delete'); ?></span>
                                    | <span><?php echo html::anchor('#', 'flag'); ?></span>
                                </div>
                                */ ?>

                                <div class="add-comment">
                                    <span><?php echo html::anchor('comments/create/answer/'.$answer->id, 'Add comment'); ?></span>
                                </div>

                                <?php $answer->load_comments(); ?>
                                <?php if($answer->has_comments()): ?>
                                <div class="comments">
                                    <?php foreach($answer->comments as $index => $comment): ?>
                                    <div class="comment clearfix">
                                        <?php /***travo20100426: Not Implemented yet
                                        <div class="comment-panel">
                                            <span class="score">[<?php echo $comment->up_vote_count - $comment->down_vote_count; ?>]</span>
                                            <span class="up-vote"><?php echo html::anchor('comments/vote_down/'.$comment->id, '[V]'); ?></span>
                                            <span class="flag"><?php echo html::anchor('comments/flag/'.$comment->id, '[F]'); ?></span>
                                        </div>
                                        */ ?>
                                        <div class="content">
                                            <span class="blurb"><?php echo $comment->content; ?></span>
                                            <span class="signature">
                                                - by
                                                <a href="<?php echo url::site('users/detail/'.$comment->user->username); ?>">
                                                    <?php echo $comment->user->display_name; ?>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div><?php /* END .comments */ ?>
                                <?php endif; ?>

                            </div><?php /* END .detail */ ?>
                        </div><?php /* END .post-detail */ ?>
                    <?php endforeach; ?>

                    <?php
                        if($this->pagination->total_pages > 1)
                            echo $this->pagination->render('qanda');
                    ?>

                    <?php if(count($answers) == 0): ?>
                        <div class="no-answers">
                            <p>
                                There's no answer to this question. Provide us your answer.
                            </p>
                        </div>
                    <?php endif; ?>

                </div><?php /* END .answers-list */ ?>

                
                <h2>Answer this Question</h2>
                <?php
                    $form                       = View::factory($theme_url.'module_post_form');
                    $form->submit_uri           = 'answers/create';
                    $form->form_class           = 'answer-question';
                    $form->form_method          = 'post';
                    $form->target_post_id          = $question->id;
                    $form->enable_post_title    = FALSE;
                    $form->enable_post_tags     = FALSE;
                    $form->submit_label         = 'Post Answer';
                    $form->render(TRUE);
                ?>


            </div><?php /* END #main-bar */ ?>

            <?php View::factory($theme_url.'module_sidebar')->render(TRUE); ?>

            <div class="clearfix"></div>

        </div><?php /* END #content */ ?>