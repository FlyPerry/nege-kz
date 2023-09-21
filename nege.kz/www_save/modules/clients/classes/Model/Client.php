<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 08.04.13
 * Time: 11:18
 * To change this template use File | Settings | File Templates.
 */
class Model_Client extends ORM
{

    protected  $_route = "clients";
    protected $_has_many = array(
        'domains'=>array(
            'model'=>'Domain',
            'foreign_key'=>'client_id'
        ),
        'moderators'=>array(
            'model'=>'User',
            'through'=>'client_users',
//            'foreign_key'=>'user_id',
            'foreign_key'=>'client_id',
            'far_key'=>'user_id'
        )
    );
    public function rules(){
        return array(
            'tariff_id'=>array(
                array('not_empty')
            ),
            'phone'=>array(
                array('not_empty'),
                array('phone'),
            ),
            'name'=>array(
                array('not_empty')
            ),
        );
    }

    public $_belongs_to = array(
        'tariff'=>array(
            'model'=>'Tariff',
            'foreign_key'=>'tariff_id'
        ),
    );

    public function filters(){
        return array(
            'hash_key'=>array(
                array(array($this,'hash_key')),
            ),
        );
    }


    protected function hash_key(){
        if(!$this->hash_key){
            $value=rand(0,5000).$this->name.time();
            return hash('sha256',$value);
        }else
            return $this->hash_key;

    }

    //insert_code
    public function get($column){
        if($column=='insert_code'){
            if($this->id){
                return $this->hash_key;
            }
            else{
                return '!!!PAST YOUR CODE!!!';
            }
        }

        return parent::get($column);
    }

    public function get_field($field){
        if($field == 'tariff_id'){
            return $this->tariff->title_ru;
        }
        return parent::get_field($field);
    }


    public function fields_description(){
        return array(
            'id'=>array(
                'head'=>true,
                'label'=>'#',
                'search'=>true,
                'edit'=>false,
                'type'=>'strings',
                'ng'=>true,
            ),
            'name'=>array(
                'head'=>true,
                'label'=>'Название',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',
                'ng'=>true,
            ),
            'phone'=>array(
                'head'=>true,
                'label'=>'Телефон',
                'search'=>false,
                'edit'=>true,
                'type'=>'strings',
                'ng'=>true,
            ),
            'description'=>array(
                'head'=>true,
                'label'=>'Описание',
                'search'=>true,
                'edit'=>true,
                'type'=>'text',
                'ng'=>true,

            ),
            'tariff_id'=>array(
                'head'=>true,
                'label'=>'Тариф',
                'edit'=>true,
                'type'=>'select',
                'params'=>array(
                    'options' => ORM::factory('Tariff')->find_all()->as_array('id','title_ru'),
//                    'foreign_key' => $this->_has_many['domains']['foreign_key']
                ),
            ),
            'domains'=>array(
                'head'=>false,
                'label'=>'Центры поддержки',
                'edit'=>true,
                'type'=>'embeded'
            ),
            'enabled'=>array(
                'head'=>true,
                'label'=>'Включен',
                'edit'=>true,
                'type'=>'select',
                'params'=>array(
                    'options'=>array(0=>'Нет',1=>'Да')
                ),
            ),
        );

    }

}
