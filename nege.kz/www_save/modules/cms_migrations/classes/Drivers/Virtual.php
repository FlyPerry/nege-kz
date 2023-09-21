<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 04.07.13
 * Time: 16:43
 * To change this template use File | Settings | File Templates.
 */

class Drivers_Virtual extends Drivers_Driver{
    protected static $tables=array();
    /**
     * Create Table
     *
     * Creates a new table
     *
     * $fields:
     *
     *        Associative array containing the name of the field as a key and the
     *        value could be either a string indicating the type of the field, or an
     *        array containing the field type at the first position and any optional
     *        arguments the field might require in the remaining positions.
     *        Refer to the TYPES function for valid type arguments.
     *        Refer to the FIELD_ARGUMENTS function for valid optional arguments for a
     *        field.
     *
     * @example
     *
     *        create_table (
     *            'blog',
     *            array (
     *                'title' => array ( 'string[50]', 'default' => "The blog's title." ),
     *                'date' => 'date',
     *                'content' => 'text'
     *            )
     *        )
     *
     * @param    string   Name of the table to be created
     * @param    array
     * @param    mixed    Primary key, false if not desired, not specified sets to 'id' column.
     *                   Will be set to auto_increment by default.
     * @return    boolean
     */
    public function create_table($table_name, $fields, $primary_key = TRUE)
    {
        self::$tables[$table_name]=array("fields"=>array(),"normal"=>array(),"unique"=>array(),"fk"=>array());
        self::$tables[$table_name]['fields']=$fields;
        self::$tables[$table_name]['primary']=array();
        if ($primary_key===TRUE){
            self::$tables[$table_name]['primary']=array('id');
        }
    }

    /**
     * Drop a table
     *
     * @param string    Name of the table
     * @return boolean
     */
    public function drop_table($table_name)
    {
        unset(self::$tables[$table_name]);
    }

    /**
     * Rename a table
     *
     * @param   string    Old table name
     * @param   string    New name
     * @return  boolean
     */
    public function rename_table($old_name, $new_name)
    {
        self::$tables[$old_name]=self::$tables[$new_name];
        unset(self::$tables[$old_name]);
    }

    /**
     * Add a column to a table
     *
     * @example add_column ( "the_table", "the_field", array('string[25]', 'null' => FALSE) );
     * @example add_coumnn ( "the_table", "int_field", "integer" );
     *
     * @param   string  Name of the table
     * @param   string  Name of the column
     * @param   array   Column arguments array, or just a type for a simple column
     * @return  bool
     */
    public function add_column($table_name, $column_name, $params)
    {
        self::$tables[$table_name]['fields'][$column_name]=$params;
    }

    /**
     * Rename a column
     *
     * @param   string  Name of the table
     * @param   string  Name of the column
     * @param   string  New name
     * @return  bool
     */
    public function rename_column($table_name, $column_name, $new_column_name, $params)
    {
        self::$tables[$table_name]['fields'][$new_column_name]=self::$tables[$table_name]['fields'][$column_name];
        unset(self::$tables[$table_name]['fields'][$column_name]);
    }

    /**
     * Alter a column
     *
     * @param   string  Table name
     * @param   string  Columnn ame
     * @param   string  New column type
     * @param   array   Column argumetns
     * @return  bool
     */
    public function change_column($table_name, $column_name, $params)
    {
        self::$tables[$table_name]['fields'][$column_name]=$params;
    }

    /**
     * Remove a column from a table
     *
     * @param   string  Name of the table
     * @param   string  Name of the column
     * @return  bool
     */
    public function remove_column($table_name, $column_name)
    {
        unset(self::$tables[$table_name]['fields'][$column_name]);
    }

    /**
     * Add an index
     *
     * @param   string  Name of the table
     * @param   string  Name of the index
     * @param   string|array Name(s) of the column(s)
     * @param   string  Type of the index (unique/normal/primary)
     * @return  bool
     */
    public function add_index($table_name, $index_name, $columns, $index_type = 'normal')
    {
        self::$tables[$table_name][$index_type]=isset(self::$tables[$table_name][$index_type])?self::$tables[$table_name][$index_type]:array();
        self::$tables[$table_name][$index_type][$index_name]=$columns;
    }

    /**
     * Remove an index
     *
     * @param   string  Name of the table
     * @param   string  Name of the index
     * @return  bool
     */
    public function remove_index($table_name, $index_name)
    {
        if (isset(self::$tables[$table_name]['normal'][$index_name])){
            unset(self::$tables[$table_name]['normal'][$index_name]);
        }
        if (isset(self::$tables[$table_name]['unique'][$index_name])){
            unset(self::$tables[$table_name]['unique'][$index_name]);
        }
    }

    public function add_foreign_key($table, $field, $name, $fk_table, $fk_field, $on_delete = "cascade", $on_update = "no")
    {
        self::$tables[$table]['fk']=isset(self::$tables[$table]['fk'])?self::$tables[$table]['fk']:array();
        self::$tables[$table]['fk'][$name]=array(
            'field'=>$field,
            'fk_table'=>$fk_table,
            'fk_field'=>$fk_field,
            'on_delete'=>$on_delete,
            'on_update'=>$on_update
        );
    }

    public function drop_foreign_key($table,$name){
        unset(self::$tables[$table]['fk'][$name]);
    }

    public function run_query($sql)
    {
        //stub
    }

    public static function  dump(){
       return self::$tables;
    }

    public function insert_data($table,$fields,$values){
        //stub
    }

}