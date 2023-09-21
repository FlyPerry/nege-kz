<?php


use GeoIp2\Database\Reader;

class Weather
{
    private static $instance;

    private $reader;

    private $defaultCityId = 1526273;

    private $openWeatherMapApiKey = 'ecb0c5df8f9aec1484dc21ebd31b4056';

    public function __construct()
    {
        $this->reader = new Reader(DOCROOT . '/geoip.mmdb', ['ru']);
    }

    public static function instance()
    {
        if (self::$instance) {
            return self::$instance;
        }
        self::$instance = new self();
        return self::$instance;
    }

    private function getCity()
    {
        try {
            return $this->reader->city(Request::$client_ip)->city->geonameId;
        } catch (Exception $exception) {
            return $this->defaultCityId;
        }
    }

    public function getW()
    {
        $cityId = $this->getCity();
        $cacheId = 'weather' . $cityId;
        $existsData = Cache::instance()->get($cacheId);
        if ($existsData !== null) {
            return $existsData;
        }
        $data = $this->downloadWeather($cityId);
        Cache::instance()->set($cacheId, $data, 3600);
        return $data;
    }

    private function downloadWeather($cityId)
    {
        $request = Request::factory('https://api.openweathermap.org/data/2.5/weather');
        $request->query('id', $cityId);
        $request->query('appid', $this->openWeatherMapApiKey);
        $request->query('units', 'metric');
        $request->query('lang', 'ru');
        $response = $request->execute();
        if($response->status() == 200) {
            return json_decode($response->body(), true);
        }
        return false;
    }

    public static function get()
    {
        return self::instance()->getW();
    }
}
