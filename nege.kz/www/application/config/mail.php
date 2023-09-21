<?php defined('SYSPATH') OR die('No direct access allowed.');
/**
 * Created by JetBrains PhpStorm.
 * User: doromor
 * Date: 07.08.13
 * Time: 11:12
 * To change this template use File | Settings | File Templates.
 */
if (Kohana::$environment==Kohana::DEVELOPMENT)
{
    return array(
        'driver'=>'native', //
        'options'=>array(
            'from'=>'noreplay@ligo.kz'
        )
    );
} else {
    return array(
        'driver'=>'smtp', //
        'options'=>array(
            'port'=>25,
            'hostname'=>'localhost',
            'from'=>'info@bnews.kz'
        )
    );
}
