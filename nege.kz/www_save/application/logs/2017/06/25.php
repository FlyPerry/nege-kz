<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2017-06-25 16:42:31 --- EMERGENCY: Database_Exception [ 08S01 ]: SQLSTATE[08S01]: Communication link failure: 1153 Got a packet bigger than 'max_allowed_packet' bytes [ SELECT `category`.`id` AS `id`, `category`.`title_ru` AS `title_ru`, `category`.`title_en` AS `title_en`, `category`.`title_kk` AS `title_kk`, `category`.`title_kz` AS `title_kz`, `category`.`description_ru` AS `description_ru`, `category`.`description_en` AS `description_en`, `category`.`description_kz` AS `description_kz`, `category`.`description_kk` AS `description_kk`, `category`.`color` AS `color`, `category`.`position` AS `position`, `category`.`parent_id` AS `parent_id`, `category`.`on_main` AS `on_main`, `category`.`sef` AS `sef`, `category`.`old_id` AS `old_id`, `category`.`show` AS `show`, `category`.`meta_title_ru` AS `meta_title_ru`, `category`.`meta_title_en` AS `meta_title_en`, `category`.`meta_title_kz` AS `meta_title_kz`, `category`.`meta_description_ru` AS `meta_description_ru`, `category`.`meta_description_en` AS `meta_description_en`, `category`.`meta_description_kz` AS `meta_description_kz`, `category`.`meta_keywords_ru` AS `meta_keywords_ru`, `category`.`meta_keywords_en` AS `meta_keywords_en`, `category`.`meta_keywords_kz` AS `meta_keywords_kz` FROM `categories` AS `category` WHERE `on_main` = 1 ORDER BY `position` DESC ] ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 151 ] in /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/Query.php:251
2017-06-25 16:42:31 --- DEBUG: #0 /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/Query.php(251): Kohana_Database_PDO->query(1, 'SELECT `categor...', 'Model_Category', Array)
#1 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1060): Kohana_Database_Query->execute(Object(Database_PDO_MySQL))
#2 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1001): Kohana_ORM->_load_result(true)
#3 /var/www/newcms.zed.kz/www/application/views/blocks/menu/main_top.php(4): Kohana_ORM->find_all()
#4 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#5 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#6 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(228): Kohana_View->render()
#7 /var/www/newcms.zed.kz/www/application/views/errors/404.php(59): Kohana_View->__toString()
#8 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#10 /var/www/newcms.zed.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#11 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#12 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#13 {main} in /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/Query.php:251
2017-06-25 16:42:31 --- EMERGENCY: Database_Exception [ HY000 ]: SQLSTATE[HY000]: General error: 2006 MySQL server has gone away [ SHOW FULL COLUMNS FROM `ads` ] ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 151 ] in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:28
2017-06-25 16:42:31 --- DEBUG: #0 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(28): Kohana_Database_PDO->query(1, 'SHOW FULL COLUM...', false)
#1 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1665): Database_PDO_MySQL->list_columns('ads')
#2 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(441): Kohana_ORM->list_columns()
#3 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(386): Kohana_ORM->reload_columns()
#4 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(254): Kohana_ORM->_initialize()
#5 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(46): Kohana_ORM->__construct(NULL)
#6 /var/www/newcms.zed.kz/www/application/classes/Model/Ad.php(86): Kohana_ORM::factory('Ad')
#7 /var/www/newcms.zed.kz/www/application/views/blocks/ads.php(1): Model_Ad::get_main_ads()
#8 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#10 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(228): Kohana_View->render()
#11 /var/www/newcms.zed.kz/www/application/views/errors/404.php(69): Kohana_View->__toString()
#12 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#13 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#14 /var/www/newcms.zed.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#15 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#16 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#17 {main} in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:28
2017-06-25 23:04:10 --- EMERGENCY: Database_Exception [ 08S01 ]: SQLSTATE[08S01]: Communication link failure: 1153 Got a packet bigger than 'max_allowed_packet' bytes [ SELECT `category`.`id` AS `id`, `category`.`title_ru` AS `title_ru`, `category`.`title_en` AS `title_en`, `category`.`title_kk` AS `title_kk`, `category`.`title_kz` AS `title_kz`, `category`.`description_ru` AS `description_ru`, `category`.`description_en` AS `description_en`, `category`.`description_kz` AS `description_kz`, `category`.`description_kk` AS `description_kk`, `category`.`color` AS `color`, `category`.`position` AS `position`, `category`.`parent_id` AS `parent_id`, `category`.`on_main` AS `on_main`, `category`.`sef` AS `sef`, `category`.`old_id` AS `old_id`, `category`.`show` AS `show`, `category`.`meta_title_ru` AS `meta_title_ru`, `category`.`meta_title_en` AS `meta_title_en`, `category`.`meta_title_kz` AS `meta_title_kz`, `category`.`meta_description_ru` AS `meta_description_ru`, `category`.`meta_description_en` AS `meta_description_en`, `category`.`meta_description_kz` AS `meta_description_kz`, `category`.`meta_keywords_ru` AS `meta_keywords_ru`, `category`.`meta_keywords_en` AS `meta_keywords_en`, `category`.`meta_keywords_kz` AS `meta_keywords_kz` FROM `categories` AS `category` WHERE `on_main` = 1 ORDER BY `position` DESC ] ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 151 ] in /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/Query.php:251
2017-06-25 23:04:10 --- DEBUG: #0 /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/Query.php(251): Kohana_Database_PDO->query(1, 'SELECT `categor...', 'Model_Category', Array)
#1 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1060): Kohana_Database_Query->execute(Object(Database_PDO_MySQL))
#2 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1001): Kohana_ORM->_load_result(true)
#3 /var/www/newcms.zed.kz/www/application/views/blocks/menu/main_top.php(4): Kohana_ORM->find_all()
#4 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#5 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#6 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(228): Kohana_View->render()
#7 /var/www/newcms.zed.kz/www/application/views/errors/404.php(59): Kohana_View->__toString()
#8 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#10 /var/www/newcms.zed.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#11 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#12 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#13 {main} in /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/Query.php:251
2017-06-25 23:04:10 --- EMERGENCY: Database_Exception [ HY000 ]: SQLSTATE[HY000]: General error: 2006 MySQL server has gone away [ SHOW FULL COLUMNS FROM `ads` ] ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 151 ] in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:28
2017-06-25 23:04:10 --- DEBUG: #0 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(28): Kohana_Database_PDO->query(1, 'SHOW FULL COLUM...', false)
#1 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1665): Database_PDO_MySQL->list_columns('ads')
#2 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(441): Kohana_ORM->list_columns()
#3 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(386): Kohana_ORM->reload_columns()
#4 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(254): Kohana_ORM->_initialize()
#5 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(46): Kohana_ORM->__construct(NULL)
#6 /var/www/newcms.zed.kz/www/application/classes/Model/Ad.php(86): Kohana_ORM::factory('Ad')
#7 /var/www/newcms.zed.kz/www/application/views/blocks/ads.php(1): Model_Ad::get_main_ads()
#8 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#10 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(228): Kohana_View->render()
#11 /var/www/newcms.zed.kz/www/application/views/errors/404.php(69): Kohana_View->__toString()
#12 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#13 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#14 /var/www/newcms.zed.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#15 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#16 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#17 {main} in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:28