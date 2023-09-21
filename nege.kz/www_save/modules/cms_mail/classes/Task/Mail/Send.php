<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 20.08.13
 * Time: 14:41
 * To change this template use File | Settings | File Templates.
 */

class Task_Mail_Send extends Minion_Task{
    protected $_options=array(
        'limit'=>100, //Сколько писем слать за раз
    );

    protected function _execute(array $params)
    {
        $limit=Arr::get($params,'limit');
        $model=ORM::factory('Mail')->where('status','=',0)->limit($limit)->order_by('priority','DESC');
        $collection=$model->find_all();
        foreach ($collection as $mail){
            $email=Email::factory($mail->subject,$mail->text,"text/html");
            $email->from($mail->from);
            $email->to($mail->to);
            try{
                $email->send();
                $mail->delete();
            } catch (Exception $e){
                $mail->status=10;
                $mail->error_text=Kohana_Exception::text($e);
                $mail->save();
            }
        }
    }

}