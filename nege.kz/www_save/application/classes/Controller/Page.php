<?php

/**
 * Created by JetBrains PhpStorm.
 * User: sgm
 * Date: 11.09.13
 * Time: 11:32
 * To change this template use File | Settings | File Templates.
 */
class Controller_Page extends Site
{

    public function action_view()
    {
        $sef = $this->request->param('id');
        $model = ORM::factory('Page', array('sef' => $sef));
        if (!$sef || !$model->loaded()) {
            throw new HTTP_Exception_404;
        }
        $popular_news = Model_News::get_popular_news();

        $this->page->title($model->title);
        $this->page->meta($model->title, 'og:title');
        $this->page->meta(URL::site($model->file_s->html_img_url(1200, 630), 'http'), 'og:image');
        $this->page->meta($model->description, 'og:description');
        $this->page->content(View::factory('page/view')
            ->bind('model', $model)
            ->bind('popular_news', $popular_news)
        );

    }


    public function action_widget()
    {
        $this->render = false;
        $view = $this->request->param('id');
        $sef = $this->request->query('sef');
        $model = ORM::factory('Page');
        if ($this->request->param('id2')) {
            $model->where('sef', '=', $this->request->param('id2'))->find();
        }
//        else{
//             $model->where('parent_id','IS',null);
//        }
//        if($view=='menu'){
//            $model->where('link','!=','');
//        }
        $this->response->body(View::factory('page/widget/' . $view)
            ->bind('model', $model)
            ->bind('sef', $sef));
    }

}