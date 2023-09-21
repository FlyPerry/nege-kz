<?php defined('SYSPATH') or die('No direct script access.');

$module = new Cms_Module();
$module->name='cms_migration';
$module->menu_label='';
$module->model='';
$module->title='Модуль миграций';
$module->has_menu=false;
$module->version='1.0.0';
$module->dependencies=array(
    'cms'=>'1.0'
);

CMS::register_module($module);


$migrations_class   = new Flexiblemigrations();
$migrations_config  = $migrations_class->get_config();

// Enabling the Userguide module from my Module
// Kohana::modules(Kohana::modules() + array('userguide' => MODPATH.'userguide'));

//If web frontend is enabled, set the routes
if ($migrations_config['web_frontend'])
{
  Route::set('migrations_route',$migrations_config['web_frontend_route'])
  	->defaults(array(
  		'controller' => 'flexiblemigrations',
  		'action'     => 'index',
  	));

  Route::set('migrations_new',$migrations_config['web_frontend_route'] . '/new')
    ->defaults(array(
      'controller' => 'flexiblemigrations',
      'action'     => 'new',
    ));

  Route::set('migrations_create',$migrations_config['web_frontend_route'] . '/create')
    ->defaults(array(
      'controller' => 'flexiblemigrations',
      'action'     => 'create',
    ));

  Route::set('migrations_migrate',$migrations_config['web_frontend_route'] . '/migrate')
    ->defaults(array(
      'controller' => 'flexiblemigrations',
      'action'     => 'migrate',
    ));

  Route::set('migrations_rollback',$migrations_config['web_frontend_route'] . '/rollback')
    ->defaults(array(
      'controller' => 'flexiblemigrations',
      'action'     => 'rollback',
    ));
}
