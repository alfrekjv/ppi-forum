<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
/**
* Tag List Partial View
*
* @since 1.0.0
* @package Qanda
* @subpackage View
*/
?>
        <div id="content">
            
            <div class="main-bar">

                <div class="subheader">
                    <h2>Tags</h2>
                </div>

                <div class="page-description">
                    <p>
                        Questions are grouped by tags. Using the right tags makes it easier for others to find and answer your question.
                    </p>
                </div>

                <div class="tags clearfix">
                    <?php foreach($tags as $index => $tag): ?>
                        <div class="tag-summary clearfix">
                            <span class="tag">
                                <?php echo html::anchor('questions/tagged/'.$tag->slug, $tag->name, array('rel'=>'tag')); ?>
                            </span>
                            <span class="count">
                                <?php echo $tag->post_count; ?>
                            </span>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div><?php /* END .main-bar */ ?>

            
            <?php View::factory($theme_url.'module_sidebar')->render(TRUE); ?>

            <div class="clearfix"></div>

        </div><?php /* END #content */ ?>