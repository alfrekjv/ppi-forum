<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<?php
/**
* Generic Master Page
*
* @since 1.0.0
* @package Qanda
* @subpackage View
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US">

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php echo html::script('media/js/jquery-1.4.2.min.js'); ?>
    <?php echo html::script('media/js/jquery.tooltip-1.3.min.js'); ?>
    <?php echo $head; ?>
</head>

<body>

    <script type="text/javascript">
        <?php if($this->user->id != 0): ?>
            var user_role = 'registered';
        <?php else: ?>
            var user_role = 'guest';
        <?php endif; ?>
    </script>

    <div id="wrapper">

        <div id="header" class="clearfix">
            <div class="logo">
                <a href="<?php echo url::site(); ?>">
                    <?php echo html::image('media/themes/'.$this->settings->get('current_theme').'/images/qanda-logo.png'); ?>
                </a>
            </div>
            <div class="title">
                <h1>
                    <?php echo html::anchor('/', $this->settings->get('site_name')); ?>
                </h1>
                <p>
                    <?php echo $this->settings->get('site_description'); ?>
                </p>
            </div>
        </div><?php /* END #header */ ?>

        
        <div id="navigation">
        <div id="navigation-inner" class="clearfix">
            <ul class="clearfix">
                <li class="first"><?php echo html::anchor('/', 'Questions'); ?></li>
                <li><?php echo html::anchor('/tags/browse', 'Tags'); ?></li>
                <li><?php echo html::anchor('/users/browse', 'Users'); ?></li>
                <li><?php echo html::anchor('/questions/unanswered', 'Unanswered'); ?></li>
                <li class="last"><?php echo html::anchor('/questions/ask', 'Ask Question'); ?></li>
            </ul>
        </div>
        </div><?php /* END #navigation */ ?>

        <?php echo $content; ?>
        
        <div id="footer">
        <div id="footer-inner">
            <p>
                Your questions are powered by <a href="http://www.qandasystem.com/">Qanda</a> version <?php echo $current_version; ?>.
                User contributed content licensed under <a href="http://creativecommons.org/licenses/by-sa/3.0/" rel="external">cc-wiki</a>.
            </p>
            <p>
                Execution time: {execution_time} seconds and Memory usage: {memory_usage}
            </p>
        </div>
        </div><?php /* END #footer */ ?>

    </div><?php /* END #wrapper */ ?>
</body>
</html>