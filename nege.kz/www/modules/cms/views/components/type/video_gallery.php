<?
    $image_field = Arr::get($params, 'video_field', 'video');
    $relation = "{$image_field}";
    $fields = Arr::get($params, 'fields', array());
    $hidden_fields = Arr::get($params, 'hidden_fields', array());
    $items = $model->$field->where($image_field, 'IS NOT', null)->find_all()->as_array();
    $items = array_map(function($item) use ($relation, $fields) {
        $data =  array(
            'video' => $item->{$relation},
        );
        foreach ($fields as $key => $title) {
            $data[$key] = $item->$key;
        }
        return $data;
    }, $items);
?>


<video-gallery
    label="<?=htmlentities($label)?>"
    field="model[<?=$field?>]"
    data-fields="<?=htmlentities(json_encode($fields))?>"
    data-hidden-fields="<?=htmlentities(json_encode($hidden_fields))?>"
    size="<?=Arr::get($params, 'size', 100)?>"
    data-items="<?=htmlentities(json_encode($items))?>"
    image-field="<?=$image_field?>"
    >

</video-gallery>