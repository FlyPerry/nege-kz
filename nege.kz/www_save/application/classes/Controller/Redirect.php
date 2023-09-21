<?php

/**
 * Created by PhpStorm.
 * User: AxCx
 * Date: 28.09.2015
 * Time: 10:10
 */
class Controller_Redirect extends Site
{
    public function before()
    {
        parent::before();
    }


    public function action_banner()
    {
        $id = $this->request->param('id');

        $banner = ORM::factory('Banner', $id);

        if (!$banner->loaded()) {
            throw new HTTP_Exception_404;
        }

        DB::update('banners')
            ->set(array('conversion' => DB::expr('conversion+1')))
            ->where('id', '=', $id)->execute();

        $this->redirect($banner->URL, 301);
    }
}