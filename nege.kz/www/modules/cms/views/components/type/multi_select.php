<?php
    $size=Arr::get($params,'size',10);
if (!isset($params['value'])){
    $params['value']=$model->$field->find_all()->as_array('id');
}
?>
<div class="control-group <?=$error ? 'error' : ''?>">
    <label for="<?=$field?>" class="control-label"><?=__($label)?></label>

    <div class="controls">
        <input type="hidden" name="<?="model[$field][]"?>" value="0">
        <?=Form::select("model[$field][]",$params['options'],$params['value'],array(
        'id'=>$field,
        'multiple'=>'multiple',
        'size'=>$size,
        'class'=>'span8',
        "".(Arr::get($params,'disabled')?" disabled":'')
    ))?>
        <span class="help-inline"><?=$error?></span>
    </div>
</div>