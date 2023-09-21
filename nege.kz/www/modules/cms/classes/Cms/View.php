<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Класс отображения с поддержкой тем оформления
 */

class Cms_View extends Kohana_View
{
    protected static $theme="default/";

    public static function theme($name=null)
    {
        if ($name) self::$theme=$name+'/';
        else return trim(self::$theme,'/');
    }

    public function set_filename($file)
    {

        try {
            parent::set_filename(self::$theme . $file);
        } catch (Exception $e) {
            parent::set_filename($file);
        }

        return $this;
    }


}
