<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 20.04.13
 * Time: 14:44
 * To change this template use File | Settings | File Templates.
 */

class Cms_API extends Cms_Controller_Auth {
    public $model_name;

    public $perpage=10;

    public $perpage_limit=100;

    public $errors=array();

    public function auto_detect_model_name(){
        $array = explode('_', get_class($this));
        return array_pop($array);
    }

    public function get_model_name(){
        if (!$this->model_name){
            $this->model_name=$this->auto_detect_model_name();
        }

        return $this->model_name;
    }

    public function before()
    {
        parent::before();

        $this->render=false;
        $this->response->headers('content-type','text/json');
    }

    /**
     * Получение модели по айди, или получение массива элементов
     */
    public function action_get_index()
    {
        $model=$this->model();
        $collection=null;

        $id=$this->request->param('id');

        if ($id){
            $model=$this->model_filter_get($model,$id);
            $model->where('id','=',$id)->find();
            if (!$model->loaded()){
                throw new HTTP_Exception_404;
            }
            $extra=$this->model_extra_get($model);
            $this->response_model($model,$extra);
        } else {
            $perpage=(int)$this->request->query('perpage');
            $perpage=$perpage?$perpage:$this->perpage;
            if ($perpage>$this->perpage_limit){
                $perpage=$this->perpage_limit;
            }
            $model=$this->collection_filter_get($model,$id);
            Event::instance()->dispatch('api.model.before.find_all',$model);
            $model->pagination($perpage);
            $collection=$model->find_all();
            $extra=$this->collection_extra_get($collection);
            $this->response_collection($collection,$extra);
//            $this->response->body(View::factory('profiler/stats'));
        }


    }

    public function action_get_countAll()
    {
        $model=$this->model();
        $count=0;

        $id=$this->request->param('id');

//        $model->pagination();
        $model=$this->collection_filter_get($model,$id);
        $count=$model->count_all();
        $this->response->body(json_encode(array('count'=>$count)));

    }

    /**
     * Формирует JSON ответ по модели
     * @param ORM $model
     * @param array $extra Дополнительные параметры которые нужно выслать вместе с моделью
     */
    public function response_model($model,$extra=array()){
        $data = $extra+$model->as_array();
        $this->response->body(json_encode($data));
    }

    /**
     * Формирует JSON ответ по массиву объектов
     * @param Database_MySQL_Result $collection
     * @param array $extra Дополнительные параметры которые нужно выслать вместе с массивом
     */
    public function response_collection($collection,$extra=array()){
        $models=array();
        foreach ($collection as $model){
            $models[]=$this->collection_extra_for_model($model)+$model->as_array_ext();
        }
        $this->response->body(json_encode($models+$extra));
    }

    /**
     * Формирует JSON сообщение об ошибке
     * @param Database_MySQL_Result $collection
     * @param array $extra Дополнительные параметры которые нужно выслать вместе с массивом
     */
    public function response_error($message,$class = 'error'){

        $this->response->body(json_encode(array('error'=>array(
            'msg'=>$message,
            'type'=>$class,
            'error'=>'error'
        ))));
    }

    public function after()
    {
        parent::after();
    }

    /**
     * Метод для добавления условий выборки модели
     * @param ORM $model
     * @param int $id
     * @return ORM mixed
     */
    protected  function model_filter_get($model, $id)
    {
        return $model;
    }

    /**
     * Метод для формирования добавочных данных к ответу
     * @param ORM $model
     * @return array
     */
    protected  function model_extra_get($model)
    {
        return array();
    }

    /**
     * Метод для добавления условий в выборку моделей
     * @param ORM $model
     * @param int $id
     * @return ORM
     */
    protected  function collection_filter_get($model, $id)
    {
        $fields=$model->fields_description();
        $fields=array_filter($fields,function($value){
            return isset($value['search']) && $value['search'];
        });
        $keys=array_keys($fields);
        $search=Arr::extract($this->request->query(),$keys);
        $search=array_filter($search,function($value){
            $trim = trim($value);
            return !empty($trim);
        });
        foreach ($search as $field=>$value){
            $info=$fields[$field];
            switch ($info['type']){
                case "multi_select":
                    $has_many = $model->has_many();
                    $alias= $has_many[$field];
                    $model->join($alias['through'],'LEFT')->on($alias['foreign_key'],'=',$model->object_name().'.id');
                    if (is_array($value)){
                        $model->where($alias['far_key'],'IN',$value);
                    } else {
                        $model->where($alias['far_key'],'=',$value);
                    }
                    break;
                case "select":;
                case "select_value":
                    $model->where($field,'=',$value);
                    break;
                case "strings":;
                case "text":;
                default: $model->where($field,'LIKE',"%$value%");
            }
        }
        return $model;
    }

    /**
     * Метод для формирования добавочных данных к ответу
     * @param Database_MySQL_Result $collection
     * @return array
     */
    protected  function collection_extra_get($collection)
    {
        return array();
    }

    /**
     * Метод для формирования добавочных данных к каждой модели из коллекции
     * @param ORM $model
     * @return array
     */
    protected  function collection_extra_for_model($model)
    {
        return array();
    }

