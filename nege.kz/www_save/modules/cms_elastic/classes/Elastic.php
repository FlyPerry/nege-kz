<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 12.08.13
 * Time: 14:54
 * To change this template use File | Settings | File Templates.
 */

class Elastic {
    /**
     * @var Elastic
     */
    protected static $instance;
    protected $config;
    protected $client;

    protected function __construct($config){
        $this->config=Kohana::$config->load($config);
        $this->client = new Elastica\Client(array(
            'host'=>$this->config->host,
            'port'=>$this->config->port,
        ));

    }

    protected function __clone(){

    }

    /**
     * @param string $config
     * @return \Elastic
     */
    public static function instance($config='elastic'){
        if (self::$instance==null){
            self::$instance=new self($config);
        }
        return self::$instance;
    }

    public function _setup($func){
        call_user_func($func,$this->client);
    }

    public function _client(){
        return $this->client;
    }

    /**
     * В качесве параметра принимает функцию в которую передаст клиента ElasticSearch
     * @param callable $func
     */
    public static function setup($func){
        self::instance()->_setup($func);
    }

    /**
     * Возвращает клиента
     * @return Elastica\Client
     */
    public static function client(){
        return self::instance()->_client();
    }
}