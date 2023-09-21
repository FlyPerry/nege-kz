<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Igor Noskov <igor.noskov87@gmail.com>
 * Date: 18.01.12
 * Time: 18:39
 * To change this template use File | Settings | File Templates.
 */
class Helper
{
    /**
     * Определяет в какой среде выполняется кохана
     * @static
     *
     */
    public static function detect_environment()
    {
        if (getenv('KOHANA_ENV')) {
            if (strtoupper(getenv('KOHANA_ENV')) == 'DEVELOPMENT') {
                Kohana::$environment = constant('Kohana::DEVELOPMENT');
            } elseif (strtoupper(getenv('KOHANA_ENV')) == 'TESTING') {
                Kohana::$environment = constant('Kohana::TESTING');
            } else {
                Kohana::$environment = constant('Kohana::PRODUCTION');
            }
            return;
        }
        if (preg_match('/\.dev$/i', Arr::get($_SERVER, 'HTTP_HOST', ''))) {
            Kohana::$environment = constant('Kohana::DEVELOPMENT');
        } else {
            Kohana::$environment = constant('Kohana::PRODUCTION');
        }
    }

    /**
     * Если среда выполенения Kohana::PRODUCTION, то вернет первый аргумент, иначе второй
     * @static
     * @param $production
     * @param $developer
     * @return mixed
     */
    public static function set_if_production($production, $developer)
    {
        return self::is_production() ? $production : $developer;
    }

    /**
     * Вернет TRUE, если среда выполнения Kohana::PRODUCTION
     * @static
     * @return bool
     */
    public static function is_production()
    {
        return Kohana::$environment == Kohana::PRODUCTION;
    }

    /**
     * Возвращает айпи адресс клиента
     * @static
     * @return string
     */
    public static function get_ip_address()
    {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    if (filter_var($ip, FILTER_VALIDATE_IP) !== false) {
                        return $ip;
                    }
                }
            }
        }
    }

    public static function is_link($link)
    {
        if (is_link($link)) return TRUE;
        return !preg_match('/(modules|application|system)/', $link) AND preg_match('/(modules|application|system)/', @readlink($link));
    }

    public static function translit($str)
    {
        $replace = array(
            'а' => 'a',
            'ә' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'ғ' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'й' => 'i',
            'и' => 'i',
            'к' => 'k',
            'қ' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'ң' => 'n',
            'о' => 'o',
            'ө' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ү' => 'u',
            'ұ' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'һ' => 'h',
            'ц' => 'ts',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shch',
            'ъ' => '',
            'ы' => 'i',
            'і' => 'i',
            'ь' => "'",
            'э' => 'e',
            'ю' => 'u',
            'я' => 'ya',
            ' ' => '-',
        );

//        $str = Utf8::substr($str, 0, 50);
        $str = UTF8::strtolower($str);
        $str = strtr($str, $replace);

        $str = preg_replace("/[^a-z0-9_]/i", "_", $str);
        return $str;
    }

    public static function xml_entities($str)
    {
        $str = html_entity_decode($str, ENT_QUOTES, 'UTF-8');
        $str = str_replace(
            array('"', '\'', '&', '<', '>'),
            array('&quot;', '&apos;', '&amp;', '&lt;', '&gt;'),
            $str
        );
        return $str;
    }

    /**
     * TODO это Ajax запрос?
     * @return true / false
     */
    public static function isAjax()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "XMLHttpRequest") ? true : false;
    }

    public static function another_lang()
    {
        if (I18n::$lang == 'kz') {
            return '/ru';
        } else {
            return '/kz';
        }
    }

}
