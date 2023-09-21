<main class="main-content">
    <div class="wrap">
        <div class="main-content-section">
            <h1><?=$model->title?></h1>
            <div class="date"><?=Date::textdate($model->created_at,'d m, H:i')?></div>
            <div class="video">
                <img src="<?=$model->file_s->html_img_url(742, 365)?>">
            </div>
            <?=$model->description?>
        </div>
        <aside class="right-col-section">
            <div class="index-page-adv right">
                <a href="#"><img src="/img/subscribe.jpg"></a>
            </div>
            <div class="clear"></div>
            <?=View::factory('news/popular')->bind('popular_news',$popular_news)->render();?>
        </aside>
        <div class="clear"></div>
    </div>
</main>
