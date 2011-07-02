<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
                <?php /* Static Welcome Message */ ?>
                <div id="welcome-widget" class="widget">
                    <h3>Welcome to Qanda Demostration</h3>
                    <p>
                        This is a demostration website with our latest 
                        <a href="http://www.qandasystem.com/">Qanda QAS</a> beta.
                    </p>
                    <p>
                        Capability of current beta is as listed on 
                        <a href="http://wiki.github.com/qanda/Qanda/">GitHub wiki</a>.
                        If you have found any unknown issues or would like to mention
                        new features, please do so through 
                        <a href="http://github.com/qanda/Qanda/issues">GitHub's issue system</a>.
                    </p>
                </div>

                <div id="version-widget" class="widget">
                    <p>
                        You are running on Qanda version <strong><?php echo $current_version; ?></strong>.
                    </p>
                    <p>
                        For list of recent updates and to see what's changed, visit our
                        <a href="http://wiki.github.com/qanda/Qanda/qanda-changelog">changelog</a>
                        on GitHub.
                    </p>
                </div>