<main class="main-content">
    <div class="wrap">
        <div class="main-content-section">
            <div class="navi">
                <a href="<?=URL::site(I18n::$lang.'/news/'.$model->category->sef)?>"><?= $model->category->title ?></a>
            </div>
            <h1>
                <?= $model->title ?>
                <?= $model->get_type_icon() ?>
            </h1>

            <div class="date"><?= Date::textdate($model->date, 'd m, H:i') ?></div>

            <?php  if ($type == 'video'): ?>
                <div class="video">
                    <iframe width="742" height="365" src="<?= $model->video ?>" frameborder="0"
                            allowfullscreen></iframe>
                </div>
            <?php  else: ?>
                <div class="news-photo">
                    <img src="<?= $model->file_s->html_img_url(742, 365) ?>"><br>
                    Фото: <?= $model->author_name ?>
                </div>
                <?php  if ($type == 'audio'): ?>
                    <script>
                        media = {
                            id:<?=$model->id?>,
                            src: "<?=$model->audio_s->uri()?>",
                            title: "<?=$model->title?>",
                            duration:<?=$model->audio_duration?>,
                            date: "<?=$model->date()?>",
                            position: 0
                        }
                    </script>
                    <div class="news-player">
                        <div class="left-buttons">
                            <a href="#" class="pause playpause"><img src="/img/play.png"></a>
                        </div>
                        <div class="time">
                            0:00/<?= round($model->audio_duration/60).":".($model->audio_duration%60)?>
                        </div>
                        <div class="scale">
                            <div class="played" style="width: 0%;"></div>
                        </div>
                    </div>
                <?php  endif ?>
            <?php  endif ?>

            <?= $model->text ?>
            <?php  if (!is_null($model->infograph_s->loaded())): ?>
                <img src="<?= $model->infograph_s->html_img_url() ?>" style="max-width: 100%;">
            <?php  endif; ?>
            <div class="share">
                <div class="share-buttons">
                    Жаңалықты бөлісіңіз&nbsp;
                    <script type="text/javascript">var switchTo5x = true;</script>
                    <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
                    <script type="text/javascript">stLight.options({
                            publisher: "584be08a-4978-4daf-b4f8-13ac7cc1da88",
                            doNotHash: false,
                            doNotCopy: false,
                            hashAddressBar: false,
                            servicePopup: true
                        });</script>
                    <span class='st_sharethis_large' displayText='ShareThis'></span>
                    <span class='st_vkontakte_large' displayText='Vkontakte'></span>
                    <span class='st_facebook_large' displayText='Facebook'></span>
                    <span class='st_googleplus_large' displayText='Google +'></span>
                    <span class='st_twitter_large' displayText='Tweet'></span>
                    <span class='st_mail_ru_large' displayText='mail.ru'></span>
                    <span class='st_odnoklassniki_large' displayText='Odnoklassniki'></span>
                    <span class='st_livejournal_large' displayText='LiveJournal'></span>
                    <span class='st_linkedin_large' displayText='LinkedIn'></span>
                    <span class='st_pinterest_large' displayText='Pinterest'></span>
                    <span class='st_myspace_large' displayText='MySpace'></span>
                    <span class='st_email_large' displayText='Email'></span>
                    <span class='st_print_large' displayText='Print'></span>
                </div>
                <!--                <button>Комментировать</button>-->
                <div class="clear"></div>
            </div>
            <?php  if ($other_category_news->count() > 0): ?>
                <div class="other-news">
                    <div class="zag"><?= __('Другое на эту тему') ?></div>
                    <!--Популярные с этой категории -->
                    <?php  foreach ($other_category_news as $oc_item): ?>
                        <div class="item">
                            <span><?= Date::textdate($oc_item->date, 'd m') ?></span>
                            <a href="<?= $oc_item->view_url() ?>"><?= $oc_item->title ?></a>

                            <div class="clear"></div>
                        </div>
                    <?php  endforeach ?>
                </div>
            <?php  endif ?>

            <?php  if ($last_category_news->count() > 0): ?>
                <!--Последние с этой категории-->
                <div class="last-news-list two-col">
                    <div class="zag"><?= $model->category->title ?></div>
                    <div class="last-news-list">
                        <?php  foreach ($last_category_news as $lc_item): ?>
                            <div class="item">
                                <div class="image"
                                     style="background: url(<?= $lc_item->file_s->html_img_url(360, 202) ?>) no-repeat center; background-size: cover;"></div>
                                <div class="content">
                                    <?= Date::textdate($lc_item->date, 'd m') ?>
                                    <a href="<?= $lc_item->view_url() ?>" class="news-name">
                                        <?= $lc_item->title ?>
                                        <?= $lc_item->get_type_icon() ?>
                                    </a>

                                    <?= $lc_item->description ?>
                                </div>
                            </div>
                        <?php  endforeach ?>
                        <div class="clear"></div>
                    </div>
                </div>
            <?php  endif ?>
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
<?php  if ($type == 'audio'): ?>
    <script type="text/javascript" src="/js/single_media.js"></script>
<?php  endif; ?>

<script type="application/ld+json">
            {
                "@context": "http://schema.org",
                "@type": "NewsArticle",
                "mainEntityOfPage":{
                    "@type":"WebPage",
                    "@id":"<?= Request::$current->url('http') ?>"
                },
                "headline": "<?= Text::limit_chars(htmlentities($model->get_annotation(true)), 107) ?>",
                "image": {
                    "@type": "ImageObject",
                    "url": "<?= URL::site($model->file_s->html_img_url(1140, 696), 'http') ?>",
                    "height": 1140,
                    "width": 696
                },
                <?php  if ($model->audio): ?>
                "audio":    {
                    "@context": "http://schema.org",
                    "@type": "AudioObject",
                    "contentUrl": "<?= $model->audio_s->full_path() ?>",
                    "description": "<?= Text::limit_chars(htmlentities($model->get_annotation(true)), 107) ?>",
                    "duration": "<?= $model->get_schema_duration() ?>",
                    "encodingFormat": "<?= $model->audio_s->type ?>",
                    "name": "<?= $model->title ?>"
                },
                <?php  endif ?>
                <?php  if ($model->video): ?>
                "video":    {
                    "@context": "http://schema.org",
                    "@type": "VideoObject",
                    "name": "<?= $model->title ?>",
                    "description": "<?= Text::limit_chars(htmlentities($model->get_annotation(true)), 150) ?>",
                    "thumbnailUrl": "<?= $model->get_thumbnail($model->file_s->html_img_url(220, 124)) ?>",
                    "uploadDate": "<?= Date::formatted_time($model->date, DATE_ATOM) ?>"
                },
                <?php  endif ?>
                "datePublished": "<?= Date::formatted_time($model->date, DATE_ATOM) ?>",
                "dateModified": "<?= Date::formatted_time($model->updated_at, DATE_ATOM) ?>",
                "author": {
                    "@type": "Person",
                    "name": "<?= $model->author_name ? $model->author_name : 'BNews.kz' ?>"
                },
                "publisher": {
                    "@type": "Organization",
                    "name": "NewsFeeds",
                    "logo": {
                        "@type": "ImageObject",
                        "url": "<?= URL::site('img/logo.jpg', 'http') ?>",
                        "width": 225,
                        "height": 60
                    }
                },
                "description": "<?= Text::limit_chars(htmlentities($model->get_annotation(true)), 150) ?>"
            }



</script>
