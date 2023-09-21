<nav class="top-menu">
    <ul>
        <?php foreach(ORM::factory("Category")->where('on_main', '=', 1)->and_where('parent_id', 'IS', null)->order_by('position', 'DESC')->find_all() as $model):?>
            <li>
                <a href="<?=$model->view_url()?>"><?=Translator::translate($model->title)?></a>
                <?php $subItems = $model->children->where('on_main', '=', 1)->order_by('position', 'DESC')->find_all(); ?>
                <?php if ($subItems->count()): ?>
                    <div class="sub-menu">
                        <?php foreach ($subItems as $subItem): ?>
                            <div class="sub-menu_item">
                                <a href="<?=$subItem->view_url()?>" class="sub-menu_link"><?=Translator::translate($subItem->title)?></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif ?>
            </li>
        <?php endforeach;?>
    </ul>
</nav>
