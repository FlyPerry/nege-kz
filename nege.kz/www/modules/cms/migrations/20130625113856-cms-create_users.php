<?php defined('SYSPATH') or die('No direct script access.');

class create_users extends Migration
{
    public function up()
    {
        $this->create_table('users', array(
            'id'=>array('integer','unsigned'=>true),
            'email'=>array('string[254]','null'=>false),
            'username'=>array('string[32]','null'=>false),
            'password'=>array('string[64]','null'=>false),
            'logins'=>array('integer','unsigned'=>true),
            'activation_hash'=>array('string[64]'),
            'passremind_hash'=>array('string[64]'),
            'reg_date'=>array('datetime','null'=>false),
            'last_login'=>array('integer','unsigned'=>true,'null'=>false),
            'firstname'=>array('string[255]','null'=>false),
            'lastname'=>array('string[255]','null'=>false),
            'identity'=>array('string[255]'),
            'network'=>array('string[255]'),
            'socpage'=>array('string[255]'),

        ));

        $this->add_index('users','uniq_email',array('email'),'unique');
        $this->add_index('users','uniq_username',array('username'),'unique');

        $this->create_table('roles',array(
            'id'=>array('integer','unsigned'=>true),
            'name'=>array('string[32]','null'=>false),
            'description'=>array('string[255]','null'=>false),
        ));

        $this->add_index('roles','uniq_name',array('name'),'unique');
        $this->create_table('roles_users',array(
            'user_id'=>array('integer','unsigned'=>true,'null'=>false),
            'role_id'=>array('integer','unsigned'=>true,'null'=>false),
        ),array('user_id','role_id'));
        $this->create_table("user_tokens", array("id" => array(0 => "integer", "null" => FALSE, "unsigned" => TRUE, "auto" => TRUE), "user_id" => array(0 => "integer", "null" => FALSE, "unsigned" => TRUE), "user_agent" => array(0 => "string[40]", "null" => FALSE), "token" => array(0 => "string[40]", "null" => FALSE), "created" => array(0 => "integer", "null" => FALSE, "unsigned" => TRUE), "expires" => array(0 => "integer", "null" => FALSE, "unsigned" => TRUE)), array("id"));


        $this->add_foreign_key('roles_users','user_id','fk_roles_users_user_id','users','id');
        $this->add_foreign_key('roles_users','role_id','fk_roles_users_role_id','roles','id');

        $this->insert_data('roles',array('name', 'description'),array('name'=>'login','description'=>'Пользователь'));
        $this->insert_data('roles',array('name', 'description'),array('name'=>'admin','description'=>'Администратор'));
    }

    public function down()
    {
        $this->drop_table('roles_users'); //Дропаем таблицу с fk
        $this->drop_table('users');
        $this->drop_table('roles');


        // $this->remove_column('table_name', 'column_name');
    }
}