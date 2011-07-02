<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
/**
* User Detail Partial View
*
* @since 1.0.0
* @package Qanda
* @subpackage View
*/
?>
        <div id="content">

            <div class="main-bar no-sidebar">

                <div class="subheader">
                    <h2><?php echo $user->display_name; ?></h2>
                </div>

                <div class="vcard clearfix">
                    <div class="meta">
                        <div class="avatar">
                            <img src="<?php echo $user->get_gravatar_url(128); ?>" width="128" height="128" alt="" />
                        </div>
                        <div class="reputation">
                            <span class="value"><?php echo $user->reputation_score; ?></span>
                            <br/><span class="label">reputation</span>
                        </div>
                        <div class="view-count">
                            <?php echo $user->profile_view_count.' '.inflector::plural('view', $user->profile_view_count); ?>
                        </div>
                    </div>

                    <div class="summary">
                        <h3>Registered User</h3>
                        <div class="name clearfix">
                            <div class="label">Display Name:</div>
                            <div class="value"><?php echo $user->display_name; ?></div>
                        </div>

                        <?php /***travo20100313
                        <div class="birthday clearfix">
                            <div class="label">Birthday:</div>
                            <div class="value"><?php echo $user->birthday; ?></div>
                        </div>
                        */ ?>

                        <div class="website clearfix">
                            <div class="label">Website:</div>
                            <div class="value"><?php echo $user->website; ?></div>
                        </div>
                        <div class="location clearfix">
                            <div class="label">Location:</div>
                            <div class="value"><?php echo $user->location; ?></div>
                        </div>

                        <?php if($this->user->id == $user->id): ?>
                            <div class="control_panel">
                                <?php echo html::anchor('users/edit/', 'Update Your Profile'); ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="description">
                        <?php echo $user->description; ?>
                    </div>

                </div><?php /* END .vcard */ ?>


                <div class="asked_questions">
                    <div class="subheader">
                        <h2><?php echo count($asked_questions).' '.inflector::plural('question', count($asked_questions)); ?></h2>
                        <?php foreach($asked_questions as $index => $question): ?>
                            <div class="question">
                                <span>
                                    <?php echo $question->follow_count; ?>
                                    | <?php echo $question->up_vote_count - $question->down_vote_count; ?>
                                    | <?php echo $question->answer_count; ?>
                                    | <?php echo $question->view_count; ?>
                                    | <?php echo $question->title; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div><?php /* END .asked_questions */ ?>

                
                <div class="answered_questions">
                    <div class="subheader">
                        <h2><?php echo count($answered_questions).' '.inflector::plural('answer', count($answered_questions)); ?></h2>
                        <?php foreach($answered_questions as $index => $question): ?>
                            <div class="question">
                                <span>
                                    <?php echo $question->follow_count; ?>
                                    | <?php echo $question->up_vote_count - $question->down_vote_count; ?>
                                    | <?php echo $question->answer_count; ?>
                                    | <?php echo $question->view_count; ?>
                                    | <?php echo $question->title; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div><?php /* END .answered_questions */ ?>


                <div class="casted_votes">
                    <div class="subheader">
                        <h2><?php echo ($user->up_vote_casted + $user->down_vote_casted).' '.inflector::plural('vote', ($user->up_vote_casted + $user->down_vote_casted)); ?></h2>
                        <span><?php echo $user->up_vote_casted; ?> up votes casted</span>
                        <br/><span><?php echo $user->down_vote_casted; ?> down votes casted</span>
                    </div>
                </div>

                
                <div class="involved_tags">
                    <div class="subheader">
                        <h2><?php echo count($involved_tags).' '.inflector::plural('tag', count($involved_tags)); ?></h2>
                        <?php foreach($involved_tags as $index => $tag): ?>
                            <div class="tag">
                                <span>
                                    <?php echo $tag->name; ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div><?php /* END .involved_tags */ ?>

            </div><?php /* END .main-bar */ ?>


        </div><?php /* END #content */ ?>