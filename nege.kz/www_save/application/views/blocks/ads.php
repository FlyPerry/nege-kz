<?php $ads = Model_Ad::get_main_ads();?>
<section class="index-page-advs">
    <div class="wrap">
        <div class="slider">
            <div class="name">
                <span><?= __('Реклама') ?></span>
            </div>
            <div class="slider4">
                <?php  foreach ($ads as $ad): ?>
                    <div class="slide">
                        <a href="<?= $ad->link ?>">
                            <img src="<?= $ad->file_s->html_img_url(209, 106) ?>"><br/>
                            <?= $ad->title ?>
                        </a>
                    </div>
                <?php  endforeach ?>

            </div>
        </div>
    </div>
</section>