<ul>
    <?foreach ($items as $item): ?>
    <li <?=$item['active']?'class="active"':''?>><a href="<?=$item['url']?>"><?=$item['title']?></a>
        <?=isset($item['sub_menu'])?View::factory('components/menu_admin',array('items'=>$item['sub_menu'])):''?>
    </li>
    <? endforeach;?>
</ul>