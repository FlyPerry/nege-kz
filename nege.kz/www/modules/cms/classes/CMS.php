<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 24.05.13
 * Time: 11:26
 * To change this template use File | Settings | File Templates.
 */

class CMS {
    protected static $modules=array();
    protected static $migrate=false;
    public static function register_module(Cms_Module $module){
        self::$modules[$module->name]=$module;
        if (!self::$migrate && !$module->check()){
            self::$migrate=true;
        };
        Event::instance()->dispatch('cms.module.registred',$module);
    }

    public static function admin_menu(){
        $menu=array();
        $sort=array();
        /** @var Cms_Module $module */
        foreach (self::$modules as $module) {
            list($is_ok)=self::check_dependencies($module);
            if (!$module->has_menu || !$is_ok) continue;
            $menu[$module->model]=array(
                'title'=>$module->menu_label,
                'url'=>$module->list_url(),
                'active'=>false,
                'icon'=>$module->menu_icon
            );
            $sort[]=$module->menu_label;
        }

        array_multisort($menu,$sort);

        return $menu;

    }

    public static function init(){
        $mr=opendir(MODPATH);
        $modules=array();
        while($dir=readdir($mr)){
            if (preg_match('/^cms_/i',$dir)){
                $modules[$dir]=MODPATH.$dir;
            }
        }

        Kohana::modules(
            Kohana::modules()+$modules
        );

        CMS::migrate();
    }

    public static function module_info($name){
        /** @var Cms_Module $module */
        $module=self::$modules[$name];
        $info=array();
        $info['title']=$module->title;
        $info['version']=$module->version;
        $info['dependencies']=$module->dependencies;
        $info['errors']=self::check_dependencies($module);
        return $info;

    }

    public static function modules_info(){
        $modules=self::modules();
        $info=array();
        foreach($modules as $name=>$module){
            $info[]=self::module_info($name);
        }
        return $info;
    }

    public static function modules(){
        return self::$modules;
    }

    public static function check_dependencies(Cms_Module $module){
        $result=true;
        $errors=array();
        foreach ($module->dependencies as $dep=>$version){
            /** @var Cms_Module $dep_m */
            $dep_m=Arr::get(self::$modules,$dep);
            if ($dep_m){
                if (!self::version_comparator($dep_m->version,$version)){
                    $errors[]=array(
                        'module'=>$dep_m->title,
                        'version'=>$version,
                        'found'=>$dep_m->version
                    );
                    $result=false;
                }
            } else {
                $errors[]=array(
                    'module'=>$dep,
                    'need'=>$version,
                    'found'=>null,
                );
                $result=false;
            }
        }
        return array($result,$errors);
    }

    public static function version_comparator($need,$version){
        $need_a=explode('.',$need);
        $version_a=explode('.',$version);
        $result=true;
        foreach ($version_a as $k=>$v){
            if ($v=='*') continue;
            $v1=Arr::get($need_a,$k);
            if ($v1!=$v){
                $result=false;
                break;
            }
        }
        return $result;
    }

    public static function migrate(){
        if (self::$migrate){
//            Cms_Migrator::migrate();
        }
    }


}