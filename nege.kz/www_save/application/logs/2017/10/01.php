<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2017-10-01 00:42:28 --- EMERGENCY: Database_Exception [ 1045 ]: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost' (using password: NO) ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 59 ] in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 00:42:28 --- DEBUG: #0 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(9): Kohana_Database_PDO->connect()
#1 /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/PDO.php(130): Database_PDO_MySQL->connect()
#2 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(28): Kohana_Database_PDO->query(1, 'SHOW FULL COLUM...', false)
#3 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1665): Database_PDO_MySQL->list_columns('categories')
#4 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(441): Kohana_ORM->list_columns()
#5 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(386): Kohana_ORM->reload_columns()
#6 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(254): Kohana_ORM->_initialize()
#7 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(46): Kohana_ORM->__construct(NULL)
#8 /var/www/newcms.zed.kz/www/application/views/blocks/menu/main_top.php(4): Kohana_ORM::factory('Category')
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#10 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#11 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(228): Kohana_View->render()
#12 /var/www/newcms.zed.kz/www/application/views/errors/404.php(59): Kohana_View->__toString()
#13 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#14 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#15 /var/www/newcms.zed.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#16 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#17 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#18 {main} in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 00:42:33 --- EMERGENCY: Database_Exception [ 1045 ]: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost' (using password: NO) ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 59 ] in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 00:42:33 --- DEBUG: #0 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(9): Kohana_Database_PDO->connect()
#1 /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/PDO.php(130): Database_PDO_MySQL->connect()
#2 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(28): Kohana_Database_PDO->query(1, 'SHOW FULL COLUM...', false)
#3 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1665): Database_PDO_MySQL->list_columns('banners')
#4 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(441): Kohana_ORM->list_columns()
#5 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(386): Kohana_ORM->reload_columns()
#6 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(254): Kohana_ORM->_initialize()
#7 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(46): Kohana_ORM->__construct('1')
#8 /var/www/newcms.zed.kz/www/application/classes/Controller/Redirect.php(21): Kohana_ORM::factory('Banner', '1')
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/Controller.php(84): Controller_Redirect->action_banner()
#10 [internal function]: Kohana_Controller->execute()
#11 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Redirect))
#12 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#13 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#14 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#15 {main} in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 05:57:13 --- EMERGENCY: Database_Exception [ 1045 ]: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost' (using password: NO) ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 59 ] in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 05:57:13 --- DEBUG: #0 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(9): Kohana_Database_PDO->connect()
#1 /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/PDO.php(130): Database_PDO_MySQL->connect()
#2 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(28): Kohana_Database_PDO->query(1, 'SHOW FULL COLUM...', false)
#3 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1665): Database_PDO_MySQL->list_columns('categories')
#4 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(441): Kohana_ORM->list_columns()
#5 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(386): Kohana_ORM->reload_columns()
#6 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(254): Kohana_ORM->_initialize()
#7 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(46): Kohana_ORM->__construct(NULL)
#8 /var/www/newcms.zed.kz/www/application/views/blocks/menu/main_top.php(4): Kohana_ORM::factory('Category')
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#10 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#11 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(228): Kohana_View->render()
#12 /var/www/newcms.zed.kz/www/application/views/errors/404.php(59): Kohana_View->__toString()
#13 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#14 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#15 /var/www/newcms.zed.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#16 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#17 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#18 {main} in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 05:57:17 --- EMERGENCY: Database_Exception [ 1045 ]: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost' (using password: NO) ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 59 ] in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 05:57:17 --- DEBUG: #0 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(9): Kohana_Database_PDO->connect()
#1 /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/PDO.php(130): Database_PDO_MySQL->connect()
#2 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(28): Kohana_Database_PDO->query(1, 'SHOW FULL COLUM...', false)
#3 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1665): Database_PDO_MySQL->list_columns('categories')
#4 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(441): Kohana_ORM->list_columns()
#5 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(386): Kohana_ORM->reload_columns()
#6 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(254): Kohana_ORM->_initialize()
#7 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(46): Kohana_ORM->__construct(NULL)
#8 /var/www/newcms.zed.kz/www/application/classes/Model/News.php(492): Kohana_ORM::factory('Category')
#9 /var/www/newcms.zed.kz/www/application/classes/Controller/Welcome.php(22): Model_News::get_category_news()
#10 /var/www/newcms.zed.kz/www/system/classes/Kohana/Controller.php(84): Controller_Welcome->action_index()
#11 [internal function]: Kohana_Controller->execute()
#12 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Welcome))
#13 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#14 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#15 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#16 {main} in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 12:57:25 --- EMERGENCY: Database_Exception [ 1045 ]: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost' (using password: NO) ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 59 ] in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 12:57:25 --- DEBUG: #0 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(9): Kohana_Database_PDO->connect()
#1 /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/PDO.php(130): Database_PDO_MySQL->connect()
#2 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(28): Kohana_Database_PDO->query(1, 'SHOW FULL COLUM...', false)
#3 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1665): Database_PDO_MySQL->list_columns('categories')
#4 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(441): Kohana_ORM->list_columns()
#5 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(386): Kohana_ORM->reload_columns()
#6 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(254): Kohana_ORM->_initialize()
#7 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(46): Kohana_ORM->__construct(NULL)
#8 /var/www/newcms.zed.kz/www/application/views/blocks/menu/main_top.php(4): Kohana_ORM::factory('Category')
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#10 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#11 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(228): Kohana_View->render()
#12 /var/www/newcms.zed.kz/www/application/views/errors/404.php(59): Kohana_View->__toString()
#13 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#14 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#15 /var/www/newcms.zed.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#16 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#17 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#18 {main} in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 14:21:13 --- EMERGENCY: Database_Exception [ 1045 ]: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost' (using password: NO) ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 59 ] in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 14:21:13 --- DEBUG: #0 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(9): Kohana_Database_PDO->connect()
#1 /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/PDO.php(130): Database_PDO_MySQL->connect()
#2 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(28): Kohana_Database_PDO->query(1, 'SHOW FULL COLUM...', false)
#3 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1665): Database_PDO_MySQL->list_columns('categories')
#4 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(441): Kohana_ORM->list_columns()
#5 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(386): Kohana_ORM->reload_columns()
#6 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(254): Kohana_ORM->_initialize()
#7 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(46): Kohana_ORM->__construct(NULL)
#8 /var/www/newcms.zed.kz/www/application/views/blocks/menu/main_top.php(4): Kohana_ORM::factory('Category')
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#10 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#11 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(228): Kohana_View->render()
#12 /var/www/newcms.zed.kz/www/application/views/errors/404.php(59): Kohana_View->__toString()
#13 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#14 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#15 /var/www/newcms.zed.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#16 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#17 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#18 {main} in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 15:57:32 --- EMERGENCY: Database_Exception [ 1045 ]: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost' (using password: NO) ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 59 ] in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 15:57:32 --- DEBUG: #0 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(9): Kohana_Database_PDO->connect()
#1 /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/PDO.php(130): Database_PDO_MySQL->connect()
#2 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(28): Kohana_Database_PDO->query(1, 'SHOW FULL COLUM...', false)
#3 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1665): Database_PDO_MySQL->list_columns('categories')
#4 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(441): Kohana_ORM->list_columns()
#5 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(386): Kohana_ORM->reload_columns()
#6 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(254): Kohana_ORM->_initialize()
#7 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(46): Kohana_ORM->__construct(NULL)
#8 /var/www/newcms.zed.kz/www/application/views/blocks/menu/main_top.php(4): Kohana_ORM::factory('Category')
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#10 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#11 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(228): Kohana_View->render()
#12 /var/www/newcms.zed.kz/www/application/views/errors/404.php(59): Kohana_View->__toString()
#13 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#14 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#15 /var/www/newcms.zed.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#16 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#17 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#18 {main} in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 21:19:10 --- EMERGENCY: Database_Exception [ 1045 ]: SQLSTATE[28000] [1045] Access denied for user 'root'@'localhost' (using password: NO) ~ MODPATH/database/classes/Kohana/Database/PDO.php [ 59 ] in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9
2017-10-01 21:19:10 --- DEBUG: #0 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(9): Kohana_Database_PDO->connect()
#1 /var/www/newcms.zed.kz/www/modules/database/classes/Kohana/Database/PDO.php(130): Database_PDO_MySQL->connect()
#2 /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php(28): Kohana_Database_PDO->query(1, 'SHOW FULL COLUM...', false)
#3 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(1665): Database_PDO_MySQL->list_columns('categories')
#4 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(441): Kohana_ORM->list_columns()
#5 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(386): Kohana_ORM->reload_columns()
#6 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(254): Kohana_ORM->_initialize()
#7 /var/www/newcms.zed.kz/www/modules/orm/classes/Kohana/ORM.php(46): Kohana_ORM->__construct(NULL)
#8 /var/www/newcms.zed.kz/www/application/views/blocks/menu/main_top.php(4): Kohana_ORM::factory('Category')
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#10 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#11 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(228): Kohana_View->render()
#12 /var/www/newcms.zed.kz/www/application/views/errors/404.php(59): Kohana_View->__toString()
#13 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(61): include('/var/www/newcms...')
#14 /var/www/newcms.zed.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/newcms...', Array)
#15 /var/www/newcms.zed.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#16 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#17 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#18 {main} in /var/www/newcms.zed.kz/www/application/classes/Database/PDO/MySQL.php:9