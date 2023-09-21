<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 05.07.13
 * Time: 9:43
 * To change this template use File | Settings | File Templates.
 */

class Drivers_Reverse_Mysql extends Drivers_Reverse{
    protected $tables;

    public function dump()
    {
        $tables=$this->tables();
        foreach ($tables as $row) {
            $name = array_pop($row);
            if ($name=='migrations')
                continue;
            $this->tables[$name]=array('fields'=>array(),'fk'=>array(),'primary'=>array());
            foreach ($this->columns($name) as $column){
                $this->tables[$name]['fields'][$column->Field]=$this->column_options($column);
            }
            $this->tables[$name]['fk']=$this->constrains($name);
            $this->tables[$name]['primary']=$this->primary($name);
            $this->tables[$name]['unique']=$this->unique($name);
            $this->tables[$name]['normal']=$this->normal($name);
        }
        return $this->tables;
    }

    public function tables(){
        $q="SHOW TABLES";
        return DB::query(Database::SELECT,$q)->execute($this->db);
    }

    public function columns($table){
        $q="SHOW COLUMNS FROM $table";
        return DB::query(Database::SELECT,$q)->as_object()->execute($this->db);
    }

    public function column_options($column){
        $params = array($this->migration_type($column->Type));

        if ($column->Null == 'NO')
            $params['null'] = FALSE;
        if (preg_match('/unsigned/',$column->Type))
            $params['unsigned']=TRUE;

        if ($column->Default)
            $params['default'] = $column->Default;

        if ($column->Extra == 'auto_increment')
            $params['auto'] = TRUE;

        return $params;
    }




    public function constrains($table){
        $creation=$this->table_creation($table);
        $sql=$creation['Create Table'];
        $constraints=array();
        foreach (explode("\n",$sql) as $row){
            if (preg_match('/CONSTRAINT `(.+?)` FOREIGN KEY \(`(.+?)`\) REFERENCES `(.+?)` \(`(.+?)`\) ON DELETE (.+?) ON UPDATE (.+?)[,]?$/i',$row,$match)){
                $constraints[$match[1]]=array(
                    'field'=>$match[2],
                    'fk_table'=>$match[3],
                    'fk_field'=>$match[4],
                    'on_delete'=>$this->foreign_key_action($match[5]),
                    'on_update'=>$this->foreign_key_action($match[6])
                );
            }
        }
       return $constraints;
    }

    public function primary($table){
        $creation=$this->table_creation($table);
        $sql=$creation['Create Table'];
        $primary=array();
        foreach (explode("\n",$sql) as $row){
            if (preg_match('/PRIMARY KEY \((.+)\)/i',$row,$match)){
                $keys=explode(',',$match[1]);
                foreach ($keys as &$key){
                    $key=trim($key,'`');
                }
                $primary=$keys;
                break;
            }
        }
        return $primary;
    }

    public function unique($table){
        $creation=$this->table_creation($table);
        $sql=$creation['Create Table'];
        $unique=array();
        foreach (explode("\n",$sql) as $row){
            if (preg_match('/UNIQUE KEY `(.+?)` \((.+)\)/i',$row,$match)){
                $keys=explode(',',$match[2]);
                foreach ($keys as &$key){
                    $key=trim($key,'`');
                }
                $unique[$match[1]]=$keys;
//                break;
            }
        }
        return $unique;
    }

    public function normal($table){
        $creation=$this->table_creation($table);
        $sql=$creation['Create Table'];
        $normal=array();
        foreach (explode("\n",$sql) as $row){
            if (preg_match('/KEY `(.+?)` \((.+)\)/i',$row,$match)){
                if (preg_match('/UNIQUE/i',$row))
                    continue;
                $keys=explode(',',$match[2]);
                foreach ($keys as &$key){
                    $key=trim($key,'`');
                }
                $normal[$match[1]]=$keys;
//                break;
            }
        }
        return $normal;
    }

    protected function foreign_key_action($action){
        switch($action){
            case "CASCADE":return "cascade";
            case "SET NULL": return "null";
            case "RESTRICT": return "restrict";
            default: return "no";
        }
    }

    protected function table_creation($table){
        $q="SHOW CREATE TABLE $table";
        return DB::query(Database::SELECT,$q)->execute($this->db)->current();
    }

}