<div class="control-group <?=$error ? 'error' : ''?>">
    <?=Form::label($field, $label, array('class' => 'control-label'))?>
    <?php
    $attr = Arr::get($params, 'attr', array());
    $attr = array_merge($attr, array(
        'id' => $field,
        'class' => 'span8'
    ));
    ?>
    <div class="controls">
        <div class="accordion" id="<?=$field?>">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#<?=$field?>"
                       href="#collapse<?=$field?>">
                        <?=__('Нажмите чтобы раскрыть')?>

                    </a>
                </div>
                <div id="collapse<?=$field?>" class="accordion-body collapse out">
                    <div class="accordion-inner">
                        <?=$params['value']?>
                    </div>
                </div>
            </div>
        </div>

        <span class="help-inline"><?=$error?></span>
    </div>
</div>