<?php defined('SYSPATH') or die('No direct script access.');

class create_storage extends Migration
{
    public function up()
    {
        // $this->create_table
        // (
        //   'table_name',
        //   array
        //   (
        //     'updated_at'          => array('datetime'),
        //     'created_at'          => array('datetime'),
        //   )
        // );

        $this->create_table('storages',
            array(
                'id' => array('integer', 'unsigned' => true),
                'key' => array('string[32]', 'null' => false),
                'name' => array('string[32]', 'null' => false),
                'size' => array('integer', 'null' => false),
                'type' => array('string[25]'),
                'links' => array('integer', 'default' => 0),
                'created' => array("datetime"),
                'updated' => array("datetime"),
                'original_name' => array('string[200]'),
                'dir' => array('string[200]'),
                'parent_id' => array('integer', 'unsigned' => true),
                'tags' => array('text'),
                'is_new' => array('boolean')

            ));

        $this->add_index('storages', 'key_name', array('key', 'name'), 'unique');
        $this->add_index('storages', 'key', array('key'));
        $this->add_index('storages', 'name', array('name'));

        // $this->add_column('table_name', 'column_name', array('datetime', 'default' => NULL));
    }

    public function down()
    {
        $this->drop_table('storages');

        // $this->remove_column('table_name', 'column_name');
    }
}