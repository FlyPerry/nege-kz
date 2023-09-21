<?php defined('SYSPATH') or die('No direct script access.');

class create_materials_table extends Migration
{
    public function up()
    {
        $this->create_table(
            'materials',
            array
            (
                'id' => array('integer', 'unsigned' => true),
                'title' => array('string[600]', 'null' => false),
                'description' => array('string[1000]', 'null' => false),
                'lang' => array('string[3]', 'default' => 'ru'),
                'date' => array('datetime'),
                'updated_at' => array('datetime'),
                'created_at' => array('datetime'),
                'sef' => array('string[700]'),
                'type' => array('integer', 'unsigned' => true),
                'status' => array('integer', 'unsigned' => true, 'default' => 1),
                'preview' => array('integer', 'unsigned' => true, 'null' => false),
                'content' => array('integer', 'unsigned' => true, 'null' => false)
            )
        );
    }

    public function down()
    {
        $this->drop_table('materials');
    }
}