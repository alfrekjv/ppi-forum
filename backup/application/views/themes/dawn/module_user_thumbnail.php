<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

                        <div class="user-summary clearfix">
                            <div class="avatar">
                                <a href="<?php echo url::site('users/detail/'.$user->username); ?>">
                                    <?php /* TODO: Use real gravatar API */ ?>

                                    <img src="<?php echo $user->get_gravatar_url(32); ?>" width="32" height="32" alt="" />
                                </a>
                            </div>
                            <div class="user-details">
                                <a href="<?php echo url::site('users/detail/'.$user->username); ?>">
                                    <?php echo $user->display_name; ?>
                                </a>
                                <br/>
                                <span class="reputation">
                                    <?php echo $user->reputation_score; ?>
                                </span>
                                <?php /***travo20100313: | B:<?php echo $question->user->badge_count; ?> */ ?>
                            </div>
                        </div>