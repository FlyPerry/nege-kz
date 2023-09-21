<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 24.06.13
 * Time: 14:56
 * To change this template use File | Settings | File Templates.
 */

class Task_Migration_Install extends Minion_Task{
    protected function _execute(array $params)
    {
        $file=MODPATH.'cms_migrations'.DIRECTORY_SEPARATOR.'migrations.sql';
        $sql=file_get_contents($file);
        try{
            DB::query(Database::INSERT,$sql)->execute();
            Minion_CLI::write(Minion_CLI::color("Ok",'green'));
        } catch (Exception $e){
            Minion_CLI::write(Minion_CLI::color($e->getMessage(),'red'));
        }
    }

}