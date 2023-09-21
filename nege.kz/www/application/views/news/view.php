<main class="main-content">
    <div class="wrap wrap--news">
        <div class="main-content-section">
            <div class="navi">
                <a href="<?=URL::site('/news/'.$model->category->sef)?>"><?= $model->category->title ?></a>
            </div> 
            <h1>
                <?= Translator::translate($model->title) ?>
                <?= $model->get_type_icon() ?>
            </h1>

            <div class="date"><?= Date::textdate($model->date, 'd m, H:i') ?></div>

            <?php  if ($type == 'video'): ?>
                <div class="video">
                    <iframe width="100%" height="365" src="<?= $model->video ?>" frameborder="0"
                            allowfullscreen></iframe>
                </div>
            <?php  else: ?>
                <!-- вариант для одного фото -->
                <div class="news-photo">
                    <img src="<?= $model->file_s->html_img_url(742, 365) ?>" alt="<?= Translator::translate($model->title) ?>"><br>
                </div>
                <div class="news-photo_author">Фото: <?= Translator::translate($model->author_name) ?></div>
                <!-- вариант для одного фото -->

                <?php if ($model->media->count_all()) : ?>
                    <div class="news-photo_slider-wrapper">
                        <div class="news-photo_slider">
                            <?php foreach ($model->media->find_all() as $media_item) : ?>

                            <div class="news-photo_slider-item">
                                <img src="<?= $media_item->file_s->html_img_url(742, 365) ?>">
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php if ($model->media->find()->author) : ?>
                    <div class="news-photo_author">Фото: <?= Translator::translate($model->media->find()->author) ?></div>
                <?php endif ?>
                <?php endif ?>
                
                <?php  if ($type == 'audio'): ?>
                    <script>
                        media = {
                            id:<?=$model->id?>,
                            src: "<?=$model->audio_s->uri()?>",
                            title: "<?=Translator::translate($model->title)?>",
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
                            0:00/0:00
                        </div>
                        <div class="scale">
                            <div class="played" style="width: 0%;"></div>
                        </div>
                    </div>
                <?php  endif ?>
            <?php  endif ?>

            <?= Model_News::clear_html(Translator::translate($model->text)) ?>
            <?php  if (!is_null($model->infograph_s->loaded())): ?>
                <img src="<?= $model->infograph_s->html_img_url() ?>" style="max-width: 100%;">
            <?php  endif; ?>

            <?php foreach (explode(' ', $model->meta_keywords) as $keyword): ?>
                <?php if($keyword): ?> <a href="<?=URL::site('news/tag/'.$keyword)?>">#<?=Translator::translate($keyword) ?></a> <?php endif ?>
            <?php endforeach; ?>
            <div class="share">
                <div class="share-buttons">
                    Жаңалықты бөлісіңіз         &nbsp;
                    <a rel="nofollow" href="https://vk.com/share.php?url=<?=Request::current()->url('https')?>"> <!-- vk -->
                        <svg version="1.1" x="0px" y="0px" viewBox="82 -83 192 192" width="32px" height="32px">
                            <path fill="#5181B8" d="M207.4-83h-58.9C94.8-83,82-70.2,82-16.4v58.9c0,53.8,12.8,66.6,66.6,66.6h58.9c53.8,0,66.6-12.8,66.6-66.6	v-58.9C274-70.2,261.2-83,207.4-83z M237,54h-14c-5.3,0-6.9-4.3-16.4-13.8c-8.3-8-11.9-9-13.9-9c-2.8,0-3.7,0.8-3.7,4.8v12.6 c0,3.4-1.1,5.4-10,5.4c-14.8,0-31.1-9-42.7-25.6C118.9,4.1,114.2-14.3,114.2-18c0-2.1,0.8-4,4.8-4h14c3.6,0,4.9,1.6,6.3,5.4 c6.8,19.9,18.4,37.4,23.1,37.4c1.8,0,2.6-0.8,2.6-5.3V-5.1c-0.5-9.5-5.6-10.3-5.6-13.6c0-1.6,1.3-3.2,3.6-3.2h22c3,0,4,1.6,4,5.1 v27.7c0,3,1.3,4,2.2,4c1.8,0,3.3-1,6.5-4.3C207.8-0.7,214.9-18,214.9-18c0.9-2.1,2.5-4,6.1-4h14c4.2,0,5.1,2.2,4.2,5.1 c-1.8,8.2-18.8,32.2-18.8,32.2c-1.5,2.4-2.1,3.6,0,6.2c1.5,2.1,6.4,6.2,9.6,10.1c6,6.8,10.5,12.5,11.8,16.4C243,52,241,54,237,54z"></path>
                            <path fill="#FFFFFF" d="M230,31.6c-3.3-3.9-8.2-8-9.6-10.1c-2.1-2.7-1.5-3.9,0-6.2c0,0,17.1-24,18.8-32.2c0.9-3,0-5.1-4.2-5.1h-14 c-3.6,0-5.2,1.9-6.1,4c0,0-7.1,17.4-17.2,28.6c-3.3,3.3-4.7,4.3-6.5,4.3c-0.9,0-2.2-1-2.2-4v-27.7c0-3.6-1-5.1-4-5.1h-22 c-2.2,0-3.6,1.7-3.6,3.2c0,3.4,5,4.2,5.6,13.6v20.6c0,4.5-0.8,5.3-2.6,5.3c-4.7,0-16.3-17.4-23.1-37.4c-1.3-3.9-2.7-5.4-6.3-5.4	h-14c-4,0-4.8,1.9-4.8,4c0,3.7,4.7,22.1,22.1,46.4C147.9,45,164.2,54,179,54c8.9,0,10-2,10-5.4V36c0-4,0.8-4.8,3.7-4.8 c2.1,0,5.6,1,13.9,9C216.1,49.7,217.7,54,223,54h14c4,0,6-2,4.8-5.9C240.6,44.1,236.1,38.4,230,31.6z"></path>
                        </svg>
                    </a>
                    <a rel="nofollow" href="https://www.facebook.com/sharer.php?u=<?=Request::current()->url('https')?>" target="_blank"> <!-- facebook-->
                        <svg version="1.1" x="0px" y="0px" viewBox="242 -243 512 512" width="32px" height="32px">
                            <path fill="#3B5999" d="M690-243H306c-35.3,0-64,28.7-64,64v384c0,35.3,28.7,64,64,64h384c35.3,0,64-28.7,64-64v-384 C754-214.3,725.3-243,690-243z"></path>
                            <path fill="#FFFFFF" d="M594,13v-64c0-17.7,14.3-16,32-16h32v-80h-64c-53,0-96,43-96,96v64h-64v80h64v176h96V93h48l32-80H594z"></path>
                        </svg>
                    </a>

                    <a rel="nofollow" href="https://twitter.com/share?url=<?=Request::current()->url('https')?>" target="_blank"> <!-- twitter -->
                        <svg version="1.1" x="0px" y="0px" viewBox="0 0 32 32" width="32px" height="32px">
                            <path fill="#1A9BC5" d="M28,32H4c-2.2,0-4-1.8-4-4V4c0-2.2,1.8-4,4-4h24c2.2,0,4,1.8,4,4v24C32,30.2,30.2,32,28,32z"></path>
                            <path fill="#FFFFFF" d="M12.3,24.1c7.5,0,11.7-6.3,11.7-11.7c0-0.2,0-0.4,0-0.5c0.8-0.6,1.5-1.3,2-2.1	c-0.7,0.3-1.5,0.5-2.4,0.6c0.8-0.5,1.5-1.3,1.8-2.3c-0.8,0.5-1.7,0.8-2.6,1c-0.8-0.8-1.8-1.3-3-1.3c-2.3,0-4.1,1.8-4.1,4.1 c0,0.3,0,0.6,0.1,0.9c-3.4-0.2-6.4-1.8-8.5-4.3C7,9.2,6.8,9.9,6.8,10.7c0,1.4,0.7,2.7,1.8,3.4c-0.7,0-1.3-0.2-1.9-0.5v0.1 c0,2,1.4,3.6,3.3,4c-0.3,0.1-0.7,0.1-1.1,0.1c-0.3,0-0.5,0-0.8-0.1c0.5,1.6,2,2.8,3.8,2.8c-1.4,1.1-3.2,1.8-5.1,1.8 c-0.3,0-0.7,0-1-0.1C7.8,23.4,10,24.1,12.3,24.1"></path>
                        </svg>
                    </a>
                </div>
                <div class="clear"></div>
            </div>

            <div class="news-author-wrapper">
          <script async src="https://yastatic.net/pcode-native/loaders/loader.js"></script>
            <script>
                (yaads = window.yaads || []).push({
                    id: "512006-7",
                    render: "#id-512006-7"
                });
            </script>
            
            <br>
            <?php if($model->author->loaded()) : ?>
                <div class="news-author-b">
                    <div class="news-author_title">Автор: <?=Translator::translate($model->author->name)?></div>
                    <?php foreach ($model->author->news()->limit(5)->where('id', '<>', $model->id)->find_all() as $item) : ?>
                        <a href="<?=$item->view_url(); ?>" class="news-author_item"><?=Translator::translate($item->title)?></a>
                    <?php endforeach; ?>
                    <a href="<?=$model->author->view_url() ?>" class="news-author_link"><?=__('Все новости автора')?></a>
                </div>
                <!-- Yandex.RTB R-A-512006-3 
                <div id="yandex_rtb_R-A-512006-3"></div>
                <script type="text/javascript">
                    (function(w, d, n, s, t) {
                        w[n] = w[n] || [];
                        w[n].push(function() {
                            Ya.Context.AdvManager.render({
                                blockId: "R-A-512006-3",
                                renderTo: "yandex_rtb_R-A-512006-3",
                                async: true
                            });
                        });
                        t = d.getElementsByTagName("script")[0];
                        s = d.createElement("script");
                        s.type = "text/javascript";
                        s.src = "//an.yandex.ru/system/context.js";
                        s.async = true;
                        t.parentNode.insertBefore(s, t);
                    })(this, this.document, "yandexContextAsyncCallbacks");
                </script>-->
            <?php endif ?>
            </div>
            <div class="r38648"></div>
            <script type="text/javascript">
                (function() {
                    var worker38648,
                        tickerID = 38648,
                        tag = (function() {
                            var scripts = document.getElementsByClassName('r38648'),
                                len = scripts.length;
                            return len ? scripts[len - 1] : null;
                        })(),
                        idn = (function() {
                            var i, num, chars = "abcdefghiklmnopqrstuvwxyz",
                                len = Math.floor((Math.random() * 2) + 4),
                                idn = '';
                            for (i = 0; i < len; i++) {
                                num = Math.floor(Math.random() * chars.length);
                                idn += chars.substring(num, num + 1);
                            }
                            return idn;
                        })();

                    var container = document.createElement('div');
                    container.id = idn;
                    container.innerHTML = 'загрузка...';
                    tag.parentNode.insertBefore(container, tag);

                    var script = document.createElement('script');
                    script.setAttribute('class', 's38648');
                    script.setAttribute('data-idn', idn);
                    script.type = 'text/javascript';
                    script.charset = 'utf-8';
                    tag.parentNode.insertBefore(script, tag);
                })();
            </script>
        </div>
       <aside class="right-col-section">
			<div class="clear"></div>
            <?=View::factory('news/popular')->bind('popular_news',$popular_news)->render();?>
            <!-- Yandex.RTB R-A-512006-4 
            <div id="yandex_rtb_R-A-512006-4"></div>
            <script type="text/javascript">
                (function(w, d, n, s, t) {
                    w[n] = w[n] || [];
                    w[n].push(function() {
                        Ya.Context.AdvManager.render({
                            blockId: "R-A-512006-4",
                            renderTo: "yandex_rtb_R-A-512006-4",
                            async: true
                        });
                    });
                    t = d.getElementsByTagName("script")[0];
                    s = d.createElement("script");
                    s.type = "text/javascript";
                    s.src = "//an.yandex.ru/system/context.js";
                    s.async = true;
                    t.parentNode.insertBefore(s, t);
                })(this, this.document, "yandexContextAsyncCallbacks");
            </script>-->
        </aside>
        <div class="clear"></div>
    </div>
</main>

<?php
$banner = Model_Banner::get_banner(4);
    $detect = new Mobile_Detect();
    $is_mobile = $detect->isMobile();
    ?>

<?php if ($banner && $is_mobile) : ?>
    <a href="<?=$banner->view_url()?>" <?=$banner->target_blank == 1 ? 'target="_blank"' : ''?> rel="noreferrer noopener" class="fixed-banner">
        <img src="<?=$banner->file_url(true)?>" alt="<?=$banner->title?>">
    </a>
<?php endif; ?>


<?php  if ($type == 'audio'): ?>
    <script type="text/javascript" src="/js/single_media.js"></script>
<?php  endif; ?>

<script>
    $(function() {
        $('iframe').wrap("<div class='video-wrapper'></div>")
    })
</script>

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
