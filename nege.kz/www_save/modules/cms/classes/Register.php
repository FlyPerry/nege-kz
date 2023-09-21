<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 04.12.12
 * Time: 14:32
 * To change this template use File | Settings | File Templates.
 */
class Register
{
    protected static $instance;
    protected $_data = array();

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

    function __get($name)
    {
        $data = Arr::get($this->_data, $name, null);
        return $data;
    }

    function __set($name, $value)
    {
        $this->_data[$name] = $value;
    }


}
