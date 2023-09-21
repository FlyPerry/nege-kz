<?php defined('SYSPATH') or die('No direct script access.');

class create_field_shows extends Migration
{
    public function up()
    {
        $this->add_column('banners', 'shows', array('integer', 'default' => 0, 'unsigned' => true));
    }

    public function down()
    {
        $this->remove_column('banners', 'shows');
    }
}