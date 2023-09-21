<?php defined('SYSPATH') or die('No direct script access.');

class create_user_photo_field extends Migration
{
    public function up()
    {
        $this->add_column('users', 'photo', array(0 => 'integer', 'unsigned' => true));
    }

    public function down()
    {
        $this->remove_column('users', 'photo');
    }
}