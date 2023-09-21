<div class="totop"><a href="#top"><img alt="<?=__('Наверх')?>" src="/img/up.png"></a></div>
<div id="top"></div>

<?php
$langs = array(
    'ru'=>'Рус',
    'kz'=>'Қаз',
    'kk'=>'Qaz',
    'en'=>'Eng'
);
?>
<section class="top-line">
    <div class="wrap">
        <div class="top-line-selects">
            <ul class="drop-menu-main">
                <li>
                    <span class="drop-down"><a href="#" class="open-link"><?=$langs[I18n::$lang]?></a></span>
                    <ul class="drop-menu-main-sub">
                        <?php foreach($langs as $lang_key=>$lang_val):
                            if ($lang_key != I18n::$lang){
                                ?>
                                <li><a href="/<?=$lang_key?>"><?=$lang_val?></a></li>
                            <?php
                            };
                        endforeach;?>
                    </ul>
                </li>

                <li>
                    <?php
                    $spec_main = ORM::factory('Category')
                        ->where('id', '=', 232)->find();
                    ?>
                    <span class="drop-down"><a href="#" class="open-link"><?=$spec_main->title?></a></span>
                    <ul class="drop-menu-main-sub">
                        <?php foreach($spec_main->children->find_all() as $spec):
                                ?>
                                <li><a href="/<?=I18n::$lang?>/news/<?=$spec->sef?>"><?=$spec->title?></a></li>
                            <?php
                        endforeach;?>
                    </ul>
                </li>

                <?php foreach($model->children->order_by('position','DESC')->find_all() as $row):?>
                    <li>
					<span class="drop-down">
                    <?php if($row->children->count_all() > 0):?>
                        <a href="#" class="open-link"><?=$row->title?></a>
                    <?php else:
                        if($row->view_url() != '/faq' || ($row->view_url() == '/faq' && I18n::$lang !='en')):?>
                        <a href="<?= 1||in_array($row->view_url(), array('/archive', '/media', '/persons', '/news/tv', 'faq' )) ? '/' . I18n::$lang . $row->view_url() : $row->view_url(strpos($row->view_url(), '?') !== false) ?>"><?= $row->title ?></a>
                        <?php endif;?>
                    <?php endif;?>
					</span>
                        <ul class="drop-menu-main-sub">
                        <?php foreach($row->children->order_by('position','DESC')->find_all() as $subrow):?>
                                <li><a href="<?=$subrow->view_url()?>" ><?=$subrow->title?></a></li>
                        <?php endforeach?>
                        </ul>
                    </li>
                <?php endforeach?>
            </ul>
        </div>
		<!--
        <div class="mobile-links">
            <a href="#"><img src="/img/android.png"> Android</a>
            <a href="#"><img src="/img/ios.png"> iOS</a>
        </div>
		-->
        <div class="clear"></div>
    </div>
</section>
