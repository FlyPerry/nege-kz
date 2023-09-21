<?php


class Translator
{
    public static function translate($text)
    {
        if (I18n::$lang === 'kz') {
            return $text;
        }

        $cache = Cache::instance();
        $key = 'translate' . md5($text);
        $cached = $cache->get($key);
        if ($cached) {
            return $cached;
        }
        $request = Request::factory('https://translate.yandex.net/api/v1.5/tr.json/translate');
        $request->query(array(
            'key' => 'trnsl.1.1.20200213T081551Z.6c335c1f0b81fc92.87c5b62271cfdecbb5f017c6f850b1a738877f21',
            'lang' => 'kk-ru'
        ));
        $request->post('text', $text);
        $response = $request->execute();
        $resp = json_decode($response->body(), true);
        $translated = Arr::path($resp, 'text.0', $text);
        $cache->set($key, $translated);
        return $translated;
    }
}