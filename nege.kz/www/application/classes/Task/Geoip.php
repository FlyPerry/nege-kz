<?php

class Task_Geoip extends Minion_Task
{
    protected $_options = array(
        'env' => 'PRODUCTION'
    );

    private $key = 'ipwLbmdELPeeSnpJ';

    protected function _execute(array $params)
    {
        @unlink('/tmp/geoip.tar.gz');
        @unlink('/tmp/geoip.tar');
        $url = sprintf('https://download.maxmind.com/app/geoip_download?edition_id=GeoLite2-City&license_key=%s&suffix=tar.gz', $this->key);
        $base = file_get_contents($url);
        file_put_contents('/tmp/geoip.tar.gz', $base);
        (new PharData('/tmp/geoip.tar.gz'))->decompress();
        $path = '/tmp/'.bin2hex(openssl_random_pseudo_bytes(5));
        (new PharData('/tmp/geoip.tar'))->extractTo($path);
        copy(glob($path.'/*/GeoLite2-City.mmdb')[0], DOCROOT.'/geoip.mmdb');
        @unlink($path);
    }
}