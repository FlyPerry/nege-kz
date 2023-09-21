<?php
    return array(
        'modules'=>array(
            'database'=>MODPATH.'database',
            'orm'=>MODPATH.'orm',
            'auth'=>MODPATH.'auth',
            'image'=>MODPATH.'image',
//            'pagination'=>MODPATH.'pagination',
        ),
        'behavior'=>'bootstrap', //Определяет поведение модуля, bootstrap инициализация модулей и среды в бутсрапе
                                 //init - инициализация среды и модулей в модуле cms
        'environment'=>array(
            Kohana::PRODUCTION=>array(
                'base_url'=>'/'
            ),
            Kohana::DEVELOPMENT=>array(
                'base_url'=>'/'
            )
        ),
        'storage'=>array(
            'root'=>'/storage'
        )
    );
