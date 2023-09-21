<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 24.06.13
 * Time: 10:17
 * To change this template use File | Settings | File Templates.
 */

class Task_Media_Update extends Task_Media_List {
    protected function on_eq_files($padding, $dir)
    {
        return;
    }

    protected function on_not_used_files($padding, $dir)
    {
        return;
    }

    protected function on_not_eq_files($padding, $dir)
    {
        Minion_CLI::write(Minion_CLI::color($dir,'green'));
    }

    protected function next_dir($padding, $cur_dir)
    {
        return;
    }


    protected function is_eq($path, $module)
    {
        $result=parent::is_eq($path, $module);
        //Файлы не равны, нужно заменить
        if (!$result){
            $current=DOCROOT.$path;
            $in_module=MODPATH.$module.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.$path;

            if(unlink($current)){
                if (copy($in_module,$current)){

                } else {
                    Minion_CLI::write(Minion_CLI::color("не удалсь скопировать файл {$in_module}",'red'));
                }
            } else {
                Minion_CLI::write(Minion_CLI::color("не удалсь удалить файл {$current}",'red'));
            }
        }

        return $result;
    }

    protected function _execute(array $params)
    {
        Minion_CLI::write(Minion_CLI::color("Список обновленных файлов",'green'));
        $tree=$this->create_media_tree($this->dirs());
        $this->tree_iterator($tree);

    }


}