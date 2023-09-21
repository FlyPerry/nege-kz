<?php

/**
 * Created by PhpStorm.
 * User: sgm
 * Date: 03.12.15
 * Time: 16:13
 */
class Controller_Admin_Admin extends Admin
{
    public function action_index()
    {
        if($this->request->param('model')){
            return $this->action_list();
        }
        $last_data = Session::instance()->get('last_update');
        if($last_data){
            Session::instance()->set('last_update',null);
        }
        if(!$last_data){
            $last_data = array();
        }
        $revision = array();
        $ret = null;
        exec("cd ".DOCROOT);
        $data = exec("hg head", $revision,$ret );
//        $data = exec("cd ".DOCROOT." && hg head",$revision,$ret);
        $this->page->content(
            View::factory('admin/panel')
                ->set('modules',CMS::modules_info())
                ->set('revision',$revision)
                ->set('update_log',$last_data)
        );

    }
}