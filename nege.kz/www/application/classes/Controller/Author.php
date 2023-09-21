<?php


class Controller_Author extends Site
{
    public function action_index() {

        $author= ORM::factory('Author', $cat = $this->request->param('id'));
        $page = $this->request->param('page');
        if (!$author->loaded()) {
            throw new HTTP_Exception_404;
        }
        $model = $author->news()
            ->order_by('date', 'DESC');
        $pagination = $this->pagination($model, 'pagination.news');
        $collection = $model->find_all();
        $total_pages = $pagination->total_pages;
        $this->check_pages($page, $total_pages);
        $this->page->title($author->name);
        $this->page->meta($author->name, 'og:title');
        $view = View::factory('author/index')
            ->bind('pagination', $pagination)
            ->bind('collection', $collection)
            ->bind('author', $author);
        $this->page->content($view);
    }
}