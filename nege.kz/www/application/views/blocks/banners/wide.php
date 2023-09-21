<?php
    $locations = array(
        'mid' => 1,
        'head' => 2,
        'under_main' => 3
    );

    $banner = Model_Banner::get_banner($locations[$location]);

    $detect = new Mobile_Detect();
    $is_mobile = $detect->isMobile();
?>
<?php if ($banner->loaded()) : ?>
    <div class="index-page-adv --header">
        <a href="<?=$banner->view_url()?>" <?=$banner->target_blank == 1 ? 'target="_blank"' : ''?>>
            <?php if ($banner->file_s->type == 'swf') : ?>
                <object data="<?=$banner->file_url($is_mobile)?>" type="application/x-shockwave-flash" height="110" width="1200"></object>
            <?php else: ?>
<!--                <img src="--><?php //=$banner->file_s->html_img_url(1200)?><!--" alt="">-->
                <img src="<?=$banner->file_url($is_mobile)?>" alt="<?=$banner->title?>">
            <?php endif ?>
        </a>
    </div>
<?php endif ?>