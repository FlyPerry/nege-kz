<?php

$cp = Component::factory('components/form_search');

$need_search = false;
foreach ($fields as $field => $info) {
    if (Arr::get($info, 'search')) {
        $need_search = true;
        $query_field = $field;
        if (strpos($field, '.')) {
            $query_field = preg_replace('/[.]/', '_', $field);
        }
        $call = "search_".$info['type'];
        if (isset($info['params']) && isset($info['params']['widget'])) unset($info['params']['widget']);
        $cp->$call($info['label'], $collection, $field, Arr::get($info, 'params'), $request->query($query_field));
    }
}
$cp->form_button_save('search', 'Найти');
$cp->button_link(Request::current()->uri(), 'Сбросить');
//$cp->form_button_reset('cancel');
if($need_search){
    echo $cp->render();
}


$head = array();
foreach ($fields as $field => $info) {
    if (Arr::get($info, "head")) {
        $head[$field] = $info['label'];
    }
}


echo Component::factory()->editable_table($model, $head,'components/selectable_table');
echo $pagination;
