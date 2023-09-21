<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 17.09.12
 * Time: 12:34
 * To change this template use File | Settings | File Templates.
 */
abstract class Components_Widget
{
    protected $view;
    protected $elements=array();
    protected $id;

    public function __construct()
    {

    }

    public function set_id($id){
        $this->id=$id;
    }

    abstract function add($options);

    function __toString(){
        return $this->view->render();
    }
}
