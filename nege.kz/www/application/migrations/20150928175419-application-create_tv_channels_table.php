<?php defined('SYSPATH') or die('No direct script access.');

class create_tv_channels_table extends Migration
{
    public function up()
    {
        $this->create_table(
            'tv_channels',
            array
            (
                'id' => array('integer', 'unsigned' => true),
                'title' => array('string[600]', 'null' => false),
                'description' => array('string[800]', 'null' => false),
                'lang' => array('string[3]', 'default' => 'ru'),
                'updated_at' => array('datetime'),
                'created_at' => array('datetime'),
                'sef' => array('string[700]'),
                'image' => array('integer', 'unsigned' => true)
            )
        );
    }

    public function down()
    {
        $this->drop_table('tv_channels');
    }
}