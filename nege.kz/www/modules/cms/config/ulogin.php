<?php defined('SYSPATH') or die('No direct script access.');
 
return array(
    'redirect_uri' => URL::site('/user/login','http'),
    'fields'=>'first_name,last_name',
    'service'=>'vkontakte,odnoklassniki,mailru,facebook,youtube',
    'service_h'=>'twitter,google,yandex,livejournal,openid,liveid'
);