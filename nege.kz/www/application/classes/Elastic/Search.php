<?php

/**
 * Created by PhpStorm.
 * User: AxCx
 * Date: 01.10.2015
 * Time: 12:33
 */


use Elastica\Query;

class Elastic_Search
{

    protected static $_instance;


    protected $client;


    protected $config;


    protected $index = 'newsfeed';


    protected $index_models = array();


    protected function __construct()
    {
        $this->client = Elastic::client();
        $this->config = Kohana::$config->load('search');
        $this->index_models = $this->config->get('models');
    }


    public static function instance()
    {
        if (!self::$_instance) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }


    public function index($model)
    {
        $index = $this->client->getIndex('newsfeed');
        $model_key = $this->getModelName($model);
        $model_fields = Arr::get($this->index_models, $model_key, false);

        if ($model_fields) {
            $type = $index->getType($model_key);

            $data = array();
            foreach ($model_fields as $field) {
                if (is_callable(array($model, $field))) {
                    $value = $model->{$field}();
                } else {
                    $value = $model->{$field};
                }
                $data[$field] = strip_tags($value);
            }
            $doc = new Elastica\Document(intval($model->id), $data);
            $type->addDocument($doc);
            $type->getIndex()->refresh();
        }
    }


    public function getModelName($model)
    {
        return strtolower(str_replace('Model_', '', get_class($model)));
    }


    public function getIndex($index = null)
    {
        return $this->client->getIndex(!$index ? $this->index : $index);
    }


    public function search($fields, $value, $type = null, $highlight_field = null, $lang = 'ru', $limit = 12, $offset = 0, array $sort = array(
        '_score' => array('order' => 'desc')
    ))
    {
        $search = new Elastica\Search($this->client);
        $search->addIndex($this->index);

        if ($type && $type!='authors') {
            $search->addType($type);
        }

        $multi_match = new Elastica\Query\MultiMatch();
        $multi_match->setFields($fields)
            ->setQuery($value);


        $bool = new Elastica\Query\BoolQuery();
        $bool->addMust(new \Elastica\Query\Match('lang', $lang))

            ->addMust($multi_match);



        $query = new Elastica\Query($bool);
        $query->setPostFilter(new \Elastica\Query\Range('date',array('lte'=>time())));
        $query->setFrom($offset)
            ->setSize($limit)
            ->setSort($sort);

        if ($highlight_field) {
            $query->setHighlight(array(
                'pre_tags' => array('<span class="query">'),
                'post_tags' => array('</span>'),
                'fields' => array(
                    $highlight_field => $this->config->get('highlight')
                ),
            ));
        }

        return $search->setQuery($query)->search();
    }


    public function reindex($model)
    {
        $lang = $model->lang;
        I18n::lang($lang);
        switch (get_class($model)) {
            case 'Model_News':
            case 'Model_Longread':

                if ($model->status != 1) {
                    return false;
                }
                $type = $this->get_type($model);

                $data = array(
                    'id' => $model->id,
                    'title' => $model->title,
                    'text' => strip_tags($model->text),
                    'category_id' => $model->category_id,
                    'date' => strtotime($model->date),
                    'lang' => $model->lang,
                    'tags' => $model->tags,
//                    'author_name'=>$model->author->title,
                );
                break;
        }


        $data['view_url'] = $model->view_url();
        $index = $this->client->getIndex('newsfeed');
        $type = $index->getType($type);
        $doc = new Elastica\Document(intval($model->id), $data);
        $type->addDocument($doc);
        $type->getIndex()->refresh();
    }


    public function delete($model)
    {
        $type = $this->get_type($model);

        if ($type) {
            $typeReq = $this->getIndex()->getType($type);
            $typeReq->deleteById($model->id);
            $typeReq->getIndex()->refresh();
        }
    }


    public function get_type($model)
    {
        $type = Arr::get($this->models_types, get_class($model), false);

        if ($type == 'news' && $model->type == 4) {
            return 'blogs';
        }
        return $type;

    }


    protected $models_types = array(
        'Model_News' => 'news',
        'Model_Longread' => 'news',
        'Model_Speaker' => 'persons',
        'Model_Live' => 'live',
        'Model_Material' => 'infographics'
    );


}