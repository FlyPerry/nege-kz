<?php defined('SYSPATH') or die('No direct script access.');

class news_add_field_region extends Migration
{
  public function up()
  {
//      $this->create_table("news_import",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"title"=>array(0=>"string[600]","null"=>FALSE),"link"=>array("string[500]"),"sef"=>array("string[700]"),"description"=>array("mediumtext"),"text"=>array("mediumtext"),"parent_id"=>array(0=>"integer","unsigned"=>TRUE),"position"=>array("integer"),"date"=>array("datetime"),"updated_at"=>array("datetime"),"created_at"=>array("datetime"),"status"=>array("boolean"),"category_id"=>array(0=>"integer","unsigned"=>TRUE),"lang"=>array(0=>"string[3]","default"=>"ru"),"main"=>array("integer"),"key"=>array("integer"),"author_id"=>array(0=>"integer","unsigned"=>TRUE),"author_name"=>array("string[500]"),"views"=>array(0=>"integer","unsigned"=>TRUE),"redactor_id"=>array(0=>"integer","unsigned"=>TRUE),"chosen"=>array("integer"),"allow_comments"=>array(0=>"integer","default"=>"1"),"meta_title"=>array("string[500]"),"meta_description"=>array("text"),"meta_keywords"=>array("text"),"file"=>array(0=>"integer","unsigned"=>TRUE),"photo_place"=>array("string[500]"),"photo_author"=>array("string[500]"),"main_time_start"=>array("datetime"),"main_time_end"=>array("datetime"),"type"=>array(0=>"integer","unsigned"=>TRUE),"tags"=>array("string[1000]"),"video"=>array("string[500]"),"comments"=>array("integer"),"linked"=>array(0=>"integer","unsigned"=>TRUE),"reporter"=>array(0=>"boolean","null"=>FALSE,"unsigned"=>TRUE),"sub_main"=>array("boolean"),"anal"=>array("integer")),array("id"));
      $this->add_column("categories","title_kk",array("string[500]"));
      $this->add_column("categories","old_id",array(0=>"integer","unsigned"=>TRUE));
      $this->add_column("news","region",array("string[1000]"));
//      $this->add_index("roles_users","fk_roles_users_role_id",array("role_id"),"normal");
//      $this->add_index("users_categories","category_id_fk",array("category_id"),"normal");
//      $this->add_index("news_import","category_id",array("category_id"),"normal");
//      $this->add_index("news_import","linked",array("linked"),"normal");
//      $this->add_foreign_key("news_import","linked","news_import_ibfk_1","news","id","null","no");
//      $this->add_foreign_key("news_import","category_id","news_import_ibfk_2","categories","id","cascade","no");

  }

  public function down()
  {
//      $this->drop_foreign_key("news_import","news_import_ibfk_1");
//      $this->drop_foreign_key("news_import","news_import_ibfk_2");
//      $this->remove_index("roles_users","fk_roles_users_role_id");
//      $this->remove_index("users_categories","category_id_fk");
//      $this->drop_table("news_import");
      $this->remove_column("categories","title_kk");
      $this->remove_column("categories","old_id");
      $this->remove_column("news","region");

  }
}