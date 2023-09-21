<div class="popular-news">
    <div class="zag"><?= __('Популярное') ?></div>
    <?php  foreach ($popular_news as $p_item): ?>
        <div class="item">
            <div class="content">
                <?= Date::formatted_time($p_item->date, 'd.m.y') ?>
                <a href="<?=$p_item->view_url()?>"><?=Translator::translate($p_item->title)?></a>
            </div>
            <div class="clear"></div>
        </div>
    <?php  endforeach ?>
</div>