<?php defined('SYSPATH') or die('No direct script access.');

class news_add_main_fields extends Migration
{
    public function up()
    {
        $this->add_column('news', 'main_in_special', array('integer', 'default' => 0, 'unsigned' => true));
        $this->add_column('news', 'main_in_cat', array('integer', 'default' => 0, 'unsigned' => true));
    }

    public function down()
    {
        $this->remove_column('news', 'main_in_special');
        $this->remove_column('news', 'main_in_cat');
    }
}