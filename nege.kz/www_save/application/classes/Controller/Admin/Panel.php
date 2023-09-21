<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 24.05.13
 * Time: 10:34
 * To change this template use File | Settings | File Templates.
 */

class Controller_Admin_Panel extends Admin{

    protected function init_authority() {
        parent::init_authority();
    }

    public function action_index()
    {
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

    public function action_update_code(){
        $revision = array();
            exec("cd ".DOCROOT);
            exec("/usr/bin/hg pull && /usr/bin/hg up", $revision );
            exec("php index.php db:migrate", $revision);
        Session::instance()->set('last_update',$revision);
            $this->redirect("admin/panel");

    }

    public function action_delimg()
    {
        $this->render = false;
        $model = ORM::factory("Storage",$this->request->param('id'));
        $model->loaded() && $model->delete();
    }

    public function action_file_upload()
    {
//        $file = Arr::get($_FILES, 'file');
        $valid = Validation::factory($_FILES);
        $valid->rules('file', array(
            array('Upload::not_empty', array(':value')),
            array('Upload::valid', array(':value')),
            array('Upload::size', array(':value', '50M')),
            array('Upload::type', array(':value', array('jpg', 'jpeg', 'png', 'gif', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'ppt', 'pptx', 'rar', 'zip', '7z', 'odt', 'ods', 'odp','pdf'))),
        ))->label('file', 'Файл');
        $this->upload($valid,$_FILES,'file',$tags=array());
    }

    public function action_image_upload()
    {
//        $file = Arr::get($_FILES, 'file');
        $valid = Validation::factory($_FILES);
        $valid->rules('file', array(
            array('Upload::not_empty', array(':value')),
            array('Upload::valid', array(':value')),
            array('Upload::size', array(':value', '50M')),
            array('Upload::type', array(':value', array('jpg', 'jpeg', 'png', 'gif'))),
        ))->label('file', 'Файл');

        $this->upload($valid,$_FILES,'file',$tags=array(), true);
    }

    public function upload($valid, $files,$field,$tags=array(), $is_image = false)
    {
        set_time_limit(0);
        $this->render = false;
        $array = array(//            'filelink' => false
        );
        if ($valid->check()) {
            /** @var Model_Storage $s */
            $s = Cms_Storage::instance()->upload($files,$field,$tags, $is_image);
            $array = array(
                'filename' => Helper::translit($s->original_name),
                'filelink' => $s->url(),
            );
        } else {
            $array = array(
//                'filelink' =>'#',
                'filename' => Arr::get($valid->errors('validation'), 'file')

            );
            echo json_encode($array);
            return;
        }

        $array['filelink'] = preg_replace('#\\\#','/',$array['filelink']);
        echo stripslashes(json_encode($array));
    }
}