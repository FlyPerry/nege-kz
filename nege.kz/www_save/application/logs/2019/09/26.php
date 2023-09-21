<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2019-09-26 14:34:39 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 14:34:39 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 14:34:45 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 14:34:45 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 14:34:49 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 14:34:49 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 15:06:21 --- EMERGENCY: Elastica\Exception\Connection\HttpException [ 0 ]: Couldn't connect to host, Elasticsearch down? ~ DOCROOT/vendor/ruflin/elastica/lib/Elastica/Transport/Http.php [ 178 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-09-26 15:06:21 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php(171): Elastica\Transport\Http->exec(Object(Elastica\Request), Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Client.php(626): Elastica\Request->send()
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Index.php(514): Elastica\Client->request('newsfeed/news/2...', 'PUT', Array, Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Type.php(519): Elastica\Index->request('news/23', 'PUT', Array, Array)
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Type.php(88): Elastica\Type->request('23', 'PUT', Array, Array)
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/Elastic/Search.php(158): Elastica\Type->addDocument(Object(Elastica\Document))
#6 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/ORM.php(178): Elastic_Search->reindex(Object(Model_News))
#7 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/ORM.php(160): ORM->reindex()
#8 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Controller.php(118): Cms_ORM->save(NULL)
#9 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Admin.php(110): Cms_Controller->_save(Object(Model_News), Array, NULL, NULL)
#10 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Admin.php(391): Cms_Admin->_save(Object(Model_News), Array, NULL)
#11 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Controller.php(84): Cms_Admin->action_edit()
#12 [internal function]: Kohana_Controller->execute()
#13 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Admin_News))
#14 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#15 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#16 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#17 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-09-26 15:09:47 --- EMERGENCY: Elastica\Exception\Connection\HttpException [ 0 ]: Couldn't connect to host, Elasticsearch down? ~ DOCROOT/vendor/ruflin/elastica/lib/Elastica/Transport/Http.php [ 178 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-09-26 15:09:47 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php(171): Elastica\Transport\Http->exec(Object(Elastica\Request), Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Client.php(626): Elastica\Request->send()
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Index.php(514): Elastica\Client->request('newsfeed/news/2...', 'PUT', Array, Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Type.php(519): Elastica\Index->request('news/24', 'PUT', Array, Array)
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Type.php(88): Elastica\Type->request('24', 'PUT', Array, Array)
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/Elastic/Search.php(158): Elastica\Type->addDocument(Object(Elastica\Document))
#6 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/ORM.php(178): Elastic_Search->reindex(Object(Model_News))
#7 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/ORM.php(160): ORM->reindex()
#8 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Controller.php(118): Cms_ORM->save(NULL)
#9 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Admin.php(110): Cms_Controller->_save(Object(Model_News), Array, NULL, NULL)
#10 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Admin.php(391): Cms_Admin->_save(Object(Model_News), Array, NULL)
#11 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Controller.php(84): Cms_Admin->action_edit()
#12 [internal function]: Kohana_Controller->execute()
#13 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Admin_News))
#14 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#15 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#16 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#17 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-09-26 15:59:32 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 15:59:32 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 15:59:56 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 15:59:56 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:35:39 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:35:39 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:35:42 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:35:42 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:35:48 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:35:48 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:35:57 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:35:57 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:36:00 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:36:00 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:36:03 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:36:03 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:36:05 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:36:05 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:37:55 --- EMERGENCY: Elastica\Exception\Connection\HttpException [ 0 ]: Couldn't connect to host, Elasticsearch down? ~ DOCROOT/vendor/ruflin/elastica/lib/Elastica/Transport/Http.php [ 178 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-09-26 16:37:55 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php(171): Elastica\Transport\Http->exec(Object(Elastica\Request), Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Client.php(626): Elastica\Request->send()
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Index.php(514): Elastica\Client->request('newsfeed/news/2...', 'PUT', Array, Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Type.php(519): Elastica\Index->request('news/25', 'PUT', Array, Array)
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Type.php(88): Elastica\Type->request('25', 'PUT', Array, Array)
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/Elastic/Search.php(158): Elastica\Type->addDocument(Object(Elastica\Document))
#6 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/ORM.php(178): Elastic_Search->reindex(Object(Model_News))
#7 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/ORM.php(160): ORM->reindex()
#8 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Controller.php(118): Cms_ORM->save(NULL)
#9 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Admin.php(110): Cms_Controller->_save(Object(Model_News), Array, NULL, NULL)
#10 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Admin.php(391): Cms_Admin->_save(Object(Model_News), Array, NULL)
#11 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Controller.php(84): Cms_Admin->action_edit()
#12 [internal function]: Kohana_Controller->execute()
#13 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Admin_News))
#14 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#15 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#16 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#17 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-09-26 16:38:04 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:38:04 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:38:05 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:38:05 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:38:06 --- EMERGENCY: Elastica\Exception\Connection\HttpException [ 0 ]: Couldn't connect to host, Elasticsearch down? ~ DOCROOT/vendor/ruflin/elastica/lib/Elastica/Transport/Http.php [ 178 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-09-26 16:38:06 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php(171): Elastica\Transport\Http->exec(Object(Elastica\Request), Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Client.php(626): Elastica\Request->send()
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Index.php(514): Elastica\Client->request('newsfeed/news/2...', 'PUT', Array, Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Type.php(519): Elastica\Index->request('news/26', 'PUT', Array, Array)
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Type.php(88): Elastica\Type->request('26', 'PUT', Array, Array)
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/Elastic/Search.php(158): Elastica\Type->addDocument(Object(Elastica\Document))
#6 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/ORM.php(178): Elastic_Search->reindex(Object(Model_News))
#7 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/ORM.php(160): ORM->reindex()
#8 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Controller.php(118): Cms_ORM->save(NULL)
#9 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Admin.php(110): Cms_Controller->_save(Object(Model_News), Array, NULL, NULL)
#10 /var/www/vhosts/carteblanche.kz/nege.kz/www/modules/cms/classes/Cms/Admin.php(391): Cms_Admin->_save(Object(Model_News), Array, NULL)
#11 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Controller.php(84): Cms_Admin->action_edit()
#12 [internal function]: Kohana_Controller->execute()
#13 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Admin_News))
#14 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#15 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#16 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#17 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-09-26 16:38:07 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:38:07 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:38:08 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:38:08 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:38:24 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-09-26 16:38:24 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55