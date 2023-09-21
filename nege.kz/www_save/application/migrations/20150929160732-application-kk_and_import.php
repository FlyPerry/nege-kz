<?php defined('SYSPATH') or die('No direct script access.');

class kk_and_import extends Migration
{
  public function up()
  {
//      $this->drop_foreign_key("media","media_ibfk_1");
//      $this->drop_foreign_key("news","news_ibfk_4");
//      $this->drop_foreign_key("news","news_ibfk_3");
//      $this->drop_foreign_key("news_speakers","news_speakers_ibfk_2");
      $this->add_column("pages","title_kk",array("string[600]"));
      $this->add_column("pages","description_kk",array("mediumtext"));
//      $this->add_index("roles_users","fk_roles_users_role_id",array("role_id"),"normal");
//      $this->add_index("users_categories","category_id_fk",array("category_id"),"normal");

  }

  public function down()
  {
      $this->remove_column("pages","title_kk");
      $this->remove_column("pages","description_kk");

  }
}