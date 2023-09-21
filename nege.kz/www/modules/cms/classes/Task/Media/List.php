<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 21.06.13
 * Time: 12:41
 * To change this template use File | Settings | File Templates.
 */

class Task_Media_List extends Minion_Task{

    protected function _execute(array $params)
    {
        Minion_CLI::write(Minion_CLI::color("Список медиа файлов",'green'));
        $tree=$this->create_media_tree($this->dirs());
        $this->tree_iterator($tree);

    }

    /**
     * Формирует отступ для построения списка по стэку директорий
     * @param $arr
     * @return string
     */
    protected function text_padding($arr){
        $num = count($arr);
        if ($num<1){
            return "";
        }
        return implode("\t",array_fill(0, $num,''));
    }

    /**
     * Проверят используется ли файл
     * @param $path
     * @return bool
     */
    protected function is_used($path){
        return is_file(DOCROOT.$path);
    }

    /**
     * Проверяет соотвествие файлов
     * @param $path
     * @param $module
     * @return bool
     */
    protected function is_eq($path,$module){
        $current=DOCROOT.$path;
        $in_module=MODPATH.$module.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR.$path;
        return md5(file_get_contents($current))==md5(file_get_contents($in_module));

    }

    /**
     * Возвращает список используемых модулей
     * @return array
     */
    protected function dirs(){
        return $modules=Kohana::modules();
    }

    /**
     * Строет дерево всех файлов в модулях
     * @param $dirs
     * @return array
     */
    protected function create_media_tree($dirs){
        $total=array();
        foreach ($dirs as $module=>$startpath){
            $ritit = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($startpath), RecursiveIteratorIterator::CHILD_FIRST);
            $r = array();
            /** @var SplFileInfo $splFileInfo */
            foreach ($ritit as $splFileInfo) {
//                Minion_CLI::write($splFileInfo->getFilename());
                if (strpos($splFileInfo->getFilename(),'.')===0){
                    continue;
                }
                $path = $splFileInfo->isDir()
                    ? array($splFileInfo->getFilename() => array())
                    : array($splFileInfo->getFilename());

                for ($depth = $ritit->getDepth() - 1; $depth >= 0; $depth--) {
                    $path = array($ritit->getSubIterator($depth)->current()->getFilename() => $path);
                }
                $r = array_merge_recursive($r, $path);
            }
            $name = rtrim($startpath, DIRECTORY_SEPARATOR);
            $name = explode(DIRECTORY_SEPARATOR,$name);
            $total[array_pop($name)]=$r;
        }
        return $total;

    }

    /**
     * @param $dirs
     * @return bool
     */
    protected function dir_filter($dirs)
    {
        return Arr::get($dirs, 1) == 'media';
    }

    /**
     * @param $padding
     * @param $cur_dir
     */
    protected function next_dir($padding, $cur_dir)
    {
        Minion_CLI::write(Minion_CLI::color($padding . '+' . $cur_dir, 'yellow'));
    }

    /**
     * @param $padding
     * @param $dir
     */
    protected function on_eq_files($padding, $dir)
    {
        Minion_CLI::write(Minion_CLI::color($padding . $dir, 'green'));
    }

    /**
     * @param $padding
     * @param $dir
     */
    protected function on_not_eq_files($padding, $dir)
    {
        Minion_CLI::write(Minion_CLI::color($padding . $dir, 'red'));
    }

    /**
     * @param $padding
     * @param $dir
     */
    protected function on_not_used_files($padding, $dir)
    {
        Minion_CLI::write($padding . $dir);
    }

    /**
     * @param $tree
     */
    protected function tree_iterator($tree)
    {
        $it = new RecursiveIteratorIterator(new RecursiveArrayIterator($tree), RecursiveIteratorIterator::SELF_FIRST);
        $dirs = array();
        $deap = -1;
        $cur_dir = '';
        $padding = '';
        foreach ($it as $key => $dir) {
            if (is_array($dir)) {
                if ($it->getDepth() <= $deap) {
                    while (count($dirs) > $it->getDepth()) {
                        array_pop($dirs);
                    }

                }
                $padding = $this->text_padding($dirs);
                $dirs[] = $key;
                $cur_dir = $key;

                if ($this->dir_filter($dirs)) {
                    $this->next_dir($padding, $cur_dir);
                }
                $padding = $this->text_padding($dirs);
                $deap = $it->getDepth();

                continue;
            }
            if ($it->getDepth() <= $deap) {
                while (count($dirs) > $it->getDepth()) {
                    array_pop($dirs);
                }
                $padding = $this->text_padding($dirs);

            }
            if ($this->dir_filter($dirs)) {
                $relative = array_slice($dirs, 2);
                $path = implode(DIRECTORY_SEPARATOR, $relative) . DIRECTORY_SEPARATOR . $dir;
                if ($this->is_used($path)) {
                    if ($this->is_eq($path, $dirs[0])) {
                        $this->on_eq_files($padding, $dir);
                    } else {
                        $this->on_not_eq_files($padding, $dir);
                    }
                } else {
                    $this->on_not_used_files($padding, $dir);
                }
            }
            $deap = $it->getDepth();
        }
    }

}