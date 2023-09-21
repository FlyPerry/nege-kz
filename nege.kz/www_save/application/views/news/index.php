<?=View::factory("blocks/player")->set("category", $category->id)->render()?>
<main class="main-content">
    <div class="wrap">
        <div class="main-content-section">
            <h1><?=$category->title?></h1>
            <?php $i=0;?>
            <?php  foreach ($collection as $item): ?>
            <?php if($i==0):?>
            <div class="last-news-list middle">
                <div class="item">
                    <div class="image" style="background: url('<?=$item->file_s->html_img_url(360,202)?>') no-repeat center; background-size: cover;"></div>
                    <div class="content">
                        <?=$item->date()?> <a href="<?=$item->view_url()?>" class="news-name"><?=$item->title?><?=$item->get_type_icon()?></a>
                        <p><?=$item->get_annotation(true)?></p>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>

            <div class="last-news-list two-col">
            <?php else:?>
                <div class="item">
                    <div class="image" style="background: url('<?=$item->file_s->html_img_url(360,202)?>') no-repeat center; background-size: cover;"></div>
                    <div class="content">
                        <?=$item->date()?> <a href="<?=$item->view_url()?>" class="news-name"><?=$item->title?><?=$item->get_type_icon()?></a>
                        <p><?=$item->get_annotation(true)?></p>
                    </div>
                </div>
                <?php endif?>
                <?php $i++;?>
            <?php  endforeach ?>
                <div class="clear"></div>
            </div>

            <?=$pagination?>
        </div>


        <aside class="right-col-section">
            <div class="popular-news">
                <div class="zag">Популярное</div>
                <?php foreach(Model_News::get_popular(10)->find_all() as $pop_news):?>
                    <div class="item">
                        <?=$pop_news->file_s->html_img(85, 53, array("class"=>"image"))?>
                        <div class="content">
                            <?=$pop_news->date()?> <a href="<?=$pop_news->view_url()?>"><?=$pop_news->title?> <?=$pop_news->get_type_icon()?></a>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php endforeach;?>
            </div>
        </aside>
        <div class="clear"></div>
    </div>
</main>