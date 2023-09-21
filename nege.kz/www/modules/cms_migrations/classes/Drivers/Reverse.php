<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 05.07.13
 * Time: 9:42
 * To change this template use File | Settings | File Templates.
 */

abstract class Drivers_Reverse extends Drivers_Common{

    protected $db;


    public function __construct($db){
        $this->db=$db;
    }

    /**
     * @return array
     */
    abstract public function dump();
}