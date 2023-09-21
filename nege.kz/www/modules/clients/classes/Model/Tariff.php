<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sgm
 * Date: 16.09.13
 * Time: 10:56
 * To change this template use File | Settings | File Templates.
 */

class Model_Tariff extends ORM {

    protected  $_route = "tariffs";
    protected $_has_many = array(
        'domains'=>array(
            'model'=>'Domain',
            'foreign_key'=>'client_id'
        ),
        'moderators'=>array(
            'model'=>'Moderator',
            'foreign_key'=>'client_id'
        ),
    );

    public function get_field($field)
    {
        if($field=='enabled'){
            return $this->{$field}?'Да':'Нет';
        }
        return $this->__get($field);
    }

    public function filters(){
        return array(
            'count'=>array(
                array(array($this, 'int_val'))
            ),
            'moderators_count'=>array(
                array(array($this, 'int_val'))
            ),
        );
    }

    public function int_val($value){
        return intval($value);
    }

    public function rules(){
        return array(
            'count'=>array(
                array('digit'),
            ),
            'Moderators_count'=>array(
                array('digit'),
            ),
            'price'=>array(
                array('digit'),
            ),
        );
    }

    public function fields_description(){
        return array(
            'id'=>array(
                'head'=>true,
                'label'=>'#',
                'search'=>true,
                'edit'=>false,
                'type'=>'strings',

            ),
            'title'=>array(
                'head'=>true,
                'label'=>'Название',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',
                'params'=>array(
                    'widget'=>'multilang',
                ),

            ),
            'count'=>array(
                'head'=>true,
                'label'=>'Кол-во доменов',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',

            ),
            'moderators_count'=>array(
                'head'=>true,
                'label'=>'Кол-во модераторов',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',

            ),
            'price'=>array(
                'head'=>true,
                'label'=>'Цена',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',

            ),
            'enabled'=>array(
                'head'=>true,
                'label'=>'Отображать',
                'search'=>true,
                'edit'=>true,
                'type'=>'select',
                'params'=>array(
                    'options'=>array('0'=>'Нет','1'=>'Да')
                ),

            ),
        );

    }
}