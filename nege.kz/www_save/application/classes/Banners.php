<?php
/**
 * Created by PhpStorm.
 * User: sgm
 * Date: 25.09.15
 * Time: 16:22
 */

class Banners {

    protected static $_places = array(0,1,2,3,4,5);
    protected static $_banners = array();

    public static function instance($place=null,$limit=1){
        if(array_key_exists($place, self::$_places)){

        }
        return null;
    }

}