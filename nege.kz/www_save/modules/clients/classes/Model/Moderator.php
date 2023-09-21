<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sgm
 * Date: 27.06.13
 * Time: 14:52
 * To change this template use File | Settings | File Templates.
 */

class Model_Moderator extends Model_User {

    protected $_table_name = 'users';

    protected $_route = "moderator";
    protected $possibly_banned = false;

    protected $_belongs_to = array(
        'client'=>array(
            'model'=>'Client',
            'foreign_key'=>'client_id'
        ),
    );

    public function ng_editRoles(){
        return array('owner');
    }

    public function ng_listRoles(){
        return array('owner','support');
    }

    protected $_has_many = array(
        'domains'=>array(
            'model'=>'Domain',
            'through'=>'domain_users',
            'foreign_key'=>'user_id',
        ),
//        'projects'=>array(
//            'model'=>'Project',
//            'through'=>'domain_users',
//            'foreign_key'=>'user_id',
//            'far_key'=>'domain_id'
//        ),
        'clients'=>array(
            'model'=>'Client',
            'through'=>'client_users',
            'foreign_key'=>'user_id'
        ),
        'user_tokens' => array('model' => 'User_Token'),
        'roles'       => array(
            'model' => 'Role',
            'through' => 'roles_users',
            'foreign_key'=>'user_id'
        ),
    );

    public function get($column){
        if($column=='description'){
            return parent::get('firstname').' '.parent::get('lastname');
        }
        return parent::get($column);
    }

    public function as_array()
    {
        $data = parent::as_array();
        unset($data['password']);
//        unset($data['password']);
        return $data;
    }

    public function rules()
    {
        return array(
            'username' => array(
                array('not_empty'),
                array('max_length', array(':value', 32)),
                array(array($this, 'unique'), array('username', ':value')),
            ),
            'password' => array(
                array('not_empty'),
//                array('matches',array($_POST,'password','password_confirm')),
            ),
            'email' => array(
                array('not_empty'),
                array('email'),
                array(array($this, 'unique'), array('email', ':value')),
            ),
            'firstname'=>array(
                array('not_empty')
            ),
            'lastname'=>array(
                array('not_empty')
            ),
        );
    }

    public function labels()
    {
        $fields = $this->fields_description();
        $data = array();
        foreach ($fields as $name => $value) {
            if (isset($value['label'])) {
                if (isset($value['params']) && isset($value['params']['widget']) && $value['params']['widget']=='multilang'){
                    $data[$name."_ru"] = $value['label'];
                    $data[$name."_kz"] = $value['label'];
                    $data[$name."_en"] = $value['label'];
                } else {
                    $data[$name] = $value['label'];
                }
            }
        }
        return $data;
    }

    public function fields_description()
    {
        return array(
            'id'=>array(
                'label'=>'#',
                'head'=>true,
                'edit'=>false,
                'type'=>'strings',
            ),
            'username'=>array(
                'label'=>'Логин',
                'head'=>true,
                'edit'=>true,
                'search'=>true,
                'type'=>'strings',
                'ng'=>true,
            ),


            'email'=>array(
                'edit'=>true,
                'type'=>'strings',
                'label'=>'E-mail',
                'head'=>true,
                'search'=>true,
                'ng'=>true,
            ),
            'firstname'=>array(
                'edit'=>true,
                'type'=>'strings',
                'label'=>'Имя',
                'head'=>true,
                'search'=>true,
                'ng'=>true,
            ),
            'lastname'=>array(
                'edit'=>true,
                'type'=>'strings',
                'label'=>'Фамилия',
                'head'=>true,
                'search'=>true,
                'ng'=>true,
            ),
            'password'=>array(
                'edit'=>true,
                'type'=>'password',
                'label'=>'Пароль',
                'edit'=>true,
                'ng'=>true,
            ),
            'roles' => array(
                'edit' => true,
                'type' => 'multi_select',
                'label' => 'Роли',
//                'search' => true,
//                'loaded'=>TRUE,
                'params' => array(
                    'options' => ORM::factory('Role')->where('name', 'NOT IN', array('ban', 'login','admin'))->select_options('id', 'description'),
                ),
                'ng'=>true,
            ),
            'client_id'=>array(
                'edit'=>false,
                'search'=>true,
                'type'=>'select',
                'ng'=>true,
            ),
            'description'=>array(
                'edit'=>false,
                'search'=>true,
                'type'=>'strings',
                'ng'=>true,
            ),

        );
    }

}