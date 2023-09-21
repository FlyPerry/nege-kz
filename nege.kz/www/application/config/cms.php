<?php
    return array(
        'modules'=>array(
            'database'=>MODPATH.'database',
            'orm'=>MODPATH.'orm',
            'auth'=>MODPATH.'auth',
//            'clients'=>MODPATH.'clients',
//            'requests'=>MODPATH.'requests',
            'minion'=>MODPATH.'minion',
//            'pagination'=>MODPATH.'pagination',
            'cache'      => MODPATH.'cache',      // Caching with multiple backends
        ),
        'behavior'=>'init', //Определяет поведение модуля, bootstrap инициализация модулей и среды в бутсрапе
                                 //init - инициализация среды и модулей в модуле cms
        'environment'=>array(
            Kohana::PRODUCTION=>array(
                'base_url'=>'/',
                'index_file' => '',
                'errors'=>false,
            ),
            Kohana::DEVELOPMENT=>array(
                'base_url'=>'/',
                'index_file' => '',
                'errors'=>true,
            )
        ),
    );
