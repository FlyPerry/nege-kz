<?$list = ORM::factory($model)?>
<?foreach($list->menu($filter) as $slug=>$title):?>
<li><a href="<?=URL::site($route.'/'.$slug.URL::query($_GET))?>" <?=(isset($active) && $active==$slug)?'class="active"':null?>><?=$title?></a></li>
<?endforeach?>