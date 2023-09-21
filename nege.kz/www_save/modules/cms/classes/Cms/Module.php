<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 24.05.13
 * Time: 11:24
 * To change this template use File | Settings | File Templates.
 */

class Cms_Module {
    public $name;
    public $version;
    public $title;
    public $menu_icon;
    public $menu_label;
    public $model;
    public $has_menu=true; //Флаг отображения в меню админки
    public $dependencies=array(); //Зависимости 'module_name'=>'1.*'

    public function list_url($uri=false){
        return ORM::factory($this->model)->list_url($uri);
    }

    public function install(){

    }

    public function check(){
        $module_file=$this->name.".module";
        $path=APPPATH.'cache'.DIRECTORY_SEPARATOR;
        $filename = $path.$module_file;
        $is_ok=true;
        if (!file_exists($filename)){
            file_put_contents($filename,$this->version);
            if ($this->name=='cms'){ //Модуль CMS не установлен, надо создать таблицу
                //TODO:проверить есть ли модуль миграций, и выполнить миграцию
            }
            $is_ok=false;
        }

        $version=file_get_contents($filename);
        if ($version!=$this->version){
            $is_ok=false;
        }
        if (!$is_ok){
            $this->install();
            file_put_contents($filename,$this->version);
        }

        return $is_ok;
    }
}