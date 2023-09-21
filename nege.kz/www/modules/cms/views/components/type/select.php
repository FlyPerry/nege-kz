<?php
    if ($params['options'] instanceof ORM){
        $params['options']=array(null=>'Не выбрано')+$params['options']->find_all()->as_array($params['key'],$params['value']);
    }

    $attrs =  array(
        'id' => $field,
        'ng-model' => "model.{$field}",
        'class' => 'form-control',
        'value-init' => 'value-init',
    );

    if (Arr::get($params, 'disabled')) {
        $attrs['disabled'] = 'disabled';
    }

?>

<div class="form-group <?=$error ? 'has-error' : ''?>">
    <label for="<?=$field?>" class="control-label"><?=__($label)?></label>


    <?= Form::select("model[$field]", $params['options'], $value, $attrs) ?>
    <?php if ($error) : ?>
        <span class="help-block" style="display:block;"><?=$error?></span>
    <?php endif ?>

</div>