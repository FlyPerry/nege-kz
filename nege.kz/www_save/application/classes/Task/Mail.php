<?php

/**
 * Created by PhpStorm.
 * User: Almas
 * Date: 18.02.2016
 * Time: 12:22
 */
class Task_Mail extends Minion_Task
{

    protected function _execute(array $params)
    {
        set_time_limit(0);
        $mails = ORM::factory('Mail')->where('status', '=', 0)->find_all();
        foreach ($mails as $mail) {
            $email = Email::factory($mail->subject, $mail->text, 'text/html');
            $email->from($mail->from);
            $email->to($mail->to);
            $email->send();
            $mail->status = 1;
            $mail->save();
        }
    }
}