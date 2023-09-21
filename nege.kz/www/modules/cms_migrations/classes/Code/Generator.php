<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 05.07.13
 * Time: 15:46
 * To change this template use File | Settings | File Templates.
 */

class Code_Generator {

    public function compile_call_array($callables){
        $code='';
        foreach($callables as $callable){
            $code.=$this->compile_call($callable)."\n";
        }
        return $code;
    }

    public function compile_call($callable){
        if (count($callable)==1){
            $func=array_pop($callable);
            $args=array();
        } else {
            list($func,$args)=$callable;
        }
        $code='';
        if (is_string($func)){
            $code=$func.'(';
        } elseif(is_array($func)){
            list($inst,$method)=$func;
            if(class_exists($inst)){
                $code.=$inst.'::'.$method.'(';
            } else {
                $code.=$inst.'->'.$method.'(';
            }
        }
        $code.=$this->compile_params($args).');';
        return $code;
    }

    public function compile_params($params){
        $code='';
        foreach($params as $param){
            $code.=$this->valueToStr($param).',';
        }
        $code=rtrim($code,',');
        return $code;
    }

    public function quote($str,$q='"'){
        return $q.$str.$q;
    }

    public function compile_array($array){
        $code="array(";
        if (Arr::is_assoc($array)){
            foreach($array as $key=>$value){
                $key=$this->valueToStr($key);
                $value=$this->valueToStr($value);
                $code.=$key.'=>'.$value.',';
            }
        } else {
            foreach($array as $value){
                $value=$this->valueToStr($value);
                $code.=$value.',';
            }
        }
        $code=rtrim($code,',').')';
        return $code;
    }

    public function valueToStr($value){
        if (is_string($value))
            $value=$this->quote($value);
        elseif (is_bool($value))
            $value=$value?'TRUE':'FALSE';
        elseif(is_array($value))
            $value=$this->compile_array($value);
        return $value;
    }


}