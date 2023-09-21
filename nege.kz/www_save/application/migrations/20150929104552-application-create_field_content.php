<?php defined('SYSPATH') or die('No direct script access.');

class create_field_content extends Migration
{
    public function up()
    {
        $this->add_column('tv_news', 'content', array('string[600]'));
    }

    public function down()
    {
        $this->remove_column('tv_news', 'content');
    }
}