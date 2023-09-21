<?php defined('SYSPATH') or die('No direct script access.');

class create_users_categories_table extends Migration
{
    public function up()
    {
        $this->create_table('users_categories', array(
            'user_id' => array(
                0 => 'integer',
                'null' => false,
                'unsigned' => true
            ),
            'category_id' => array(
                0 => 'integer',
                'null' => false,
                'unsigned' => true
            )

        ), array('user_id', 'category_id'));

        $this->add_foreign_key("users_categories", "user_id", "user_id_fk", "users", "id", "cascade", "no");
        $this->add_foreign_key("users_categories", "category_id", "category_id_fk", "categories", "id", "cascade", "no");
    }

    public function down()
    {
        $this->drop_table('users_categories');
    }
}