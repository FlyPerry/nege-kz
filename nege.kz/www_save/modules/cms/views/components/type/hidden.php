<?php
$attr = Arr::get($params,'attr', array());
$attr = $attr+array(
    'id'=>$field,
    'class'=>'span8'
);
?>
<?=Form::hidden("model[$field]", $value, $attr)?>
