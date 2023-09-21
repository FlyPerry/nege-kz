<div class="control-group <?=$error ? 'error' : ''?>">
    <label for="<?=$field?>" class="control-label"><?=__($label)?></label>

    <div class="controls">
        <ul>
            <?foreach(Arr::get($params,'options') as $item):?>
            <li>
                <?=__('Дата')?>:<?=$item->created?> <?=__('Пользователь')?>:<?=$item->user->firstname.' '.$item->user->lastname?>
        </li>
            <?endforeach?>
        </ul>
        <span class="help-inline"><?=$error?></span>
    </div>
</div>