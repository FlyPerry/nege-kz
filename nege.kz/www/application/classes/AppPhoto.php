<?php

/**
 * Created by PhpStorm.
 * User: Almas
 * Date: 26.02.2016
 * Time: 11:47
 */
class AppPhoto extends Photo
{

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function translate2url($path)
    {
        $doc_root = DOCROOT;
        $path = str_replace($doc_root, '', $path);
        $doc_root = str_replace('\\', '/', $doc_root);
        $path = str_replace('\\', '/', $path);
        $path = str_replace($doc_root, '', $path);
        return $path;
    }

    public static function resize($file, $w = null, $h = null)
    {
        return self::translate2url(self::instance()->_resize($file, $w, $h));
    }

    /**
     * @param SplFileObject $file
     * @param null $w
     * @param null $h
     * @return string
     */
    public function _resize($file, $w = null, $h = null)
    {
        $key_part = array('resize', 'w', $w, 'h', $h);
        $path = $this->create_path($file, $key_part);
        if (is_file($path)) {
            return $path;
        }
        $img = Image::factory($file->getRealPath());
        $img->resize($w, $h);
        $img->save($path);
        return $path;
    }

}