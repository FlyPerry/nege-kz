<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2019-06-15 17:55:28 --- EMERGENCY: Elastica\Exception\Connection\HttpException [ 0 ]: Couldn't connect to host, Elasticsearch down? ~ DOCROOT/vendor/ruflin/elastica/lib/Elastica/Transport/Http.php [ 178 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-06-15 17:55:28 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php(171): Elastica\Transport\Http->exec(Object(Elastica\Request), Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Client.php(626): Elastica\Request->send()
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Search.php(462): Elastica\Client->request('newsfeed/_searc...', 'GET', Array, Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/Elastic/Search.php(124): Elastica\Search->search()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/Controller/Search.php(53): Elastic_Search->search(Array, '', NULL, 'text', 'ru', 12, 0, Array)
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Controller.php(84): Controller_Search->action_index()
#6 [internal function]: Kohana_Controller->execute()
#7 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Search))
#8 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#9 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#10 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#11 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-06-15 17:55:29 --- EMERGENCY: Elastica\Exception\Connection\HttpException [ 0 ]: Couldn't connect to host, Elasticsearch down? ~ DOCROOT/vendor/ruflin/elastica/lib/Elastica/Transport/Http.php [ 178 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-06-15 17:55:29 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php(171): Elastica\Transport\Http->exec(Object(Elastica\Request), Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Client.php(626): Elastica\Request->send()
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Search.php(462): Elastica\Client->request('newsfeed/_searc...', 'GET', Array, Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/Elastic/Search.php(124): Elastica\Search->search()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/Controller/Search.php(53): Elastic_Search->search(Array, '', NULL, 'text', 'ru', 12, 0, Array)
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Controller.php(84): Controller_Search->action_index()
#6 [internal function]: Kohana_Controller->execute()
#7 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Search))
#8 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#9 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#10 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#11 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-06-15 17:55:30 --- EMERGENCY: Elastica\Exception\Connection\HttpException [ 0 ]: Couldn't connect to host, Elasticsearch down? ~ DOCROOT/vendor/ruflin/elastica/lib/Elastica/Transport/Http.php [ 178 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171
2019-06-15 17:55:30 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php(171): Elastica\Transport\Http->exec(Object(Elastica\Request), Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Client.php(626): Elastica\Request->send()
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Search.php(462): Elastica\Client->request('newsfeed/_searc...', 'GET', Array, Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/Elastic/Search.php(124): Elastica\Search->search()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/Controller/Search.php(53): Elastic_Search->search(Array, '', NULL, 'text', 'ru', 12, 0, Array)
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Controller.php(84): Controller_Search->action_index()
#6 [internal function]: Kohana_Controller->execute()
#7 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client/Internal.php(97): ReflectionMethod->invoke(Object(Controller_Search))
#8 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#9 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#10 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#11 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/vendor/ruflin/elastica/lib/Elastica/Request.php:171