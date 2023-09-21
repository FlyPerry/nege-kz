<main class="main-content">
    <div class="wrap">
        <div class="main-content-section">
            <h1><?=$model->title?></h1>
            <div class="date"><?=Date::textdate($model->created_at,'d m, H:i')?></div>
            <?php if ($model->file_s->loaded()): ?>
                <div class="video">
                    <img src="<?=$model->file_s->html_img_url(742, 365)?>">
                </div>
            <?php endif ?>
            <?=$model->description?>
        </div>
        <aside class="right-col-section">
            <div class="clear"></div>
            <?=View::factory('news/popular')->bind('popular_news',$popular_news)->render();?>
        </aside>
        <div class="clear"></div>
    </div>
</main>

