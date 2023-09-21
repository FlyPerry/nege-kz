
<?php
$langs = array(
    'ru'=>'Рус',
    'kz'=>'Қаз',
    'kk'=>'Qaz',
    'en'=>'Eng'
);
?>
<div id="second" class="menu-content">
    <ul>
        <li class="menu lang-select">
            <ul>
                <li class="button"><a href="#"><?=Arr::get($langs,I18n::$lang)?></a></li>
                <li class="dropdown">
                    <ul>
        <?php foreach($langs as $lang_key=>$lang_val):
            if ($lang_key != I18n::$lang){
                ?>
                <li><a href="/<?=$lang_key?>"><?=$lang_val?></a></li>
                <?php
            };
        endforeach;?>
                    </ul>
                </li>
            </ul>
        </li>
        <?php foreach($model->children->order_by('position','DESC')->find_all() as $row):?>


                    <?php if($row->children->count_all() > 0):?>
                <li class="menu">
                    <ul>
                        <li class="button"><a href="#"><?=$row->title?></a></li>
                        <li class="dropdown">
                            <ul>
                                <?php foreach($row->children->order_by('position','DESC')->find_all() as $subrow):?>
                                    <li><a href="<?=$subrow->view_url()?>" ><?=$subrow->title?></a></li>
                                <?php endforeach?>
                            </ul>
                        </li>
                    </ul>
                </li>
                    <?php else:
                        if($row->view_url() != '/faq' || ($row->view_url() == '/faq' && I18n::$lang !='en')):?>
                           <li><a href="<?= 1||in_array($row->view_url(), array('/archive', '/media', '/persons', '/news/tv', 'faq' )) ? '/' . I18n::$lang . $row->view_url() : $row->view_url(strpos($row->view_url(), '?') !== false) ?>"><?= $row->title ?></a></li>
                        <?php endif;?>
                    <?php endif;?>


        <?php endforeach?>
        <li class="menu">
            <ul>
                <li class="button"><a href="#"><?=__('Спецпроекты')?></a></li>
                <li class="dropdown">
                    <?php
                    $spec_main = ORM::factory('Category')
                        ->where('id', '=', 232)->find();
                    ?>
                    <ul>
                        <?php foreach($spec_main->children->find_all() as $spec):
                            ?>
                            <li><a href="/<?=I18n::$lang?>/news/<?=$spec->sef?>"><?=$spec->title?></a></li>
                            <?php
                        endforeach;?>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</div>
