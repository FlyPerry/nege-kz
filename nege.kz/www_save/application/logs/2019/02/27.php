<?php defined('SYSPATH') OR die('No direct script access.'); ?>

2019-02-27 12:49:22 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-02-27 12:49:22 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(980): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#6 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-02-27 17:11:41 --- EMERGENCY: ErrorException [ 8 ]: Undefined variable: template_langs ~ APPPATH/views/errors/404.php [ 55 ] in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55
2019-02-27 17:11:41 --- DEBUG: #0 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php(55): Kohana_Core::error_handler(8, 'Undefined varia...', '/var/www/vhosts...', 55, Array)
#1 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(61): include('/var/www/vhosts...')
#2 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/View.php(348): Kohana_View::capture('/var/www/vhosts...', Array)
#3 /var/www/vhosts/carteblanche.kz/nege.kz/www/application/classes/HTTP/Exception/404.php(25): Kohana_View->render()
#4 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client/Internal.php(108): HTTP_Exception_404->get_response()
#5 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request/Client.php(114): Kohana_Request_Client_Internal->execute_request(Object(Request), Object(Response))
#6 /var/www/vhosts/carteblanche.kz/nege.kz/www/system/classes/Kohana/Request.php(990): Kohana_Request_Client->execute(Object(Request))
#7 /var/www/vhosts/carteblanche.kz/nege.kz/www/index.php(121): Kohana_Request->execute()
#8 {main} in /var/www/vhosts/carteblanche.kz/nege.kz/www/application/views/errors/404.php:55