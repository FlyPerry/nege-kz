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


    protected $index = 'materials';


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
        $index = $this->client->getIndex('materials');
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

        if ($type) {
            $search->addType($type);
        }

        $multi_match = new Elastica\Query\MultiMatch();
        $multi_match->setFields($fields)
            ->setQuery($value);


        $bool = new Elastica\Query\Bool();
        $bool->addMust(new \Elastica\Query\Match('lang', $lang))

            ->addMust($multi_match);



        $query = new Elastica\Query($bool);
        $query->setPostFilter(new \Elastica\Filter\Range('date',array('lte'=>time())));
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
        if($model instanceof Model_News || $model instanceof Model_News2){
            if ($model->status != 1) {
                return false;
            }
            $type = $this->get_type($model);
            if ($model->type == 4) {
                $type = 'blogs';
            }
            $data = array(
                'title' => $model->title,
                'text' => strip_tags($model->text),
                'category_id' => $model->category_id,
                'date' => strtotime($model->date),
                'lang' => $model->lang,
                'tags' => $model->tags,
                'author'=>$model->author->title,
            );
        }elseif($model instanceof Model_Speaker){
            $type = $this->get_type($model);
            $data = array(
                'title' => $model->fullname,
                'text' => strip_tags($model->biography),
                'lang' => $model->lang,
            );
        }elseif($model instanceof Model_Live){
            $type = $this->get_type($model);

            $data = array(
                'title' => $model->title,
                'text' => strip_tags($model->text),
                'date' => strtotime($model->date),
                'lang' => $model->lang
            );
        }
        elseif($model instanceof Model_Material){
            if ($model->type != 2) {
                return false;
            }
            $type = $this->get_type($model);

            $data = array(
                'title' => $model->title,
                'text' => strip_tags($model->description),
                'date' => strtotime($model->date),
                'lang' => $model->lang,
                'author'=>$model->author->title,
            );
        }else{
            return false;
        }

        $index = $this->client->getIndex('materials');
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
        'Model_News2' => 'news',
        'Model_Article' => 'news',
        'Model_Blog' => 'news',
        'Model_Pnews' => 'news',
        'Model_Vnews' => 'news',
        'Model_Longread' => 'news',
        'Model_Speaker' => 'persons',
        'Model_Live' => 'live',
        'Model_Material' => 'infographics'
    );


}