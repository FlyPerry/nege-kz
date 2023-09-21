<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Timur Ilyassov
 * Date: 11.04.13
 * Time: 9:55
 * To change this template use File | Settings | File Templates.
 */
class Controller_Admin_Domains extends Admin_Embeded
{
    public $option = array('model' => 'Domain');

    public function before(){
        parent::before();
        Event::instance()->bind('admin.edit.save.after',array($this,'after_save'));
        Event::instance()->bind('admin.edit.save.before',array($this,'before_save'));
    }


    public function action_source(){
        $this->render = false;
        $q = $this->request->query('query');
        if(strlen($q)>=3){
            $collection = ORM::factory('Client_Domain')->where('domain','LIKE',"%$q%")->find_all();
            $data = array();
            foreach($collection as $row){
                $data[] = array('name'=>$row->domain,'id'=>$row->id);
            }
            $this->response->body(json_encode($data));
        }

    }

    public function before_save($model){
        foreach($model->allowed->find_all() as $row){
            $row->delete();
        }
    }

    protected function _save(&$model,$values,$external=null, $expected=null)
    {

        if ($expected === NULL) {
            $expected = array_merge(array_keys($model->table_columns()), array_keys($model->fields_description()));
        }
        unset($expected[array_search('allowed',$expected)]);
        try {
            if (!($model instanceof ORM)){
                $model = ORM::factory($model);

                $model->values($values,$expected);
            }
            else {
                $model->values($values,$expected);
            }
            $model->save($external);
        } catch (ORM_Validation_Exception $e) {
            $this->errors=array_merge($this->errors,$e->errors('model'));
            if (isset($this->errors['_external']))
                $this->errors=array_merge($this->errors,$this->errors['_external']);
            return false;
        }
        return $model;
    }

    public function after_save($model){
        $values = Arr::get($this->request->post('model'),'allowed');
        foreach($values as $value){
            if($value){
                $allowed = ORM::factory('Domain_Allowed');
                $allowed->domain = $value;
                $allowed->domain_id = $model->id;
                $allowed->save();
            }

        }
    }



    
}
//end of Controller_Admin_Client

