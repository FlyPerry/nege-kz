<?php defined('SYSPATH') OR die('No direct script access.');

class HTTP_Exception extends Kohana_HTTP_Exception {

    protected $page;
    protected $template = 'template';
    protected $last_uri;

    protected function prepare_response($view){

        $user = Auth::instance()->get_user();
        $this->template=View::factory($this->template);

        $this->page=new Cms_Page();

        foreach($this->scripts() as $name=>$path){
            $this->page->script($name,$path);
        }

        foreach($this->styles() as $name=>$path){
            $this->page->style($name,$path);
        }

        $this->page->content($view);
        View::bind_global('page',$this->page);
        View::bind_global('user',$user);

        $response = Response::factory()
            ->status($this->code)
            ->body($this->template->render());

        return $response;
    }

    public function scripts()
    {
        return array(
            'jquery'=>'js/lib/jquery-1.9.0.min.js',
            'bootstrap'=>'js/lib/bootstrap/js/bootstrap.min.js',
            'main'=>'js/admin.js',
        );
    }
//
    public function styles()
    {
        return array(
//            'jquery-ui'=>'js/lib/jquery-ui-1.9.1.custom/css/smoothness/jquery-ui-1.9.1.custom.min.css',
//            'bootstrap'=>'js/lib/bootstrap/css/bootstrap.min.css',
             'responsive'=>'js/lib/bootstrap/css/bootstrap-responsive.min.css',
//            'redactor'=>'js/lib/redactor/redactor.css',
            'main'=>'css/admin.css',
        );
    }
}