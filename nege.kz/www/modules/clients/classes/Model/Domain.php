<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 08.04.13
 * Time: 11:18
 * To change this template use File | Settings | File Templates.
 */
class Model_Domain extends ORM_Embeded
{
    protected  $_route = "domains";
    protected $_parent_field="client_id";
    protected $_parent_model="Client";
    protected $_table_name = "client_domains";

    protected $_belongs_to = array(
        'client'=>array(
            'model'=>'Client'
        ),
        'photo_s'=>array(
            'model'=>'Storage',
            'foreign_key'=>'image'
        )
    );


    protected $_has_many = array(
        'moderators'=>array(
            'model'=>'Moderator',
            'through'=>'domain_users',
            'foreign_key'=>'domain_id',
            'far_key'=>'user_id'
        ),
//        'bans'=>array(
//            'model'=>'User',
//            'through'=>'projects_users_ban',
//            'foreign_key'=>'project_id',
//            'far_key'=>'user_id'
//        ),
        'allowed'=>array(
            'model'=>'Domain_Allowed',
            'foreign_key'=>'domain_id',
        ),
    );


    public function get_field($field){
        if($field=='image'){
            return $this->{$field}?ORM::factory('Storage',$this->{$field})->url('http'):null;
        }else{
            return parent::get_field($field);
        }
    }


    public function actions($user=null)
    {

        $edit = array(
            'title' => 'Редактировать',
            'uri' => $this->edit_url(true)
        );
        $delete = array(
            'title' => 'Удалить',
            'uri' => $this->delete_url(true)
        );
        $menu = array(
//            $view,
//            $edit,
//            $delete,
        );
        Authority::can('edit',$this->object_name(),$this) && $menu[]=$edit;
        Authority::can('delete',$this->object_name(),$this) && $menu[]=$delete;
        return $menu;
    }

    public function buttons(){
        return array(
            'list'=>array(
//                array('type'=>'link','title'=>'Добавить','link'=>$this->edit_url(),'class'=>'btn-success'),
                array('type'=>'button','title'=>'Удалить','click'=>'$deleteModels','class'=>'btn-danger'),
            ),
            'edit'=>array(
                array('type'=>'button','title'=>'Сохранить','click'=>'$saveModel','class'=>'btn btn-success'),
                array('type'=>'button','title'=>'Назад','click'=>'$cancelModel','class'=>'btn'),
                array('type'=>'button','title'=>'Удалить','click'=>'$deleteModel','class'=>'btn btn-danger')
            ),
            'search'=>array(
                array('type'=>'button','title'=>'Поиск','click'=>'$search','class'=>'btn btn-success'),
                array('type'=>'button','title'=>'Сбросить','click'=>'$searchReset','class'=>'btn'),
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
                'ng'=>true,
            ),
            'title'=>array(
                'head'=>true,
                'label'=>'Название',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',
                'ng'=>true,
            ),
            'description'=>array(
                'head'=>false,
                'label'=>'Описание',
                'edit'=>true,
                'type'=>'text',
                'ng'=>true,
            ),
            'domain'=>array(
                'head'=>true,
                'label'=>'Домен',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',
                'ng'=>true,
            ),
            'allowed'=>array(
                'head'=>false,
                'label'=>'Домены, с которых разрешен запуск виджета',
//                'search'=>true,
                'edit'=>true,
                'type'=>'input_extended',
                'params'=>array(
//                    'options'=>$this->allowed->select_options('id','domain'),
                    'value'=>$this->allowed->select_options('id','domain'),
                ),
            ),
            'moderators'=>array(
                'head'=>false,
                'label'=>'Модераторы',
                'edit'=>true,
                'type'=>'select_extended',
                'params'=>array(
                    'options'=>$this->client->moderators->select_options('id','description'),
                    'value'=>$this->moderators->select_options('id','description')
                ),

            ),
//            'image'=>array(
//                'head'=>false,
//                'label'=>'Изображение',
//                'search'=>false,
//                'edit'=>true,
//                'type'=>'image',
//                'ng'=>true,
//            ),
//            'client_id'=>array(
//                'head'=>false,
//                'label'=>'Клиент',
//                'search'=>true,
//                'edit'=>false,
//                'type'=>'strings',
//                'params'=>array(
//                    'value'=>$this->client->name,
//                ),
//                'ng'=>true,
//
//            ),
            'header_url'=>array(
                'head'=>false,
                'label'=>'URL фрейма в шапке',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',
                'ng'=>true,
            ),
            'header_h'=>array(
                'head'=>false,
                'label'=>'Высота фрейма в шапке',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',
                'ng'=>true,
                'params'=>array(
                    'attr'=>array('maxlength'=>'3')
                )
            ),
            'footer_url'=>array(
                'head'=>false,
                'label'=>'URL фрейма в подвале',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',
                'ng'=>true,
            ),
            'footer_h'=>array(
                'head'=>false,
                'label'=>'Высота фрейма в подвале',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',
                'ng'=>true,
                'params'=>array(
                    'attr'=>array('maxlength'=>'3')
                )
            ),
            'sidebar_url'=>array(
                'head'=>false,
                'label'=>'URL фрейма в боковой панели',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',
                'ng'=>true,
            ),
            'sidebar_h'=>array(
                'head'=>false,
                'label'=>'Высота фрейма в боковой панели',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',
                'ng'=>true,
                'params'=>array(
                    'attr'=>array('maxlength'=>'3')
                )
            ),
            'copyright'=>array(
                'head'=>false,
                'label'=>'Копирайт центра поддержки',
                'search'=>true,
                'edit'=>true,
                'type'=>'strings',
                'ng'=>true,
                'params'=>array(
                    'attr'=>array('maxlength'=>'500')
                )
            ),





        );

    }

    public function rules()
    {
        return array(
            'header_h' => array(
                array('max_length', array(':value', 3)),
                array('digit')
            ),
            'footer_h' => array(
                array('max_length', array(':value', 3)),
                array('digit')
            ),
            'sidebar_h' => array(
                array('max_length', array(':value', 3)),
                array('digit')
            ),
            'copyright' => array(
                array('max_length', array(':value', 500))
            ),
            'header_url' => array(
                array('url')
            ),
            'footer_url' => array(
                array('url')
            ),
            'sidebar_url' => array(
                array('url')
            ),
            'domain'=>array(
                array(array($this, 'unique'), array('domain', ':value')),
            ),

        );
    }

}
