<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 04.07.13
 * Time: 17:16
 * To change this template use File | Settings | File Templates.
 */

class Task_Db_Diff extends Minion_Task{
    protected $_options=array(
        'method'=>'up'
    );
    protected function _execute(array $params)
    {
        $migrations = new Flexiblemigrations('config_virtual');
        try
        {
            $model = ORM::factory('Migration');
        }
        catch (Database_Exception $a)
        {
            Minion_CLI::write('Flexible Migrations is not installed. Please Run the migrations.sql script in your mysql server');
            exit();
        }

        $messages = $migrations->migrate(true);

        if (empty($messages)) {
            Minion_CLI::write("Nothing to migrate");
        } else {
            foreach ($messages as $message) {
                if (key($message) == 0) {
                    Minion_CLI::write($message[0]);
                    Minion_CLI::write("OK");
                } else {
                    Minion_CLI::write($message[key($message)]);
                    Minion_CLI::write("ERROR");
                }
            }
            $dump1=Drivers_Virtual::dump();
            $reverse=new Drivers_Reverse_Mysql(Database::instance());
            $reverse->constrains('roles_users');
            $dump2=$reverse->dump();
//            var_dump($dump1,$dump2);
//            var_dump($this->array_key_diff($dump1,$dump2));
            Minion_CLI::write("method = ".Arr::get($params,'method'));
            if (Arr::get($params,'method')=='up')
            {
                $actions=$this->diff($dump2,$dump1);
            } else {
                $actions=$this->diff($dump1,$dump2);
            }
            $this->generate_callable($actions);
        }
    }

    /**
     * Вычисление разницы в ключах $arr1 -> $arr2
     * @param $arr1
     * @param $arr2
     * @return array
     */
    protected function array_key_diff($arr1,$arr2){
        $keys1=array_keys($arr1);
        if (!empty($keys1)){
            $keys1=array_combine($keys1,$keys1);
        }
        $keys2=array_keys($arr2);
        if (!empty($keys2)){
            $keys2=array_combine($keys2,$keys2);
        }
        $keys=$keys1+$keys2;
        $diff=array();
        foreach ($keys as $key){
            if (isset($keys1[$key]) && !isset($keys2[$key])){
                $diff[$key]=1;
            } elseif (!isset($keys1[$key]) && isset($keys2[$key])){
                $diff[$key]=-1;
            } else {
                $diff[$key]=0;
            }
        }
        return $diff;
    }

    protected function diff($dump1,$dump2){
        $actions=array(
            'table'=>array(
                'create'=>array(),
                'drop'=>array(),
            ),
            'fields'=>array(
                'create'=>array(),
                'drop'=>array(),
            ),
            'normal'=>array(
                'create'=>array(),
                'drop'=>array(),
            ),
            'unique'=>array(
                'create'=>array(),
                'drop'=>array(),
            ),
            'fk'=>array(
                'create'=>array(),
                'drop'=>array(),
            )
        );

        $t_diff=$this->array_key_diff($dump1,$dump2);
        $this->combine_actions($actions['table'],$t_diff,$dump1);

        foreach($dump1 as $table=>$params){
            $keys = array("fields", "normal", "unique", "fk");
            if (!isset($dump2[$table]))
            {
                continue;
            }
            foreach($keys as $key){
                $c_diff=$this->array_key_diff($params[$key], $dump2[$table][$key]);
                $this->combine_actions($actions[$key],$c_diff,$params[$key],$table);
            }
        }

        foreach($dump2 as $table=>$params){
            $keys = array("fk");
            if (isset($dump1[$table]))
            {
                continue;
            }
            foreach($keys as $key){
                $c_diff=$this->array_key_diff(array(),$params[$key]);
                $this->combine_actions($actions[$key],$c_diff,$params[$key],$table);
            }
        }



        return $actions;

    }

    /**
     * Заполняе массив действий на основе массива различий
     * @param $action_tree Ветка действий
     * @param $diff Массив различий
     * @param $data Данные для действия
     * @param bool $table Таблица для которой предназначено действие
     */
    protected function combine_actions(&$action_tree,$diff,$data,$table=false){
        foreach ($diff as $key=>$op){
            if ($op==1){
                if ($table===false){
                    $action_tree['create'][$key]=$data[$key];
                } else {
                    $action_tree['create'][$table][$key]=$data[$key];
                }

            }
            if ($op==-1){
                if ($table===false){
                    $action_tree['drop'][$key]=$key;
                } else {
                    $action_tree['drop'][$table][$key]=$key;
                }

            }
        }
    }

    protected function generate_callable($actions){
        $sequense=array();
        $drop_fk=array();
        $drop_column=array();
        $drop_index=array();
        foreach($actions as $section=>$tree){
            if ($section=='table'){
                foreach($tree['drop'] as $name=>$params)
                {
                    $sequense[]=array(array('$this','drop_table'),array($name));
                }
                foreach($tree['create'] as $name=>$params)
                {
                    $sequense[]=array(array('$this','create_table'),array($name,$params['fields'],$params['primary']));
                    $actions['normal']['create'][$name]=$params['normal'];
                    $actions['unique']['create'][$name]=$params['unique'];
                    $actions['fk']['create'][$name]=$params['fk'];

                }
            }
        }
        foreach($actions as $section=>$tree){

            if ($section=='fields'){
                foreach($tree['drop'] as $table=>$columns)
                {
                    foreach($columns as $name=>$options){
                        $drop_column[]=array(array('$this','remove_column'),array($table,$name));
                    }
                }
                foreach($tree['create'] as $table=>$columns)
                {
                    foreach($columns as $name=>$options){
                        $sequense[]=array(array('$this','add_column'),array($table,$name,$options));
                    }

                }
            }

            if ($section=='unique'){
                foreach($tree['drop'] as $table=>$index)
                {
                    foreach($index as $name=>$options){
                        $drop_index[]=array(array('$this','remove_index'),array($table,$name));
                    }
                }
                foreach($tree['create'] as $table=>$index)
                {
                    foreach($index as $name=>$options){
                        $sequense[]=array(array('$this','add_index'),array($table,$name,$options,'unique'));
                    }

                }
            }

            if ($section=='normal'){
                foreach($tree['drop'] as $table=>$index)
                {
                    foreach($index as $name=>$options){
                        $drop_index[]=array(array('$this','remove_index'),array($table,$name));
                    }
                }
                foreach($tree['create'] as $table=>$index)
                {
                    foreach($index as $name=>$options){
                        $sequense[]=array(array('$this','add_index'),array($table,$name,$options,'normal'));
                    }

                }
            }

            if ($section=='fk'){
                foreach($tree['drop'] as $table=>$index)
                {
                    foreach($index as $name=>$options){
                        $drop_fk[]=array(array('$this','drop_foreign_key'),array($table,$name));
                    }
                }
                foreach($tree['create'] as $table=>$index)
                {
                    foreach($index as $name=>$options){
                        // add_foreign_key($table,$field,$name,$fk_table,$fk_field,$on_delete="cascade",$on_update="no")
                        $sequense[]=array(array('$this','add_foreign_key'),
                            array(
                                $table,
                                $options['field'],
                                $name,
                                $options['fk_table'],
                                $options['fk_field'],
                                $options['on_delete'],
                                $options['on_update'],
                            ));
                    }

                }
            }



        }
        $sequense=array_merge($drop_fk,$drop_index,$sequense,$drop_column);//Внешнии ключи в самом начале нужно дропать а поля в конце
        $g=new Code_Generator();
        echo $g->compile_call_array($sequense);
    }



}