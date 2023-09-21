<?php

class ORM extends Cms_ORM
{

    public static $_model_langs = array('ru'=>'Рус','kz'=>'Каз');

    public static function latin($s, $reverse = false)
    {
        $arr_in = array('/kk/', 'Ә', 'Ө', 'Ү', 'Ұ', 'Ң', 'Ғ', 'Қ', 'Һ', 'ә', 'ө', 'ү',
            'ұ', 'ң', 'ғ', 'қ', 'һ', "А", "а", "Ә", "ә", "Б", "б", "В", "в", "Г", "г", "Ғ", "ғ", "Д", "д", "Е", "е",
            "Ё", "ё", "Ж", "ж", "З", "з", "И", "и", "Й", "й", "К", "к", "Қ", "қ", "Л", "л", "М", "м", "Н", "н", "Ң", "ң", "О", "о", "Ө", "ө", "П",
            "п", "Р", "р", "С", "с", "Т", "т", "У", "у", "Ұ", "ұ", "Ү", "ү", "Ф", "ф", "Х", "х", "Һ", "һ", "Ц", "ц", "Ч", "ч", "Ш", "ш", "Щ", "щ",
            "ъ", "Ъ", "Ы", "ы", "І", "і", "ь", "Ь", "Э", "э", "Ю", "ю", "Я", "я");

        $arr_out = array('/la/', 'Ә', 'Ө', 'Ү', 'Ұ', 'Ң', 'Ғ', 'Қ', 'Һ', 'ә', 'ө', 'ү', 'ұ', 'ң', 'ғ', 'қ', 'һ', "A", "a", "Ä", "ä", "B", "b", "V", "v", "G",
            "g", "Ğ", "ğ", "D", "d", "E", "e", "Yo", "yo", "J", "j", "Z", "z", "Ï", "ï", "Y`", "y`", "K", "k", "Q", "q", "L", "l", "M", "m", "N",
            "n", "Ñ", "ñ", "O", "o", "Ö", "ö", "P", "p", "R", "r", "S", "s", "T", "t", "W", "w", "U", "u", "Ü", "ü", "F", "f", "X", "x", "H", "h",
            "C", "c", "Ç", "ç", "Ş", "ş", "Şş", "şş", "ʺ", "ʺ", "I", "ı", "İ", "i", "ʹ", "ʹ", "É", "é", "Yu", "yu", "Ya", "ya");

        if ($reverse){
            foreach ($arr_out as $k => $v) {
                $s = str_replace($v, $arr_in[$k], $s);
            }
        }
        else{
            foreach ($arr_in as $k => $v) {
                $s = str_replace($v, $arr_out[$k], $s);
            }
        };


        return $s;
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
            'ь' => "",
            'э' => 'e',
            'ю' => 'u',
            'я' => 'ya',
            ' ' => '_',
        );

//        $str = Utf8::substr($str, 0, 50);
        $str = UTF8::strtolower($str);
        $str = strtr($str, $replace);
        $str = trim($str);
        $str = preg_replace("/[^\w0-9_']/i", "", $str);
        $str = trim($str, "_");
        return $str;
    }




    public function select_keys($id = 'id', $order_field = 'id', $order_direction = 'asc')
    {
        $selected_options = array_keys($this->select_options($id, $order_field, $order_direction));
        return array_map('strval', $selected_options);
    }


    public function as_array_ext($fields = array(),$action = null){
        $object = array();

        $fields_description = $this->fields_description();
        $fields_description = count($fields_description)>0?$fields_description:$this->_object;
        foreach ($fields_description as $column => $value)
        {
            if(count($fields) && in_array($column,$fields)){
                // Call __get for any user processing
                $object[$column] = $this->get_field($column);
            }elseif(count($fields)==0){
                $object[$column] = $this->get_field($column);
            }

        }
        return $object;
    }

    public function date()
    {
        if ($this->loaded()) {
            return Date::formatted_time($this->date, 'd.m.y');
        };
        return '';
    }

    public static function filter_sef($value, $model, $field)
    {
        if ($value == '') {
            $value = ORM::translit($model->$field).'_'.date('YmdHis');
        }
        return $value;
    }

    public function ordinal_date()
    {
        if ($this->loaded()) {
//            if(Date::formatted_time($this->date,'Y')<Date::formatted_time('now','Y')){
                $date = explode(' ', date('Y d m H:i', strtotime($this->date)));
                list($year, $day, $month, $time) = $date;
            if (I18n::$lang == 'en'){
                return sprintf('%d %s %d %s', $day, $this->ordinal_month_name($month), $year, $time);
            }
                return sprintf('%d %s %d %s %s', $day, $this->ordinal_month_name($month),$year, __("г"), $time);
//            }else{
//                $date = explode(' ', date('d m H:i', strtotime($this->date)));
//                list($day, $month, $time) = $date;
//                return sprintf('%d %s,  %s', $day, $this->ordinal_month_name($month), $time);
//            }

        };
        return '';
    }


    public function ordinal_month_name($month)
    {
        return __(Arr::get(explode(' ', self::$ordinal_months), $month - 1));
    }


    public static $ordinal_months = 'января февраля марта апреля мая июня июля августа сентября октября ноября декабря';


    public static $langs = array(
        'ru' => 'ru',
        'en' => 'en',
        'kz' => 'kz',
        'kk' => 'kk'
    );



    public function reindex() {
//        try {
            Elastic_Search::instance()->reindex($this);
//        }
//        catch (Exception $e) {

//        }
        return $this;
    }

    public function get_thumbnail($uri)
    {
        if (strpos($this->video, 'youtu') !== false) {
            $id = array();
            if (stripos($this->video, 'youtube.com') !== false) {
                preg_match('#v=([^\&?]+)#is', $this->video, $id);
            }
            if (strpos($this->video, 'youtube.com/embed') !== false) {
                preg_match('#embed\/([^\&?]+)#is', $this->video, $id);
            }
            if (stripos($this->video, 'youtu.be') !== false) {
                preg_match('#\youtu.be/([^\&?]+)#is', $this->video, $id);
            }
            if (count($id) > 0) {
                $value = "http://img.youtube.com/vi/$id[1]/hqdefault.jpg";
                return $value;
            }
        }
        return URL::site($uri, 'http');
    }

}
