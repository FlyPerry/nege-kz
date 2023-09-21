<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 28.08.13
 * Time: 10:25
 * Реализация иерархического дерева для моделе поддерживающих интерфейс Cms_Iterface_Tree
 * Поля:
 *  a - Предок
 *  d - Потомок
 *  l - Длина пути от предка к потомку
 */
class Cms_Model_Tree extends ORM {

    protected $_primary_key='a';

    public function factory_self($id=null){
        $name=substr(get_class($this),6);
        return ORM::factory($name)->where('d','=',$id)->where('l','=',0)->find();
    }

    public function insert_node($id,$parent){
        $model=$this->factory_self($id);
        if ($model->loaded()){
            return $this->move_node($id,$parent);
        }

        $insert=$this->insert_node_query();
        DB::query(Database::INSERT,$insert)->bind(':id',$id)->bind(':parent',$parent)->execute();
        return $this->factory_self($id);
    }

    public function remove_node($id,$all=false){
        if ($all){
            $delete=$this->delete_subtree_query();
        } else {
            $delete=$this->delete_node_query();
        }

        DB::query(Database::DELETE,$delete)->bind(':id',$id)->execute();
    }


    public function move_node($id,$parent){
        $model=$this->factory_self($id);
        if (!$model->loaded()){
            return $this->insert_node($id,$parent);
        }
        $dissconect=$this->disconnect_subtree_query();
        $connect=$this->connect_subtree_query();
        DB::query(Database::DELETE,$dissconect)->bind(':id',$id)->execute();
        DB::query(Database::INSERT,$connect)->bind(':id',$id)->bind(':parent',$parent)->execute();
        return $model;
    }

    /**
     * Запрос для вставки нового узла
     * @return string
     */
    protected function insert_node_query(){
        $table=$this->table_name();
        return "
            INSERT INTO $table(a,d,l)
            SELECT t.a, :id, t.l+1
            FROM $table as t
            WHERE t.d=:parent
            UNION ALL
            SELECT :id,:id,0
        ";
    }

    /**
     * Удаляет узел
     * @return string
     */
    protected function delete_node_query(){
        $table=$this->table_name();
        return "
            DELETE
            FROM $table
            WHERE d=:id
        ";
    }

    /**
     * Отсоединяет под дерево
     */
    protected function disconnect_subtree_query(){
        $table=$this->table_name();
        return "
            DELETE a
            FROM
                $table AS a
            JOIN $table AS d ON a.d = d.d
            LEFT JOIN $table AS x ON x.a = d.a
            AND x.d = a.a
            WHERE
                d.a = :id
            AND x.a IS NULL
        ";
    }

    /**
     * Удаляет под дерево
     * @return string
     */
    protected function delete_subtree_query(){
        $table=$this->table_name();
        return "
            DELETE a
            FROM
                $table AS a
            JOIN $table AS d ON a.d = d.d
            LEFT JOIN $table AS x ON x.a = d.a
            AND x.d = a.a
            WHERE
                d.a = :id

        ";
    }

    /**
     * Присоединяет дерево к новому родителю
     * @return string
     */
    protected function connect_subtree_query(){
        $table=$this->table_name();
        return "
            INSERT INTO $table(a,d,l)
            SELECT a.a,b.d,a.l+b.l+1 FROM
                $table a
            JOIN $table b ON b.a=:id
            WHERE a.d=:parent
        ";
    }


}