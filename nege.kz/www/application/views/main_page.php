<?=View::factory("blocks/player")->set("category", 0)->render()?>

<div class="wrap">
 <?= View::factory('blocks/banners/wide', array('location' => 'head')) ?></div>
<section class="main-news">
    <div class="wrap" style="background:white; padding:15px;">
        <?php  $main_news = Model_News::get_main_news(); ?>
        <div class="main-news-left-item">
            <div class="main-slider">
                <?php foreach ($main_news as $item): ?>
                <div class="main-slider_item">
                    <div class="news-label"><?= Translator::translate($item->category->title) ?></div>
                    <div class="image"
                         style="background: url('<?= $item->file_s->html_img_url(740,409) ?>') no-repeat center; background-size: cover;"></div>
                    <a href="<?= $item->view_url() ?>"
                       class="zag"><?= Translator::translate($item->title) ?><?= $item->get_type_icon() ?></a>
                    <?= Translator::translate($item->get_annotation(true)) ?>
                </div>
                <?php endforeach; ?>
            </div>
            <br>
            <ul>
                <?php  $ids = array_map(function($item) {return $item->id;}, $main_news->as_array()) ?>
                <?= $key_news = Model_News::get_key_news(2, 0) ?>
                <?php  foreach ($key_news->find_all() as $key_n):
                    $ids[] = $key_n->id;
                    ?>
                    <li><a href="<?= $key_n->view_url() ?>"><?= Translator::translate($key_n->title) ?><?= $key_n->get_type_icon() ?></a></li>
                <?php  endforeach; ?>
            </ul>
        </div>
        <div class="main-news-right-items">
            <div class="zag"><?= __('Последние новости') ?></div>
            <div class="last-news">
                <?php $collection = Model_News::get_main_last_news($ids);?>
                <?php  foreach ($collection as $news): ?>
                    <div class="item">
                        <?= $news->format_date() ?>
                        <a href="<?= $news->view_url() ?>">
                            <?= Translator::translate($news->title) ?>
                            <?= ' ' . $news->get_type_icon() ?>
                        </a>
                    </div>
                <?php  endforeach; ?>

            </div>
        </div>
        <div class="clear"></div>
    </div>
</section>

<?= View::factory('blocks/banners/wide', array('location' => 'under_main')) ?>

<section class="categories-news">
    <div class="wrap">
        <?php  foreach ($data as $item): ?>
            <a class="zag" href="<?=$item['view_url'] ?>"><?= Translator::translate($item['category']) ?></a>
            <div class="last-news-list">
                <?php  foreach ($item['news'] as $news): ?>
                    <a href="<?= $news['url'] ?>" class="item">
                        <div class="image" style="background: url('<?= $news['img_url'] ?>') no-repeat center; background-size: cover;"></div>
                        <div class="content">
                            <?= $news['date'] ?>
                            <span class="news-name"><?= Translator::translate($news['title']) ?>
                                <?= $news['icon'] ?>
                            </span>
                            <?= Translator::translate($news['description']) ?>
                        </div>
                    </a>
                <?php  endforeach ?>
                <div class="clear"></div>
            </div>
            <?php  $index++ ?>
        <?php  endforeach ?>
    </div>
</section>
<style>

