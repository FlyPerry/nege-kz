<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 05.09.13
 * Time: 14:22
 * To change this template use File | Settings | File Templates.
 */

class Task_Storage_Clean extends Minion_Task{
    protected function _execute(array $params)
    {
        $collection=ORM::factory('Storage')->find_all();
        /** @var Model_Storage $model */
        foreach ($collection as $model){
            if (!file_exists($model->full_path())){
                Minion_CLI::write("Файл не существует: ".$model->id." ".$model->original_name);
                $model->delete();
            }
        }
    }

}