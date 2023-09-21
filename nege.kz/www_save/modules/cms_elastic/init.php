<?php

$module = new Cms_Module();
$module->name='cms_elastic';
$module->menu_label='Elastic Search';
$module->model='';
$module->title='Ядро CMS';
$module->has_menu=false;
$module->version='0.0.0';
$module->dependencies=array(
    'cms'=>'1.0'
);

//CMS::register_module($module);