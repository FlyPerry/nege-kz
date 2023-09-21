<div class="form-group">
    <?=Form::label($field, $label,array('class'=>'control-label'))?>
    <div class="controls">
        <?=Form::password("model[$field]", $value,array(
        'id'=>$field,
        'class'=>'col-sm-4 col-md-4'
    ))?>
        <div class="err"><?=$error?></div>
    </div>
</div>