<?php defined('SYSPATH') or die('No direct script access.');
if (Kohana::$environment==Kohana::DEVELOPMENT)
{
    return array
    (

        'file' => array(
            'driver'             => 'file',
            'default_expire'     => 3600 * 24 * 7,
            'compression'        => FALSE,
            'servers'            => array(
                'local' => array(
                    'host'             => '127.0.0.1',
                    'port'             => 11211,
                    'persistent'       => FALSE,
                    'weight'           => 1,
                    'timeout'          => 1,
                    'retry_interval'   => 15,
                    'status'           => TRUE,
                ),
            ),
            'instant_death'      => TRUE,
            'statistics'      => FALSE,
        )
    );

}
elseif (Kohana::$environment == Kohana::TESTING) {
    return array
    (

        'file' => array(
            'driver'             => 'file',
            'default_expire'     => 3600 * 24 * 7,
            'compression'        => FALSE,
            'servers'            => array(
                'local' => array(
                    'host'             => 'localhost',
                    'port'             => 11211,
                    'persistent'       => FALSE,
                    'weight'           => 1,
                    'timeout'          => 1,
                    'retry_interval'   => 15,
                    'status'           => TRUE,
                ),
            ),
            'instant_death'      => TRUE,
            'statistics'      => FALSE,
        )
    );

}
else{
    return array
    (

        'file' => array(
            'driver'             => 'file',
            'default_expire'     => 3600 * 24 * 7,
            'compression'        => FALSE,
            'servers'            => array(
                'local' => array(
                    'host'             => '192.168.88.130',
                    'port'             => 11211,
                    'persistent'       => FALSE,
                    'weight'           => 100,
                    'timeout'          => 1,
                    'retry_interval'   => 15,
                    'status'           => TRUE,
                ),
            ),
            'instant_death'      => TRUE,
            'statistics'      => FALSE,
        )
    );

};
