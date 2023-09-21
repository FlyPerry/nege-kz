<?=View::factory("blocks/player")->set("category", 0)->render()?>
<section class="main-news">
    <div class="wrap">
        <?php  $main_news = Model_News::get_main_news(); ?>
        <div class="main-news-left-item">
            <div class="news-label"><?= $main_news->category->title ?></div>
            <div class="image"
                 style="background: url('<?= $main_news->file_s->html_img_url(740,409) ?>') no-repeat center; background-size: cover;"></div>
            <a href="<?= $main_news->view_url() ?>"
               class="zag"><?= $main_news->title ?><?= $main_news->get_type_icon() ?></a>
            <?= $main_news->get_annotation(true) ?>
            <ul>
                <?php  $ids = array($main_news->id) ?>
                <?= $key_news = Model_News::get_key_news(2, 0) ?>
                <?php  foreach ($key_news->find_all() as $key_n):
                    $ids[] = $key_n->id;
                    ?>
                    <li><a href="<?= $key_n->view_url() ?>"><?= $key_n->title ?><?= $key_n->get_type_icon() ?></a></li>
                <?php  endforeach; ?>
            </ul>
        </div>
        <div class="main-news-right-items">
            <div class="zag"><?= __('Последние новости') ?></div>
            <div class="last-news">
                <?php $collection = Model_News::get_main_last_news($ids);?>
                <?php  foreach ($collection as $news): ?>
                    <div class="item">
                        <?= $news->date() ?>
                        <a href="<?= $news->view_url() ?>">
                            <?= $news->title ?>
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
            <div class="zag"><?= $item['category'] ?></div>
            <div class="last-news-list">
                <?php  foreach ($item['news'] as $news): ?>
                    <div class="item">
                        <div class="image"
                             style="background: url('<?= $news['img_url'] ?>') no-repeat center; background-size: cover;"></div>
                        <div class="content">
                            <?= $news['date'] ?>
                            <a href="<?= $news['url'] ?>" class="news-name"><?= $news['title'] ?>
                                <?= $news['icon'] ?>
                            </a>
                            <?= $news['description'] ?>
                        </div>
                    </div>
                <?php  endforeach ?>
                <div class="clear"></div>
            </div>
            <?php  $index++ ?>
            <?php  if ($index == 2): ?>
                <div class="index-page-adv right">
                    <a href="#"><img src="/img/subscribe.jpg"></a>
                </div>
            <?php  endif ?>
            <?php  if ($index == 4): ?>
                <?= View::factory('blocks/banners/wide', array('location' => 'mid')) ?>
                <?= Model_News::get_infographic_banner() ?>
            <?php  endif ?>
        <?php  endforeach ?>
    </div>
</section>