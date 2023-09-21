<?php defined('SYSPATH') or die('No direct script access.');

class import_and_tv extends Migration
{
  public function up()
  {
////      $this->drop_foreign_key("media","media_ibfk_1");
////      $this->drop_foreign_key("news","news_ibfk_4");
////      $this->drop_foreign_key("news","news_ibfk_3");
////      $this->drop_foreign_key("news_speakers","news_speakers_ibfk_2");
      $this->create_table("tv_news",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"tv_channel_id"=>array(0=>"integer","unsigned"=>TRUE),"lang"=>array(0=>"string[3]","default"=>"ru"),"title"=>array("string[500]"),"sef"=>array(0=>"string[700]","null"=>FALSE),"date"=>array("datetime"),"status"=>array(0=>"integer","unsigned"=>TRUE,"default"=>"1"),"category_id"=>array(0=>"integer","unsigned"=>TRUE),"preview"=>array(0=>"integer","unsigned"=>TRUE)),array("id"));
      $this->add_column("fcategories","old_id",array(0=>"integer","unsigned"=>TRUE));
      $this->add_column("media","old_image",array("string[1000]"));
      $this->add_column("news","old_id",array(0=>"integer","unsigned"=>TRUE));
      $this->add_column("news","old_file",array("string[1000]"));
      $this->add_column("news","tv_channel_id",array(0=>"integer","unsigned"=>TRUE));
      $this->add_column("tv_channels","header",array("string[255]"));
////      $this->add_index("roles_users","fk_roles_users_role_id",array("role_id"),"normal");
////      $this->add_index("users_categories","category_id_fk",array("category_id"),"normal");

  }

  public function down()
  {
//      $this->remove_index("roles_users","fk_roles_users_role_id");
//      $this->remove_index("users_categories","category_id_fk");
      $this->drop_table("tv_news");
//      $this->add_foreign_key("media","news_id","media_ibfk_1","news","id","cascade","no");
//      $this->add_foreign_key("news","region_id","news_ibfk_4","categories","id","cascade","no");
//      $this->add_foreign_key("news","special_id","news_ibfk_3","categories","id","cascade","no");
//      $this->add_foreign_key("news_speakers","news_id","news_speakers_ibfk_2","news","id","cascade","no");
      $this->remove_column("media","old_image");
      $this->remove_column("news","old_id");
      $this->remove_column("news","old_file");
      $this->remove_column("news","tv_channel_id");
      $this->remove_column("fcategories","old_id");
      $this->remove_column("tv_channels","header");

  }
}