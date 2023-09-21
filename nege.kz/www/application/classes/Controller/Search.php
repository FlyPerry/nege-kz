<?php

/**
 * Created by PhpStorm.
 * User: AxCx
 * Date: 30.09.2015
 * Time: 14:49
 */
class Controller_Search extends Site
{

    public function action_index()
    {

        $sort_options = array(
            'score' => __('по релевантности'),
            'date' => __('по дате'),
        );

        $sorts = array(
            'score' => array(
                '_score' => array('order' => 'desc')
            ),
            'date' => array(
                'date' => array('order' => 'desc')
            )
        );

        $selected_sort = $this->request->query('sort');
        if (!array_key_exists($selected_sort, $sort_options)) {
            reset($sort_options);
            $selected_sort = key($sort_options);
        }

        $page = (int)Arr::get($this->request->query(), 'page', 1);
        if ($page == 0) {
            $page = 1;
        }

        $per_page = 12;

        $raw_query = $this->request->query('query');

        $sort_params = $sorts[$selected_sort];

        $fields = array('text', 'title', 'tags', 'author_name');

        $query = trim(mb_substr(strip_tags($raw_query), 0, 100));
        $this->page->title(__(":query - результаты поиска", array(':query' => $query)));
//        $this->page->meta(__(":query - результаты поиска", array(':query' => $query)), 'title');
        $this->page->meta(__("Казахстанские новости о :query. Все подробности, хронологии событий.", array(':query' => $query)), 'description');

        $r = Elastic_Search::instance()->search($fields, $query, null, 'text', I18n::$lang, $per_page, ($page * $per_page) - $per_page, $sort_params);

        $results = array();
        foreach ($r->getResults() as $y) {
            $result = $y->getData();
            $res = new stdClass();
            $res->id = Arr::get($result, 'id');
            $res->title = Arr::get($result, 'title');
            $res->description = Arr::get($y->getHighlights(), 'text')[0];

            $res->view_url = Arr::get($result, 'view_url');
            $res->image = Arr::get($result, 'image');

            if (array_key_exists('category_id', $result)) {
                $res->category_title = ORM::factory('Category', $result['category_id'])->title;
            }
            if (array_key_exists('date', $result)) {
                $res->date = $this->ordinal_date($result['date']);
            }

            $results[] = $res;
        }

        $idCollection = array(0);
        foreach ($results as $result) {
            $idCollection[] = $result->id;
        }
        $collection = ORM::factory('News')->where('id','in',$idCollection);

        $hits_count = $r->getTotalHits();

        $pagination = $this->pagination($collection);
        $collection = $collection->find_all();

        $this->page->content(View::factory('search/results')
            ->bind('collection', $collection)
            ->bind('hits_count', $hits_count)
            ->bind('query', $query)
            ->bind('pagination', $pagination)
            ->bind('sort_options', $sort_options)
            ->bind('request', $this->request)
            ->bind('selected_sort', $selected_sort)
        );
    }


    public function ordinal_date($d)
    {
        $date = explode(' ', date('d m H:i Y', $d));
        list($day, $month, $time, $year) = $date;
        return sprintf('%d %s', $day, $this->ordinal_month_name($month), $year);
    }

    public function ordinal_month_name($month)
    {
        return __(Arr::get(explode(' ', ORM::$ordinal_months), $month - 1));
    }

}