<?php defined('SYSPATH') or die('No direct script access.');
 
return array(
    'redirect_uri' => URL::site(I18n::$lang,'http'),
    'fields'=>'first_name,last_name',
    'service'=>'vkontakte,odnoklassniki,mailru,facebook',
    'service_h'=>'twitter,google,yandex,livejournal,openid,liveid,youtube'
);