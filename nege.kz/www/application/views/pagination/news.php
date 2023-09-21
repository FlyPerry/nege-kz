<div class="pager">
    <?php if ($previous_page !== FALSE): ?>
        <a href="<?php echo HTML::chars($page->url($previous_page)) ?>" class="prev"><?php echo __('Назад') ?></a>
    <?php else: ?>
        <a href="#" class="prev"><?php echo __('Назад') ?></a>
    <?php endif ?>
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <?php if ($i == $current_page): ?>
            <a href="#" class="current"><?= $i ?></a>
        <?php elseif($i === 1): ?>
            <a href="<?php echo HTML::chars(str_replace('/page-1', '', $page->url($i))) ?>"><?php echo $i ?></a>
        <?php else: ?>
            <a href="<?php echo HTML::chars($page->url($i)) ?>"><?php echo $i ?></a>
        <?php endif ?>
    <?php endfor ?>
    <?php if ($next_page !== FALSE): ?>
        <a href="<?php echo HTML::chars($page->url($next_page)) ?>" class="next"><?php echo __('Дальше') ?></a>
    <?php else: ?>
        <a href="#" class="next"><?php echo __('Дальше') ?></a>
    <?php endif ?>
    <div class="clear"></div>
</div><!-- .pagination -->
