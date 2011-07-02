<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
/**
* Question List Partial View
*
* @since 1.0.0
* @package Qanda
* @subpackage View
*/
?>
        <div id="content">
            
            <div class="main-bar">

                <div class="subheader">
                    <h2><?php echo $subheader; ?></h2>
                </div>

                <?php foreach($questions as $index => $question): ?>
                <?php $answer_class = ($question->status == 'answered') ? 'answered' : ''; ?>
                <div id="question-summary-<?php echo $question->id; ?>" class="question-summary clearfix">

                    <div class="stats">
                        <div class="votes">
                            <span class="count"><?php echo $question->get_vote_count(); ?></span>
                            <span class="label"><?php echo $question->get_vote_label(); ?></span>
                        </div>

                        <div class="answers <?php echo $answer_class; ?>">
                            <span class="count"><?php echo $question->get_answer_count(); ?></span>
                            <span class="label"><?php echo $question->get_answer_label(); ?></span>
                        </div>

                        <div class="views">
                            <span class="count"><?php echo $question->get_view_count(); ?></span>
                            <span class="label"><?php echo $question->get_view_label(); ?></span>
                        </div>
                    </div>
                    


                    <div class="summary clearfix">
                        <h3>
                            <?php echo html::anchor('questions/detail/'.$question->id.'/'.$question->slug, $question->title, array('class'=>'cls1 cls2')); ?>
                        </h3>
                        
                        <?php if($question->has_content()): ?>
                            <p class="excerpt">
                                <?php echo $question->get_excerpt(); ?>
                            </p>
                        <?php endif; ?>

                        <ul class="tags clearfix">
                            <?php foreach($question->tags as $index => $tag): ?>
                                <li class="tag">
                                    <?php echo html::anchor('questions/tagged/'.$tag->slug, $tag->name, array('rel'=>'tag')); ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="meta">
                            <small>asked by:</small>
                            <span class="display_name">
                                <?php echo html::anchor('users/detail/'.$question->user->username, $question->user->display_name); ?>
                            </span>
                            <span class="reputation">
                                <?php echo $question->user->reputation_score; ?>
                            </span>
                        </div>
                    </div>

                </div>             
                <?php endforeach; ?>

                <?php echo $this->pagination->render('qanda'); ?>
            </div>

            <?php View::factory($theme_url.'module_sidebar')->render(TRUE); ?>

            <div class="clearfix"></div>

        </div><?php /* END #content */ ?>