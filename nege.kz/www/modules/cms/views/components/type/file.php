<?php
$field_s = $model->{$field."_s"};
$url = $field_s->loaded() ? $field_s->url() : '';
?>


<file-uploader
    error="<?=htmlspecialchars($error)?>"
    field="<?=htmlspecialchars("model[{$field}]")?>"
    label="<?=__($label)?>"
    value="<?=$model->$field?>"
    url="<?=$url?>"
    name="<?=htmlspecialchars($field_s->original_name)?>"
></file-uploader>