<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_News extends Site
{

    public $sef = null;
    public $id = null;
    public $date = null;
    public $special = null;
    public $region = null;


    public function before()
    {
        parent::before();
    }

    public function action_index()
    {
        $cat = $this->request->param('cat');
        $page = $this->request->param('page');
        $category = ORM::factory('Category', array('sef' => $cat));
        if (!$category->loaded()) {
            throw new HTTP_Exception_404;
        }
        $model = $category->news
            ->where('lang','=',I18n::$lang)
            ->where('status', '=', 1)
            ->where('date', '<=', date('Y-m-d H:i:s'))
            ->order_by('date', 'DESC');
        $pagination = $this->pagination($model, 'pagination.news');
        $collection = $model->find_all();
        $total_pages = $pagination->total_pages;
        $this->check_pages($page, $total_pages);
        $this->page->title($category->title);
        $this->page->meta($category->title, 'og:title');
        $view = View::factory('news/index')
            ->bind('pagination', $pagination)
            ->bind('collection', $collection)
            ->bind('category', $category);
        $this->page->content($view);
    }

    public function action_view()
    {
        $sef = $this->request->param('sef');
        $model = ORM::factory('News', array('sef' => $sef));
        if (!$model->loaded()) {
            throw new HTTP_Exception_404;
        }
        $model->inc_views();
        $category = $model->category;

        $other_category_news = $category->news
            ->where('lang','=',I18n::$lang)
            ->where('status', '=', 1)
            ->where('id', '!=', $model->id)
            ->where(DB::expr("DATE_FORMAT(date,'%Y-%m')"), '=', date('Y-m'))
            ->where('date', '<=', date('Y-m-d H:i:s'))
            ->order_by('views', 'DESC')
            ->limit(3)
            ->find_all();

        $last_category_news = $category->news
            ->where('lang','=',I18n::$lang)
            ->where('status', '=', 1)
            ->where('id', '!=', $model->id)
            ->where('date', '<=', date('Y-m-d H:i:s'))
            ->order_by('date', 'DESC')
            ->limit(4)
            ->find_all();



        $popular_news = Model_News::get_popular_news();

        $type = null;
        if ($model->audio) {
            $type = 'audio';
        } elseif ($model->video) {
            $type = 'video';
        }

        $this->page->title($model->title);

        $meta_title = $model->meta_title ? $model->meta_title : $model->title;
        $meta_description = $model->meta_description ? $model->meta_description : $model->description;
        $this->page->meta($meta_title, 'og:title');
        $this->page->meta(URL::site($model->file_s->html_img_url(1200, 630), 'http'), 'og:image');
        $this->page->meta($meta_description, 'description');
        $this->page->meta($meta_description, 'og:description');
        $view = View::factory('news/view')
            ->bind('type', $type)
            ->bind('model', $model)
            ->bind('popular_news', $popular_news)
            ->bind('last_category_news', $last_category_news)
            ->bind('other_category_news', $other_category_news);
        $this->page->content($view);
    }

    public function action_subscribe()
    {
        $post = $this->request->post();
        if ($post) {
            $mail = ORM::factory('Mail');
            $mail->to = Arr::get($post, 'email');
            $mail->subject = '';
            $mail->text = '';
            $mail->save();
        }
    }

}

