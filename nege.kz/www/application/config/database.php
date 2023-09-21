<?php defined('SYSPATH') or die('No direct access allowed.');
if (Kohana::$environment==Kohana::DEVELOPMENT)
{
    return array
    (

        'default' => array
        (
            'type'       => 'PDO_MySQL',
            'connection' => array(
                /**
                 * The following options are available for MySQL:
                 *
                 * string   hostname     server hostname, or socket
                 * string   database     database name
                 * string   username     database username
                 * string   password     database password
                 * boolean  persistent   use persistent connections?
                 * array    variables    system variables as "key => value" pairs
                 *
                 * Ports and sockets may be appended to the hostname.
                 */
                'dsn'        => 'mysql:host=localhost;dbname=nege_kz',
                'hostname'   => 'localhost',
                'database'   => 'nege_kz',
                'username'   => 'nege_kz_user',
                'password'   => 'h5eJaQxcFGOua0BHekH6',
            ),
            'table_prefix' => '',
            'charset'      => 'utf8',
            'caching'      => false,
            'profiling'    => TRUE,
        ),

    );
}

elseif (Kohana::$environment == Kohana::TESTING) {
    return array
(

    'default' => array
    (
        'type'       => 'PDO_MySQL',
        'connection' => array(
            /**
             * The following options are available for MySQL:
             *
             * string   hostname     server hostname, or socket
             * string   database     database name
             * string   username     database username
             * string   password     database password
             * boolean  persistent   use persistent connections?
             * array    variables    system variables as "key => value" pairs
             *
             * Ports and sockets may be appended to the hostname.
             */
            'dsn'        => 'mysql:host=localhost;dbname=newsfeed',
            'hostname'   => 'localhost',
            'database'   => 'newsfeed',
            'username'   => 'root',
            'password'   => '',
        ),
        'table_prefix' => '',
        'charset'      => 'utf8',
        'caching'      => FALSE,
        'profiling'    => TRUE,
    ),

);
}
else{
    return array
    (

        'default' => array
        (
            'type'       => 'PDO_MySQL',
            'connection' => array(
                /**
                 * The following options are available for MySQL:
                 *
                 * string   hostname     server hostname, or socket
                 * string   database     database name
                 * string   username     database username
                 * string   password     database password
                 * boolean  persistent   use persistent connections?
                 * array    variables    system variables as "key => value" pairs
                 *
                 * Ports and sockets may be appended to the hostname.
                 */
		'dsn'        => 'mysql:host=localhost;dbname=nege_kz',
                'hostname'   => 'localhost',
                'database'   => 'nege_kz',
                'username'   => 'nege_kz_user',
                'password'   => 'h5eJaQxcFGOua0BHekH6',
            ),
            'table_prefix' => '',
            'charset'      => 'utf8',
            'caching'      => true,
            'profiling'    => false,
        ),

    );
}
