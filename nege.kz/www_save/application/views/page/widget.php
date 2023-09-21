<?php
$view = isset($view)?$view:null;
if(!$view){
    return;
}
$sef = isset($sef)?$sef:null;
$id = isset($id)?$id:null;
$model = ORM::factory('Page');
if($id){
    $model->where('sef','=', $id)->find();
}
echo View::factory('page/widget/'.$view)
    ->bind('model', $model)
    ->bind('sef',$sef);
?>