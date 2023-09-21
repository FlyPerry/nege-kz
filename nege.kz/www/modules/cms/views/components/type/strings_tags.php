<div class="control-group <?=$error ? 'error' : ''?>">
    <?=Form::label($field, __($label),array('class'=>'control-label'))?>
    <?php
        $attr = Arr::get($params,'attr', array());
        $attr = array_merge($attr, array(
            'id'=>$field,
            'class'=>'span8'
        ));

    ?>
    <div class="controls">
        <?=Form::input("model[$field]", trim(($value)?$value: (isset($_POST["model"][$field])?$_POST["model"][$field]:null),','), $attr)?>
        <span class="help-inline"><?=$error?></span>
    </div>
</div>