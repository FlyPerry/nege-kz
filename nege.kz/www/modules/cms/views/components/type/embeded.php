<?php
//echo "<hr><h3>".__($label)."</h3>";
if (!$model->loaded()) return;
//$cp = Component::factory();
$target = $model->$field;
//    echo $cp->button_link($target->edit_url().'/0/'.$model->id,"Добавить ".$label);
//echo Request::factory($target->list_url(true).'/'.$model->id.Url::query(Request::current()->query()))->execute();
?>
<div class="embeded-edit" data-src="<?=$target->list_url().'/'.$model->id ?>">

</div>

