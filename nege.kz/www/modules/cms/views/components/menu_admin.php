<ul class="nav <?=isset($class)?$class:''?>" <?=$first?'id="side-menu"':''?>>
    <?foreach ($items as $item): ?>
    <li <?=Arr::get($item,'active')===true?'class="active"':''?>>
        <a href="<?=Arr::get($item,'url','#')?>"><?=Arr::get($item,'icon')?'<i class="fa '.Arr::get($item,'icon').' fa-fw"></i>':''?> <?=$item['title']?> <?=isset($item['sub'])?'<span class="fa arrow"></span>':''?></a>
        <?=isset($item['sub'])?View::factory('components/menu_admin',array(
            'items'=>$item['sub'],
            'first'=>false,
            'class'=>(isset($class) && $class=='nav-second-level collapse')?'nav-third-level collapse':'nav-second-level collapse'
        )):''?>
    </li>
    <? endforeach;?>
</ul>
