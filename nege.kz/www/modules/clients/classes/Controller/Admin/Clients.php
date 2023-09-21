<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Timur Ilyassov
 * Date: 11.04.13
 * Time: 9:55
 * To change this template use File | Settings | File Templates.
 */
class Controller_Admin_Clients extends Admin
{
    public $option = array('model' => 'Client');


    protected function _before_save($model){
        $model->hash_key = null;
        return parent::_before_save($model);
    }
}
//end of Controller_Admin_Client

