<?
    $items = array();
    $aspect = Arr::get($params, 'aspect', 0);
    $image_field = Arr::get($params, 'image_field', 'file');
    $relation = "{$image_field}_s";
    $fields = Arr::get($params, 'fields', array());
    $hidden_fields = Arr::get($params, 'hidden_fields', array());

    if ($model->loaded()) {
        $items = $model->{$field}->where($image_field, 'IS NOT', null)->find_all()->as_array();

        $items = array_map(function($item) use ($relation, $fields) {
            $data =  array(
                'id' => $item->{$relation}->id,
                'original_image' => $item->$relation->url(),
                'image' => $item->$relation->cropped_img_url(),
            );
            foreach ($fields as $key => $title) {
                $data[$key] = $item->$key;
            }
            return $data;
        }, $items);
    }

?>


<photo-gallery
    label="<?=htmlentities($label)?>"
    field="model[<?=$field?>]"
    data-fields="<?=htmlentities(json_encode($fields))?>"
    data-hidden-fields="<?=htmlentities(json_encode($hidden_fields))?>"
    size="<?=Arr::get($params, 'size', 100)?>"
    data-items="<?=htmlentities(json_encode($items))?>"
    image-field="<?=$image_field?>"
    aspect="<?=str_replace(',', '.', $aspect)?>"
    >

</photo-gallery>