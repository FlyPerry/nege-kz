<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2016-02-25 17:18:19 --- EMERGENCY: Elastica\Exception\Connection\HttpException [ 0 ]: Couldn't connect to host, Elasticsearch down? ~ DOCROOT/vendor/ruflin/elastica/lib/Elastica/Transport/Http.php [ 178 ] in /var/www/newcms.zed.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2016-02-25 17:18:19 --- DEBUG: #0 /var/www/newcms.zed.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php(171): Elastica\Transport\Http->exec(Object(Elastica\Request), Array)
#1 /var/www/newcms.zed.kz/www/vendor/ruflin/elastica/lib/Elastica/Client.php(626): Elastica\Request->send()
#2 /var/www/newcms.zed.kz/www/vendor/ruflin/elastica/lib/Elastica/Search.php(462): Elastica\Client->request('newsfeed/_searc...', 'GET', Array, Array)
#3 /var/www/newcms.zed.kz/www/application/classes/Elastic/Search.php(124): Elastica\Search->search()
#4 /var/www/newcms.zed.kz/www/application/classes/Controller/Search.php(53): Elastic_Search->search(Array, '', NULL, 'text', 'ru', 12, 0, Array)
#5 /var/www/newcms.zed.kz/www/system/classes/Kohana/Controller.php(84): Controller_Search->action_index()
#6 [internal function]: Kohana_Controller->execute()
#7 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Search))
#8 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#10 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#11 {main} in /var/www/newcms.zed.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2016-02-25 17:27:14 --- EMERGENCY: Elastica\Exception\Connection\HttpException [ 0 ]: Couldn't connect to host, Elasticsearch down? ~ DOCROOT/vendor/ruflin/elastica/lib/Elastica/Transport/Http.php [ 178 ] in /var/www/newcms.zed.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2016-02-25 17:27:14 --- DEBUG: #0 /var/www/newcms.zed.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php(171): Elastica\Transport\Http->exec(Object(Elastica\Request), Array)
#1 /var/www/newcms.zed.kz/www/vendor/ruflin/elastica/lib/Elastica/Client.php(626): Elastica\Request->send()
#2 /var/www/newcms.zed.kz/www/vendor/ruflin/elastica/lib/Elastica/Search.php(462): Elastica\Client->request('newsfeed/_searc...', 'GET', Array, Array)
#3 /var/www/newcms.zed.kz/www/application/classes/Elastic/Search.php(124): Elastica\Search->search()
#4 /var/www/newcms.zed.kz/www/application/classes/Controller/Search.php(53): Elastic_Search->search(Array, 'Terras', NULL, 'text', 'ru', 12, 0, Array)
#5 /var/www/newcms.zed.kz/www/system/classes/Kohana/Controller.php(84): Controller_Search->action_index()
#6 [internal function]: Kohana_Controller->execute()
#7 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Search))
#8 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#9 /var/www/newcms.zed.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#10 /var/www/newcms.zed.kz/www/index.php(121): Kohana_Request->execute()
#11 {main} in /var/www/newcms.zed.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171