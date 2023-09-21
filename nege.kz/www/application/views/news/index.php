<?=View::factory("blocks/player")->set("category", $category->id)->render()?>
<main class="main-content">
    <div class="wrap">
        <div class="main-content-section">
            <h1><?=Translator::translate($category->title)?></h1>
            <?php $i=0;?>
            <?php  foreach ($collection as $item): ?>
            <?php if($i==0):?>
            <div class="last-news-list middle">
                <a href="<?=$item->view_url()?>" class="item">
                    <div class="image" style="background: url('<?=$item->file_s->html_img_url(360,202)?>') no-repeat center; background-size: cover;"></div>
                    <div class="content">
                        <?=$item->date()?> <span class="news-name"><?=Translator::translate($item->title)?><?=$item->get_type_icon()?></span>
                        <p><?=Translator::translate($item->get_annotation(true))?></p>
                    </div>
                    <div class="clear"></div>
                </a>
            </div>

            <div class="last-news-list two-col">
            <?php else:?>
                <a href="<?=$item->view_url()?>" class="item">
                    <div class="image" style="background: url('<?=$item->file_s->html_img_url(360,202)?>') no-repeat center; background-size: cover;"></div>
                    <div class="content">
                        <?=$item->date()?> <span class="news-name"><?=Translator::translate($item->title)?><?=$item->get_type_icon()?></span>
                        <p><?=Translator::translate($item->get_annotation(true))?></p>
                    </div>
                </a>
                <?php endif?>
                <?php $i++;?>
            <?php  endforeach ?>
                <div class="clear"></div>
            </div>

            <?=$pagination?>
        </div>


        <aside class="right-col-section">
            <div class="popular-news">
                <div class="zag"><?= __('Популярное') ?></div>
                <?php foreach(Model_News::get_popular(10)->find_all() as $pop_news):?>
                    <div class="item">
                        <div class="content">
                            <?=$pop_news->date()?> <a href="<?=$pop_news->view_url()?>"><?=Translator::translate($pop_news->title)?> <?=$pop_news->get_type_icon()?></a>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php endforeach;?>
            </div>
        </aside>
        <div class="clear"></div>
    </div>
</main>