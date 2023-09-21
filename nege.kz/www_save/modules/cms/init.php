<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Инициализация модуля CMS
 *
 */

$behavior=Kohana::$config->load('cms.behavior');

if ($behavior=='bootstrap'){
    return;
}

/**
 * Определяем в какой среде находимся
 */
Helper::detect_environment();

$env_vars=Kohana::$config->load('cms.environment');
$env_vars=Arr::get($env_vars,Kohana::$environment);

/**
 * Kohana::init() можно выполнить только один раз, поэтому вносим изменения на прямую в переменные ядра
 * Это необходимо т.к. хелпер опредил среду только что, поэтому мы только тут узнали какие значения нам нужны
 * это сделано чтобы не менять дефолтный бутстрап, а управлять всем из модуля.
 */
Kohana::$index_file=Arr::get($env_vars,'index_file','');
Kohana::$base_url=Arr::get($env_vars,'base_url','/');
Kohana::$errors=Arr::get($env_vars,'errors',true);

/**
 * Берм список модулей из конфига CMS
 */
$modules=Kohana::$config->load('cms.modules');
Kohana::modules(
    array('cms'=>MODPATH.'cms')+$modules
);

$module = new Cms_Module();
$module->name='cms';
$module->menu_label='';
$module->menu_icon='';
$module->model='';
$module->title='Ядро CMS';
$module->has_menu=false;
$module->version='1.0.3';
$module->dependencies=array(
    'cms_migration'=>'1.0'
);

CMS::register_module($module);



CMS::init();

require Kohana::find_file('vendors/swiftmailer', 'lib/swift_required');

/**
 * Роут для перехвата изображений хранящихся в media
 * файлы с расширением jpg и png
 */

Route::set('media_images', 'js/lib/(<path>/)<file>(.<format>)', array('path' => '.*', 'format' => 'png$|jpg$'))
    ->defaults(
    array(
        'controller' => "storage",
        'action' => 'media_img',
    )
);

Route::set('storage', 'storage(/<action>(/<id>(/<id2>)))')
    ->defaults(array(
        'lang' => I18n::$lang,
        'controller' => 'storage',
        'action'     => 'index',
    ));

/**
 * Админка
 */
Route::set("admin", "controlpanel(/<model>(/<lang>)(/<action>(/<id>(/<id2>(/<id3>)))))",array('lang'=>'(ru|en|kz|kk|la)'))
    ->filter(function($route, $params, $request){
        if($controller = ucfirst(Arr::get($params,'model'))){
            if(Kohana::find_file('classes/Controller/Admin',$controller)){
                $params['controller']=$controller;
            }
        }
        return $params;
    })
    ->defaults(
    array(
        'controller' => "admin",
        'directory' => 'admin',
        'action' => 'index',
        'id'=>'',
        'id2'=>'',
        'id3'=>'',
        'lang'=>''
    )
);