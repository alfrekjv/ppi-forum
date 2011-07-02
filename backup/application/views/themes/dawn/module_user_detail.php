<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
                <?php /* User Details */ ?>
                <?php
                    $authentic = Auth::factory();
                    $user = $authentic->get_user();
                ?>
                <div id="user-widget" class="widget">
                    <h3>Control Panel</h3>
                    <ul>
                        <li>Name: <?php echo html::anchor('users/detail/'.$user->username, $user->display_name); ?></li>
                        <li>Reputation: <?php echo $user->reputation_score; ?></li>
                        <li>Badges: <?php echo $user->badge_count; ?></li>
                        <li>
                            <?php
                                $log_out_link = '/users/logout?redirect_url='.url::current();
                                echo html::anchor($log_out_link, 'Log out');
                            ?>
                        </li>
                    </ul>
                </div>
