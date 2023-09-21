<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Role extends Model_Auth_Role{
    protected $_has_many = array(
        'users' => array('through' => 'roles_users'),
    );
    
}

