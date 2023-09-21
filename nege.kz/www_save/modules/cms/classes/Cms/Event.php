<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 20.05.13
 * Time: 10:49
 * To change this template use File | Settings | File Templates.
 */

class Cms_Event {
    protected static $instance;
    protected $_handlers = array();

    protected function __construct()
    {
    }

    protected function __clone()
    {

    }

    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function bind($event,$handler){
        isset($this->_handlers[$event]) || ($this->_handlers[$event]=array());
        $this->_handlers[$event][]=$handler;
    }

    public function dispatch(){
        $args=func_get_args();
        $event=array_shift($args);
        if (!isset($this->_handlers[$event])){
            return;
        }
        foreach($this->_handlers[$event] as $callback){
            return call_user_func_array($callback,$args);
        }
    }
}