<main class="main-content">
    <div class="wrap wrap--news" style="margin: 0 auto 40px;"> <!-- стили добавлены для отступа для теста -->

        <?php foreach ($model->chapters->order_by('priority', 'asc')->find_all() as $index => $chapter): ?>
            <div class="longread-item" id="lg<?=$index+1?>">
                <div class="longread-top" style="background-image: url('<?=$chapter->file_s->html_img_url(1200, 400) ?>')">
                    <h1><?=Translator::translate($chapter->title)?></h1>
                </div>
                <div class="longread-item_content">
                    <div class="longread-item_right" id="longread-links">
                        <div class="longread-chapter_wrapper">
                            <span class="longread-chapter_title"><?=__('Содержание')?>:</span>

                            <?php foreach ($model->chapters->order_by('priority', 'asc')->find_all() as $menuChapterIndex => $menuChapter): ?>
                                <a href="#lg<?=$menuChapterIndex+1?>" class="longread-chapter <?php if($menuChapterIndex == $index): ?>active<?php endif ?>"><span><?=Translator::translate($menuChapter->sub_title)?></span></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="longread-item_text">
                        <h2><?=$chapter->sub_title?></h2>
                        <?= Model_News::clear_html(Translator::translate($chapter->text)) ?>
                    </div>
                    <div class="longread-item_left">
                        <?php if($index == 0): ?>
                        <div class="news-author-b">
                            <div class="news-author_title-sm">
                                <span>Автор:</span>
                                <?=Translator::translate($model->author->name)?>
                            </div>
                            <?php if ($model->author->photo_s->loaded()): ?>
                                <div class="news-author_pic" style="background-image: url('<?=$model->author->photo_s->html_img_url(300, 300)?>');"></div>
                            <?php endif ?>
                            <span class="news-author_last"><?=__('Последние статьи автора')?></span>

                            <?php foreach ($model->author->news()->limit(5)->where('id', '<>', $model->id)->find_all() as $item) : ?>
                                <a href="<?=$item->view_url(); ?>" class="news-author_item"><?=Translator::translate($item->title)?></a>
                            <?php endforeach; ?>
                            <a href="<?=$model->author->view_url() ?>" class="news-author_link"><?=__('Все новости автора')?></a>
                        </div>
                        <?php endif ?>
                        <?php if ($chapter->sidebar_status == 1): ?>
                        <div class="longread-fact">
                            <?= Model_News::clear_html(Translator::translate($chapter->sidebar_text)) ?>

                                    </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

       <!-- <div class="longread-item" id="lg1">
            <div class="longread-top" style="background-image: url('/pic/lg1.png')">
                <h1>Бос тұрған "барахолка". Қытай тауарларын сатып жүрген саудагерлер вирустан опық жемек</h1>
            </div>
            <div class="longread-item_content">
                <div class="longread-item_right" id="longread-links">
                    <div class="longread-chapter_wrapper">
                        <span class="longread-chapter_title">Содержание:</span>
                        <a href="#lg1" class="longread-chapter active"><span>Глава 1</span></a>
                        <a href="#lg2" class="longread-chapter"><span>Глава 2</span></a>
                        <a href="#lg3" class="longread-chapter"><span>Глава 3</span></a>
                    </div>
                </div>
                <div class="longread-item_text">
                    <h2>Глава 1</h2>
                    <p>"Олардың кем дегенде үштен бірі Қытай тауарларын алып-сатумен жүргенін ескерсек, бір ғана Алматыда 16 мың жеке кәсіпкер күйіп кетуі мүмкін" дейді, Экономикалық бастамаларды қолдау қорының сарапшылары.</p>
                    <img src="http://placehold.it/1000x800">
                    <span>Фото: tengrinews.kz</span>
                </div>
                <div class="longread-item_left">
                    <div class="news-author-b">
                        <div class="news-author_title-sm">
                            <span>Автор:</span>
                            <?/*=Translator::translate($model->author->name)*/?>
                        </div>
                        <?php /*if ($model->author->photo_s->loaded()): */?>
                            <div class="news-author_pic" style="background-image: url('<?/*=$model->author->photo_s->html_img_url(300, 300)*/?>');"></div>
                        <?php /*endif */?>
                        <span class="news-author_last">Последние статьи автора</span>

                        <?php /*foreach ($model->author->news()->limit(5)->where('id', '<>', $model->id)->find_all() as $item) : */?>
                            <a href="<?/*=$item->view_url(); */?>" class="news-author_item"><?/*=Translator::translate($item->title)*/?></a>
                        <?php /*endforeach; */?>
                        <a href="<?/*=$model->author->view_url() */?>" class="news-author_link"><?/*=__('Все новости автора')*/?></a>
                    </div>
                </div>
            </div>
        </div>-->
        <!--<div class="longread-item" id="lg2">
            <div class="longread-top" style="background-image: url('/pic/lg1.png')">
                <h2>Бос тұрған "барахолка". Қытай тауарларын сатып жүрген саудагерлер вирустан опық жемек</h2>
            </div>
            <div class="longread-item_content">
                <div class="longread-item_right">
                    <div class="longread-chapter_wrapper">
                        <span class="longread-chapter_title">Содержание:</span>
                        <a href="#lg1" class="longread-chapter"><span>Глава 1</span></a>
                        <a href="#lg2" class="longread-chapter active"><span>Глава 2</span></a>
                        <a href="#lg3" class="longread-chapter"><span>Глава 3</span></a>
                    </div>
                </div>
                <div class="longread-item_text">
                    <h2>Глава 2</h2>
                    <p>"Олардың кем дегенде үштен бірі Қытай тауарларын алып-сатумен жүргенін ескерсек, бір ғана Алматыда 16 мың жеке кәсіпкер күйіп кетуі мүмкін" дейді, Экономикалық бастамаларды қолдау қорының сарапшылары.</p>
                    <img src="http://placehold.it/1000x800">
                    <span>Фото: tengrinews.kz</span>
                </div>
                <div class="longread-item_left">
                    <div class="longread-fact">
                        <img src="/pic/lg1.png">
                        <p>"Олардың кем дегенде үштен бірі Қытай тауарларын алып-сатумен жүргенін ескерсек, бір ғана Алматыда 16 мың жеке кәсіпкер күйіп кетуі мүмкін" дейді, Экономикалық бастамаларды қолдау қорының сарапшылары.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="longread-item" id="lg3">
            <div class="longread-top" style="background-image: url('/pic/lg1.png')">
                <h2>Бос тұрған "барахолка". Қытай тауарларын сатып жүрген саудагерлер вирустан опық жемек</h2>
            </div>
            <div class="longread-item_content">
                <div class="longread-item_right">
                    <div class="longread-chapter_wrapper">
                        <span class="longread-chapter_title">Содержание:</span>
                        <a href="#lg1" class="longread-chapter"><span>Глава 1</span></a>
                        <a href="#lg2" class="longread-chapter"><span>Глава 2</span></a>
                        <a href="#lg3" class="longread-chapter active"><span>Глава 3</span></a>
                    </div>
                </div>
                <div class="longread-item_text">
                    <h2>Глава 3</h2>
                    <p>"Олардың кем дегенде үштен бірі Қытай тауарларын алып-сатумен жүргенін ескерсек, бір ғана Алматыда 16 мың жеке кәсіпкер күйіп кетуі мүмкін" дейді, Экономикалық бастамаларды қолдау қорының сарапшылары.</p>
                    <iframe src="https://www.youtube.com/embed/VMfE5Es8cHM" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="longread-item_left">
                    <div class="longread-fact">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/---9nh-zsOM" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <p>"Олардың кем дегенде үштен бірі Қытай тауарларын алып-сатумен жүргенін ескерсек, бір ғана Алматыда 16 мың жеке кәсіпкер күйіп кетуі мүмкін" дейді, Экономикалық бастамаларды қолдау қорының сарапшылары.</p>
                        <p>"Олардың кем дегенде үштен бірі Қытай тауарларын алып-сатумен жүргенін ескерсек, бір ғана Алматыда 16 мың жеке кәсіпкер күйіп кетуі мүмкін" дейді, Экономикалық бастамаларды қолдау қорының сарапшылары.</p>
                        <p>"Олардың кем дегенде үштен бірі Қытай тауарларын алып-сатумен жүргенін ескерсек, бір ғана Алматыда 16 мың жеке кәсіпкер күйіп кетуі мүмкін" дейді, Экономикалық бастамаларды қолдау қорының сарапшылары.</p>
                    </div>
                    <div class="news-author-b --mob">
                        <div class="news-author_title-sm">
                            <span>Автор:</span>
                            Серiк Рахым
                        </div>
                        <div class="news-author_pic" style="background-image: url('http://placehold.it/300x300');"></div>
                        <span class="news-author_last">Последние статьи автора</span>
                        <a href="" class="news-author_item">Почему бы не подраться в Национальном совете?</a>
                        <a href="" class="news-author_item">Оқушыны бұтына жіберуге мәжбүрлеген мұғалім жұмыстан кетті</a>
                        <a href="" class="news-author_item">Оқушыны бұтына жіберуге мәжбүрлеген мұғалім жұмыстан кетті</a>
                        <a href="" class="news-author_item">Boeing 737 МАХ ұшағы қауіпті деп танылды</a>
                        <a href="" class="news-author_item">слайдер</a>
                        <a href="" class="news-author_link">Автордың барлық жазбалары</a>
                    </div>
                </div>
            </div>
        </div>-->
        <a href="#longread-links" class="longread-link">К содержанию</a>
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
