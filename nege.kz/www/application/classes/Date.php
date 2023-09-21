<?php

/**
 * Created by JetBrains PhpStorm.
 * User: Almas
 * Date: 29.01.15
 * Time: 11:28
 * To change this template use File | Settings | File Templates.
 */
class Date extends Kohana_Date
{

    public static function rus_weekdays()
    {
        return array(
            '1' => __('Понедельник'),
            '2' => __('Вторник'),
            '3' => __('Среда'),
            '4' => __('Четверг'),
            '5' => __('Пятница'),
            '6' => __('Суббота'),
            '7' => __('Воскресенье')
        );
    }

    public static function  rus_months()
    {
        return array(
            'full' => array(
                '01' => __('января'),
                '02' => __('февраля'),
                '03' => __('марта'),
                '04' => __('апреля'),
                '05' => __('мая'),
                '06' => __('июня'),
                '07' => __('июля'),
                '08' => __('августа'),
                '09' => __('сентября'),
                '10' => __('октября'),
                '11' => __('ноября'),
                '12' => __('декабря')
            ),
            'single' => array(
                '01' => __('январь'),
                '02' => __('февраль'),
                '03' => __('март'),
                '04' => __('апрель'),
                '05' => __('май'),
                '06' => __('июнь'),
                '07' => __('июль'),
                '08' => __('август'),
                '09' => __('сентябрь'),
                '10' => __('октябрь'),
                '11' => __('ноябрь'),
                '12' => __('декабрь')
            )
        );
    }

    static function weekday($date)
    {
        $day = self::formatted_time($date, 'N');
        $weekdays =  self::rus_weekdays();
        return Arr::get($weekdays,$day);
    }

    static function textdate($date, $format = 'd m Y', $single_month = false)
    {
        $month = date('m', strtotime($date));
        $text_month = self::rus_months();
        $month_reformat = $single_month ? strtr($month, $text_month['single']) : strtr($month, $text_month['full']);
        $format = $single_month ? str_replace('m', '!!!@', $format) : str_replace('m', '!!!', $format);
        $format = __($format);
        $format = str_replace('@', '', $format);
        return str_replace('!!!', $month_reformat, date($format, strtotime($date)));
    }

    public static function filter_date($date, $format = 'Y-m-d')
    {
        if ($date){
            return self::formatted_time($date,$format);
        } else {
            return null;
        }
    }

}