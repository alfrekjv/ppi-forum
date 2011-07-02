<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Qanda pagination style
 *
 * A modification form punBB pagination style
 * 
 * @preview  1 … 4 5 6 7 8 … 15
 */
?>

<?php if($total_pages > 1): ?>
<div class="pagination clearfix">

	<?php if ($current_page > 3): ?>
        <span class="page first_page page_1">
            <a href="<?php echo str_replace('{page}', 1, $url) ?>">1</a>
        </span>

        <?php if ($current_page != 4): ?>
            <span class="ellipsis">
                 <?php echo '&hellip;' ?>
            </span>
        <?php endif; ?>
	<?php endif; ?>


	<?php for ($i = $current_page - 2, $stop = $current_page + 3; $i < $stop; ++$i): ?>

		<?php if ($i < 1 OR $i > $total_pages) continue ?>

		<?php if ($current_page == $i): ?>
            <span class="page current_page page_<?php echo $i; ?>">
                <?php echo $i ?>
            </span>
		<?php else: ?>
            <span class="page page_<?php echo $i; ?>">
                <a href="<?php echo str_replace('{page}', $i, $url) ?>">
                    <?php echo $i ?>
                </a>
            </span>
		<?php endif; ?>

	<?php endfor; ?>


	<?php if ($current_page <= $total_pages - 3): ?>
        <?php if ($current_page != $total_pages - 3): ?>
            <span class="ellipsis">
                 <?php echo '&hellip;' ?>
            </span>
        <?php endif; ?>

        <span class="page last_page page_<?php echo $total_pages; ?>">
            <a href="<?php echo str_replace('{page}', $total_pages, $url) ?>">
                <?php echo $total_pages ?>
            </a>
        </span>
	<?php endif ?>

</div>
<?php endif; ?>