<?php defined('SYSPATH') or die('No direct script access.');

class create_banner_table_fields extends Migration
{
    public function up()
    {
        $this->add_column('banners', 'location', array('integer', 'default' => NULL, 'unsigned' => true));
        $this->add_column('banners', 'lang', array('string[3]', 'default' => 'ru'));
        $this->add_column('banners', 'conversion', array('integer', 'default' => 0, 'unsigned' => true));
        $this->add_column('banners', 'target_blank', array('integer', 'default' => 1, 'unsigned' => true));
    }

    public function down()
    {
        $this->remove_column('banners', 'location');
        $this->remove_column('banners', 'lang');
        $this->remove_column('banners', 'conversion');
        $this->remove_column('banners', 'target_blank');
    }
}