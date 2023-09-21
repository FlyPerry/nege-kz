<?php
if (Helper::is_production()){
    return array(
        'host'=>'localhost',
        'port'=>'9200'
    );
} else {
    return array(
        'host'=>'192.168.0.107',
        'port'=>'9200'
    );
}
