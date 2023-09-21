<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 20.03.13
 * Time: 16:03
 * To change this template use File | Settings | File Templates.
 */
class Controller_Storage extends Admin
{
    public function before()
    {
        parent::before();
    }

    public function styles()
    {
        return array(
            'bootstrap'=>'js/lib/bootstrap/css/bootstrap.min.css',
//            'style'=>'css/style.css',
//            'slider'=>'css/slider.css'
        );
    }

    public function scripts()
    {
        return array(
                'jquery'=>'js/lib/jquery-1.9.0.min.js',
//                'jquery-ui'=>'js/lib/jquery-ui-1.9.1.custom.min.js',
                'bootstrap'=>'js/lib/bootstrap/js/bootstrap.min.js',
                'angular'=>'js/lib/angular.min.js',
            );
    }


    public function action_index()
    {
        $this->render=false;
        $this->page->script('ng-upload','js/lib/storage/ng-upload.min.js');
        $this->page->script('storage','js/lib/storage/app.js');
        $this->page->content(View::factory('storage'));

        $this->response->body($this->page->content());
    }

    public function action_upload()
    {
        $this->render=false;
        $type=$this->request->param('id');
        $validate=Validation::factory($_FILES);
        if ($type=='Img'){
            $validate->rules('file',array(
                array("Upload::not_empty"),
                array("Upload::valid"),
                array("Upload::type",array(":value",array("png","jpg","gif","jpeg"))),
                array("Upload::size",array(":value","2M"))

            ));
        } else {
            $validate->rules('file',array(
                array("Upload::not_empty"),
                array("Upload::valid"),
                array("Upload::type",array(":value",array('doc', 'docx', 'pdf', 'rar','zip', 'xls', 'xlsx','txt', "png","jpg","gif","jpeg"))),
                array("Upload::size",array(":value","2M"))

            ));
        }
        if ($validate->check())
        {
            if (Arr::get($this->request->post(), 'watermark', false) == 'true'){
                $file=Cms_Storage::instance()->upload($_FILES,'file', array(), true);
            }
            else{
                $file=Cms_Storage::instance()->upload($_FILES,'file');
            };

            if ($file instanceof ORM && $file->loaded()){
                $this->response->body(json_encode(array('err'=>0,'file'=>$file->id,'url'=>$file->url(),'type'=>$file->type)));
                return;
            }
        } else {
            $this->response->body(json_encode(array('err'=>1,'msg'=>Arr::get($validate->errors('storage'),'file',"Не известная ошибка"))));
        }


    }


    public function action_delete()
    {
        $this->render=false;
        $model=Cms_Storage::instance()->model($this->request->post('id'));
        if ($model->loaded())
        {
            $model->delete();
        }
//        $this->request->redirect('storage/index');
    }

    public function action_list()
    {
        $this->render=false;
        $data=array();
        foreach (Cms_Storage::instance()->get_list(null) as $file)
        {
            $data[]=array(
                'id'=>$file->id,
                'name'=>$file->original_name,
                'size'=>$file->size,
                'type'=>$file->type,
                'url'=>$file->url(),
                'created'=>Date::formatted_time($file->created,'d-m-Y H:i:s'),
                'updated'=>Date::formatted_time($file->updated,'d-m-Y H:i:s')
            );
        }
        $this->response->body(json_encode($data));
    }

    public function action_crop()
    {

        $this->render=false;
        if ($this->request->method()!=Request::POST){
            return;
        }
        /** @var Cms_Model_Storage $model */
        $model=Cms_Storage::instance()->model($this->request->param('id'));
        $x=$this->request->post('x');
        $y=$this->request->post('y');
        $w=$this->request->post('w');
        $h=$this->request->post('h');
        $path=Photo::crop($model->get_file(),$x,$y,$w,$h);
        $file=$model->cropped_file();
        if ($file!=false){
            @unlink($file->getRealPath());
        }
        $meta=$model->metadata();
        $meta['crop']=Arr::extract($this->request->post(),array('x','y','w','h'));
        $model->metadata($meta);
        $model->save();
        $this->response->body($path);
    }

    public function action_media_img() {
        $path = $this->request->param('path');
        $file_name = $this->request->param('file');
        $ext = $this->request->param('format');

        $path = 'js/lib/'.$path.DIRECTORY_SEPARATOR.$file_name.'.'.$ext;
        if(!file_exists(DOCROOT.$path)) {
            $copy_path = $this->page->find_content($path);
            $this->response->send_file($copy_path);
        }
        else {
            $this->response->send_file(DOCROOT.$path);
        }
    }


    public function action_load_image_from() {
        $this->render = false;
        $url = $this->request->post('url');
        $watermark = $this->request->post('watermark');
        $response = array();
        try {
            $image = Cms_Storage::instance()->load_image_from_url($url, $watermark == 'true');
            $response['type'] = $image->type;
            $response['url'] = $image->url();
            $response['file'] = $image->id;
        }
        catch (Exception $e) {
            $response['error'] = 'Ошибка при загрузке файла ('.$e->getMessage().')';
        }
        $this->response->body(json_encode($response));
    }
}