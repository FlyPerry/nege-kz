<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of photo
 *
 * @author Igor Noskov <igor.noskov87@gmail.com>
 */
class Photo
{
    protected static $instance;

    protected function __construct(){}
    protected function __clone(){}

    /**
     * @return Photo
     */
    public static function instance(){
        if (!self::$instance){
            self::$instance=new self();
        }
        return self::$instance;
    }

    public static function crop($file,$left,$top,$w,$h){
        return self::translate2url(self::instance()->_crop($file,$left,$top,$w,$h));
    }

    public static function resize($file,$w=null,$h=null){
        return self::translate2url(self::instance()->_resize($file,$w,$h));
    }

    /**
     * @param SplFileObject $file
     * @param $left
     * @param $top
     * @param $w
     * @param $h
     * @return string
     */
    public function _crop($file,$left,$top,$w,$h){
        $key_part=array('crop','l',$left,'t',$top,'w',$w,'h',$h);
        $path=$this->create_path($file,$key_part);
        if (is_file($path)){
            return $path;
        }
        $img=Image::factory($file->getRealPath());
        $img->crop($w,$h,$left,$top);
        $img->save($path);
        return $path;
    }

    /**
     * @param SplFileObject $file
     * @param null $w
     * @param null $h
     * @return string
     */
    public function _resize($file,$w=null,$h=null){
        $key_part=array('resize','w',$w,'h',$h);
        $path=$this->create_path($file,$key_part);
        if (is_file($path)){
            return $path;
        }
        $img=Image::factory($file->getRealPath());
        $img->resize($w,$h);
        $img->save($path);
        return $path;
    }

    /**
     * Генерирует имя файл
     * @param SplFileObject $file
     * @param $key_part Массив параметров, который будет добавлен к имени файла
     * @return string
     */
    public function create_path($file,$key_part){
        $dir=$file->getPath();
        $ext=$file->getExtension();
        $filename=$file->getBasename(".$ext");
        return $dir.DIRECTORY_SEPARATOR.$filename."_".implode("_",$key_part).".".$ext;
    }

    public static function translate2url($path){
        if (PHP_SAPI == 'cli'){
            return $path;
        }
        $doc_root=Arr::get($_SERVER,'DOCUMENT_ROOT');
        $path=str_replace('\\','/',$path);
        return str_replace($doc_root,'',$path);
    }


}
