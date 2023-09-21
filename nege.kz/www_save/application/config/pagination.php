<?php defined('SYSPATH') or die('No direct script access.');

return array(

	// Application defaults
	'default' => array(
		'current_page'      => array('source' => 'route', 'key' => 'page'), // source: "query_string" or "route"
		'total_items'       => 0,
		'items_per_page'    => 10,
		'view'              => 'pagination/floating',
		'auto_hide'         => TRUE,
		'first_page_in_url' => FALSE,
	),
	'news'=>array(
		'current_page'      => array('source' => 'route', 'key' => 'page'), // source: "query_string" or "route"
		'total_items'       => 0,
		'items_per_page'    => 9,
		'view'              => 'pagination/news',
		'auto_hide'         => TRUE,
		'first_page_in_url' => FALSE,
	),
    'search'=>array(
        'current_page'      => array('source' => 'route', 'key' => 'page'), // source: "query_string" or "route"
        'total_items'       => 0,
        'items_per_page'    => 10,
        'view'              => 'pagination/search',
        'auto_hide'         => TRUE,
        'first_page_in_url' => FALSE,
    )

);
