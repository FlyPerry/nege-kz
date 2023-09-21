<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(

	//Enable Web frontend
	'web_frontend' => TRUE,

	//Route path to web frontend
	'web_frontend_route' => 'migrations',

	//Директория для миграций
	'path' => 'migrations',
    'driver'=>"Drivers_Virtual",

);