    public function action_post_index()
    {
        $model=$this->model();
        $id=$this->request->param('id');
        if ($id){
            return $this->action_put_index();
        }
        $raw_values= $this->body_to_array();
        Event::instance()->dispatch("api.model.save.before",$model,$raw_values);
        $model=$this->save_model($model, $raw_values);
        Event::instance()->dispatch("api.model.save.after",$model);
        $extra=$this->model_extra_get($model)+array('errors'=>$this->errors);
        Event::instance()->dispatch("api.model.save.extra",$extra);
        $this->response_model($model,$extra);
    }

    public function action_put_index()
    {
        $model=$this->model($this->request->param('id'));
        if (!$model->loaded()){
            throw new HTTP_Exception_404;
        }
        $raw_values= $this->body_to_array();
        Event::instance()->dispatch("api.model.update.before",$model,$raw_values);
        $model=$this->save_model($model, $raw_values);
        Event::instance()->dispatch("api.model.update.after",$model);
        $extra=$this->model_extra_get($model)+array('errors'=>$this->errors);
        Event::instance()->dispatch("api.model.update.extra",$extra);
        $this->response_model($model,$extra);
    }

    public function action_delete_index()
    {
        $model=$this->model($this->request->param('id'));
        if ($this->csrf_check()){
            Event::instance()->dispatch("api.model.delete.before",$model);
            $id=$model->pk();
            $model->delete();
            Event::instance()->dispatch("api.model.delete.after",$id);
        }
    }

    /**
     * Создает модель для текущего контроллера
     * @param null $id
     * @return ORM
     */
    public function model($id=null)
    {
        return ORM::factory($this->get_model_name(),$id);
    }

    /**
     * @param $model
     * @return array
     */
    public function editable_keys($model)
    {
        return array_keys(array_filter($model->fields_description(),function($val){
            return !!Arr::get($val,'edit');
        }));
    }

    /**
     * @return array
     */
    public function body_to_array()
    {
        return (array)json_decode($this->request->body());
    }

    /**
     * @param ORM $model
     * @param $raw_values
     * @param null $extra_valid Результат внешней валидации, если FALSE, то вместо сохранение будет выполнена просто валидация
     * @return \ORM
     */
    public function save_model($model, $raw_values, $extra_valid=NULL)
    {
        if (!$this->csrf_check()){
            $this->errors+=array('csrf'=>__('Не валидный токен безопасности'));
            return $model;
        }
        $keys = $this->editable_keys($model);
        $model->values($raw_values, $keys);
        try {
            if ($extra_valid===FALSE){
                $model->check();
            } else {
                $model->save();
            }
        } catch (ORM_Validation_Exception $e) {
            $this->errors += $e->errors('messages');
        }
        return $model;
    }




    public function action_get_metadata()
    {
        $model=$this->model();
        $metadata=array(
            'ClassName'=>get_class($model),
            'fields'=>array(
                'list'=>array(),
                'edit'=>array(),
            ),
            'editRoles'=>$model->ng_editRoles(),
            'listRoles'=>$model->ng_listRoles(),
            'labels'=>$model->labels(),
            'hasMany'=>$model->has_many(),
            'belongsTo'=>$model->belongs_to(),
            'hasOne'=>$model->has_one(),
            'url'=>array(
                'edit'=>$model->ng_edit_url(),
                'delete'=>$model->delete_url(),
                'list'=>$model->ng_list_url(),
                'view'=>$model->view_url(),

            ),
            'tpl'=>array(
                'list'=>URL::site('admin/api/'.strtolower($this->model_name).'?method=list_template'),
                'edit'=>URL::site('admin/api/'.strtolower($this->model_name).'?method=edit_template'),
            ),
            'buttons'=>$model->ng_buttons(),
            'actions'=>$model->ng_actions($this->user),
            'info'=>$model->fields_description(),
        );
        $fields=$model->fields_description();
        foreach ($fields as $name=>$field){
            if (Arr::get($field,'head',false)){
                $metadata['fields']['list'][]=$name;
            }
            if (Arr::get($field,'edit',false)){
                $metadata['fields']['edit'][]=$name;
            }

            if (Arr::get($field,'search',false) && Arr::get($field,'label',false)){
                $metadata['fields']['search'][]=$name;
            }
        }

        $this->response->body(json_encode($metadata));
    }

    public function action_get_edit_template()
    {
        $model=$this->model();
        $this->response->headers('content-type','text/html');
        $view=View::factory('angular/tpls/admin/edit')->bind('model',$model);
        $this->response->body($view);
    }

    public function action_get_list_template()
    {
        $model=$this->model();
        $this->response->headers('content-type','text/html');
        $view=View::factory('angular/tpls/admin/list')->bind('model',$model);
        $this->response->body($view);
    }

    public function action_get_through()
    {
        $model=$this->model();
        $id=(int)$this->request->query('fk');
        $modelName=$this->request->query('model');
        $alias=$this->request->query('alias');
        $has_many=new $modelName($id);
//        $has_many->where($has_many->pk(),'=',$id)->find();
        $model=$has_many->$alias;
        $model->pagination();
        $model=$this->collection_filter_get($model,$id);
        $collection=$model->find_all();
        $extra=$this->collection_extra_get($collection);
        $this->response_collection($collection,$extra);


    }
}