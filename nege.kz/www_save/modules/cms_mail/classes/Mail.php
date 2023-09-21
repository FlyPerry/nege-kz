<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 20.08.13
 * Time: 14:36
 * To change this template use File | Settings | File Templates.
 */

class Mail {
    /**
     * Создает новое письмо для отправки
     * @param $from
     * @param $to
     * @param $subject
     * @param $text
     * @param int $priority
     * @return mixed Возвращает id созданного письма, чтобы его можно было отследить в дальнейшем
     */
    public static function create($from,$to,$subject,$text,$priority=0){
        $model=ORM::factory("Mail");
        $model->from=$from;
        $model->to=$to;
        $model->subject=$subject;
        $model->text=$text;
        $model->priority=$priority;
        $model->save();
        return $model->id;
    }
}