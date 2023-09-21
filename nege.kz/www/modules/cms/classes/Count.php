<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Ilyassov Timur
 * Date: 22.09.13
 * Time: 14:00
 * To change this template use File | Settings | File Templates.
 */

class Count {

    /** Хелпер склонения множестенного числа
     * @param $count количество
     * @param $single исходное, единственное число
     * @param $second множественное, обычно на а заканчивается
     * @param $third множественное, обычно на ов
     * @return mixed
     */
    public static function word($count,$single,$second,$third){
        if($count!=11 && $count[count($count)-1]==1){
            return $single;
        }else if($count<20 && in_array($count[count($count)-1],array('2','3','4'))){
            return $second;
        }
        return $third;
    }

}