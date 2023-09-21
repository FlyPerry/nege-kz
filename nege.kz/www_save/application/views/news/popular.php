<div class="popular-news">
    <div class="zag"><?= __('Популярное') ?></div>
    <?php  foreach ($popular_news as $p_item): ?>
        <div class="item">
            <img src="<?= $p_item->file_s->html_img_url(85, 48) ?>" class="image">

            <div class="content">
                <?= Date::formatted_time($p_item->date, 'd.m.y') ?>
                <a href="<?=$p_item->view_url()?>"><?=$p_item->title?></a>
            </div>
            <div class="clear"></div>
        </div>
    <?php  endforeach ?>
</div>