<?
/**
 * Генерация страницы списка моделей
 * @var $collection ORM
 * @var $fields array()
 * @var $pagination Pagination
 * @var $request Request
 * @var $model ORM
 */
?>
<div class="row well">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                <h3><?=$collection->list_title()?></h3>
    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <?if(!($collection instanceof IC_Translatable) && count($collection::$_model_langs)):?>
        <div class="btn-group btn-group-justified btn-group-raised">
            <?foreach($collection::$_model_langs as $i=>$lang):?>
                <?
                    $route = Request::$current->route();
                    $route_name = Route::name($route);
                    $defaults = $route->defaults();
                    $current_params = Request::$current->param();
                    $params = array_merge($defaults,$current_params,array('lang'=>$i,'controller'=>Request::$current->controller(),'action'=>Request::$current->action()));
                ?>
                <a href="<?=Route::url($route_name,$params)?>" class="btn <?=Request::$current->param('lang')==$i?'btn-primary btn-raised':''?>"><?=$lang?></a>
            <?endforeach?>
        </div>
        <?endif?>

    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
        <?
        $cp = Component::factory('components/form_search');


        $search_fields = $collection->search_form();

        $need_search = Arr::get($search_fields,'search',false);
        $flags = Arr::get($search_fields,'flags');
        foreach ($flags as $field => $info) {
            if(is_int($field)){
                $field = $info;
            }
            $field_info = Arr::get($fields,$field);
            if(is_array($info)){
                $range = Arr::get($info,'range');
            }else{
                $range = false;
            }
            $type = Arr::get($field_info,'type');
            $params = Arr::get($field_info,'params');
            if($params && isset($params['widget'])){
                unset($params['widget']);
            }
            $query_field = $field;
            if (strpos($field, '.')) {
                $query_field = preg_replace('/[.]/', '_', $field);
            }
            if($range){
                $call = "search_".$type."_range";
            }else{
                $call = "search_".$type;
            }
            $cp->$call(Arr::get($field_info,'label'), $collection, $field, $params, $request->query($query_field));
        }
        $cp->form_button_save(null, 'Найти',array('class'=>'btn btn-primary btn-raised'));
        $cp->button_link(Request::current()->uri(), 'Сбросить');
        //$cp->form_button_reset('cancel');
        if($need_search){
            $cp->bind('search',true);
            echo $cp->render();
        }
        ?>

    </div>
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
    <?
    if (Authority::can('create',$collection->object_name(),$user)) {
        echo $cp->button_link($collection->edit_url(true), "Создать ".strtolower($collection->edit_title()), array('class' => 'btn btn-success btn-raised'));
    }
    ?>

    </div>

</div>
<?php




$head = array();
foreach ($fields as $field => $info) {
    if (Arr::get($info, "head")) {
        $head[$field] = $info['label'];
    }
}

echo Form::open(Request::current()->url('http') , array('class' => 'form form-horizontal'));
echo "<div class='btn-group'>";

$cp = Component::factory('components/plain');



$ref = new ReflectionClass($collection);
if ($ref->hasMethod('form_list_button')) {
    $collection->form_list_button($cp);
}

echo $cp->render();

echo "</div>";
echo Component::factory()->editable_table($model, $head);
echo Form::close();
echo $pagination;
