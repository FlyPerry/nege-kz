<main class="main-content">
    <div class="wrap">
        <div class="main-content-section">
            <h1><?=__('Результаты поиска')?></h1>
            <?=__('По запросу “:query” найдено <b>:n материалов</b>', array(':query'=>$query, ':n'=>$hits_count))?>
            <div class="search-block">
                <form method="get" action="<?=URL::site(I18n::$lang.'/search')?>">
                    <input type="text" name="query" value="<?=$query?>"><input type="submit" value="">
                </form>

            </div>
            <ul class="search-result">
                <?php  foreach ($collection as $item):?>
                <li>
                    <img src="<?=$item->file_s->html_img_url(228,128)?>" class="image">
                    <div class="content">
                        <?=Date::textdate($item->date, 'd m')?>
                        <a href="<?=$item->view_url()?>">
                            <?=$item->title?>
                        </a>
                        <span><?=$item->category->title?></span>
                    </div>
                    <div class="clear"></div>
                </li>
                <?php endforeach?>
            </ul>
            <div class="pager">
                <?=$pagination?>
            </div>
        </div>
        <aside class="right-col-section">
            <?php $popular_news = Model_News::get_popular_news()?>
            <?=View::factory('news/popular')->bind('popular_news',$popular_news)->render();?>
        </aside>
        <div class="clear"></div>
    </div>
</main>