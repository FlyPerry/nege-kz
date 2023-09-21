<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 30.10.12
 * Time: 12:18
 * To change this template use File | Settings | File Templates.
 */
interface IC_Actions
{
    /**
     * Массив доступных действий для указанного юзера
     * @param $user
     * @return mixed
     */
    public function actions($user);
}
