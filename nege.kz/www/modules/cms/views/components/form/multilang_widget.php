<div class="lang-tabs">
    <ul>
        <li><a href="#<?=$prefix?>ru"><?=__('Русская версия')?>
        </a></li>
        <li><a href="#<?=$prefix?>kz"><?=__('Казахская версия')?>
        </a></li>
        <li><a href="#<?=$prefix?>en"><?=__('Английская версия')?>
        </a></li>
    </ul>

    <div id="<?=$prefix?>ru">
        <?foreach($ru as $v):?>
            <?=$v?>
        <?endforeach;?>
    </div>

    <div id="<?=$prefix?>kz">
        <?foreach($kz as $v):?>
        <?=$v?>
        <?endforeach;?>
    </div>

    <div id="<?=$prefix?>en">
        <?foreach($en as $v):?>
        <?=$v?>
        <?endforeach;?>
    </div>

</div>