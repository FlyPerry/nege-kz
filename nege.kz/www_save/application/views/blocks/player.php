<?php
$lastest_news = ORM::factory('News')
    ->where('lang','=',I18n::$lang)
    ->where('status', '=', 1)
    ->where('date', '<=', date('Y-m-d H:i:s'))
    ->order_by('date', 'DESC')
    ->where('audio', '!=', null);
$last_news = ORM::factory('News')
    ->where('lang','=',I18n::$lang)
    ->where('status', '=', 1)
    ->where('date', '<=', date('Y-m-d H:i:s'))
    ->order_by('date', 'DESC')
    ->where('audio', '!=', null)
    ->limit(20);
if (!isset($category) || $category == 0){
    $lastest_news = $lastest_news->find();
    $last_news = $last_news->find_all();
}
else{
    $lastest_news = $lastest_news->where('category_id', '=', $category)->find();
    $last_news = $last_news->where('category_id', '=', $category)->find_all();
};
?>
<?php
if($lastest_news->loaded()):
    ?>
    <section class="player">
        <div class="wrap">
            <div class="left-buttons">
                <a href="#" class="prev"><img src="/img/prev.png"></a>
                <a id="playpause_main" class="playpause" data-duration="<?=$lastest_news->audio_duration?>"
                   data-src="<?=$lastest_news->audio_s->uri()?>"
                   data-date="<?=$lastest_news->date()?>"
                   data-title="<?=$lastest_news->title?>" href="#"
                   class="pause"><img id="main_play_button" class="main_play_pause" src="/img/play.png"></a>
                <a href="#" class="next"><img src="/img/next.png"></a>
            </div>
            <div class="name">
                <marquee><?=$lastest_news->date()?> <?=$lastest_news->title?></marquee>
            </div>
            <div class="right-buttons">
                <a href="#" class="sound"><img src="/img/sound.png"></a>
                <a href="#" class="player-menu"></a>
            </div>
            <div class="time">
                0:00/0:00
            </div>
            <div class="scale">
                <div class="played" style="width: 0%;"></div>
            </div>
            <div class="play-list">
                <?php $pos = 0;?>
                <?php foreach($last_news as $model):?>
                    <?php if(!$model->audio_s->loaded()) continue;?>
                    <div class="item">
                        <div class="button">
                            <a data-pos="<?=$pos?>" class="playpause" data-id="<?=$model->id?>" data-duration="<?=$model->audio_duration?>" href="#"
                               data-src="<?=$model->audio_s->uri()?>" data-date="<?=$model->date()?>"
                               data-title="<?=$model->title?>"><img
                                    src="/img/play.png"></a>
                        </div>
                        <div class="song-name">
                            <span><?=$model->date()?></span> <?=$model->title?>
                        </div>
                        <div class="song-time">
                            <?=round($model->audio_duration/60).":".($model->audio_duration%60)?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <?php $pos+=1;?>
                <?php endforeach;?>
            </div>
        </div>
        </div>
    </section>
    <script type="text/javascript" src="/js/media.js"></script>
<?php endif;?>