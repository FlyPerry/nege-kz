<?php

//TODO: Регистрация модуля в CMS
$module=new Cms_Module();
$module->name='cms_pages';
$module->menu_label='Статичные страницы';
$module->model='Page';
$module->title='Модуль статичных страниц';
$module->version='1.0.3';
$module->dependencies=array(
    'cms'=>'1.*'
);
CMS::register_module($module);