<?php
$field_s = $model->{$field."_s"};
$size = isset($params) ? Arr::get($params, 'size', 100) : 100;
$aspect = Arr::get($params, 'aspect', 0)
?>

<image-uploader
    image="<?=$field_s->html_img_url($size)?>"
    original-image="<?=$field_s->loaded() ? $field_s->url('http') : ''?>"
    image-id="<?=$field_s->id?>"
    field="<?="model[{$field}]"?>"
    aspect="<?=str_replace(',', '.', $aspect)?>"
    size="<?=$size?>"
    label="<?=htmlentities($label)?>"
    error="<?=htmlentities($error)?>"
    >
</image-uploader>