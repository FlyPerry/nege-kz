<nav class="top-menu">
    <ul>
        <li><a href="/"><?=__('Басты бет')?></a></li>
        <?php foreach(ORM::factory("Category")->where('on_main', '=', 1)->order_by('position', 'DESC')->find_all() as $model):?>
            <li><a href="<?=$model->view_url()?>"><?=$model->title?></a></li>
        <?php endforeach;?>
    </ul>
</nav>
