<?php

/**
 * Created by PhpStorm.
 * User: Almas
 * Date: 26.02.2016
 * Time: 11:49
 */
class Model_Storage extends Cms_Model_Storage
{

    public function html_img_url($width = null, $height = null, $protocol = null)
    {
        try {
            $file = $this->cropped_file() != false ? $this->cropped_file() : $this->get_file();
            if (!is_file($this->full_path())) {
                return false;
            }

            $url = AppPhoto::translate2url($file->getRealPath());

            if ($width or $height) {
                $url = AppPhoto::resize($file, $width, $height);
            }
            if ($protocol) {
                return URL::site($url, 'http');
            } else {
                return substr($url, 0, 1) == '/' ? $url : "/{$url}";
            }
        } catch (Exception $e) {
            return null;
        }
    }

}