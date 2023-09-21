<?php

/**
 * Created by PhpStorm.
 * User: Almas
 * Date: 18.02.2016
 * Time: 12:22
 */
class Task_News extends Minion_Task
{

    protected $_langs = array('ru', 'kz');
    protected $_options = array(
        'env' => 'PRODUCTION'
    );

    protected function _execute(array $params)
    {
        Kohana::$environment = constant('Kohana::' . strtoupper(Arr::get($params, 'env')));
        if (Kohana::$environment == 'DEVELOPMENT') {

        } else {
            $_SERVER['SERVER_NAME'] = 'birkun.zed.kz';
        }
        set_time_limit(0);

        $day_ago_ts = strtotime("-1 day");
        $day_ago_stamp = date("Y-m-d H:i", $day_ago_ts);
        $today_stamp = date("Y-m-d H:i", time());
        $i = 0;
        foreach ($this->_langs as $lang) {
            $news = ORM::factory('News')
                ->where('lang', '=', $lang)
                ->where('status', '=', 1)
                ->where('date', 'between', array($day_ago_stamp, $today_stamp))
                ->order_by('views', 'DESC')
                ->limit(5)
                ->find_all();
            $subscribes = ORM::factory('Subscribe')
                ->where('lang', '=', $lang)
                ->find_all();
            if ($news->count() > 1) {
                foreach ($subscribes as $subscribe) {
                    $view = View::factory('subscribe')
                        ->bind('news', $news)
                        ->bind('subscribe', $subscribe);

                    $mail = ORM::factory('Mail');
                    $mail->subject = 'NewsFeeds. Популярные новости за ' . Date::textdate('Now', 'd m Y');
                    $mail->from = 'NewsFeeds.kz';
                    $mail->to = $subscribe->email;
                    $mail->text = $view->render();
                    $mail->save();
                    $i++;
                }
            }
        }

        if ($i != 1) {
            Minion_CLI::write($i . ' letters have been created');
        } else {
            Minion_CLI::write($i . ' letter has been created');
        }
    }
}