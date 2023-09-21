<ul class="breadcrumb">
    <li><a href="<?= $collection->tree_url()?>"><i class="icon-home"></i></a> <span class="divider">/</span></li>
    <?php
        foreach ($ancestors as $m){
            ?>
            <li><a href="<?=$m->tree_url() ?>" title="<?=HTML::chars($m->{$m->tree_title_field()}) ?>"><?=Text::limit_chars(strip_tags($m->{$m->tree_title_field()}),30,'...') ?></a> <span class="divider">/</span></li>
            <?
        }
        if ($tree_model->loaded()){
            echo '<li class="active"><i class="icon-folder-open"></i> '.$tree_model->{$tree_model->tree_title_field()}.'</li>';
        }

    ?>




</ul>
<?if ($tree_model->loaded()):?>
<div class="well">
    <div class="btn-group pull-left">
        <a class="btn dropdown-toggle" data-toggle="dropdown" href="#" title="<?=__('11111Действия')?>">
            <i class="icon-pencil"></i>

            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <?php
            dropdown($tree_model->actions($user));
            ?>
        </ul>
    </div>

    <h4 class="">&nbsp;<?=$tree_model->{$tree_model->tree_title_field()} ?></h4>

</div>
<?endif; ?>
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

echo Form::open(Request::current()->url('http') , array('class' => 'form form-horizontal'));
echo "<div class='btn-group'>";

$cp = Component::factory('components/plain');

if (Authority::can('create',$collection->object_name())) {
    $cp->button_link($collection->edit_url(true).$tree_model->id, "Добавить", array('class' => 'btn btn-success'));
}
if (Authority::can('delete',$collection->object_name())) {
    $cp->form_button_save('delete', "Удалить выделенное", array('class' => 'btn btn-danger'));
}

$ref = new ReflectionClass($collection);
if ($ref->hasMethod('form_list_button')) {
    $collection->form_list_button($cp);
}

echo $cp->render();

echo "</div>";
echo Component::factory()->editable_table($model, $head,'components/editable_table_for_tree');
echo Form::close();
echo $pagination;