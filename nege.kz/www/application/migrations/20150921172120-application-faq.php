<?php defined('SYSPATH') or die('No direct script access.');

class faq extends Migration
{
  public function up()
  {
      $this->create_table("faq",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"lang"=>array("string[255]"),"title"=>array("string[500]"),"text"=>array("mediumtext"),"fcategory_id"=>array(0=>"integer","unsigned"=>TRUE),"user_id"=>array(0=>"integer","unsigned"=>TRUE),"expert_id"=>array(0=>"integer","unsigned"=>TRUE),"question_date"=>array("datetime"),"answer_date"=>array("datetime"),"answer"=>array("longtext"),"published"=>array(0=>"integer","null"=>FALSE,"default"=>"1"),"views"=>array(0=>"integer","null"=>FALSE)),array("id"));
      $this->create_table("fcategories",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"lang"=>array("string[255]"),"title"=>array("string[500]"),"sef"=>array("string[500]")),array("id"));
      $this->add_column("news","linked",array(0=>"integer","unsigned"=>TRUE));
      $this->add_index("news","linked",array("linked"),"normal");
      $this->add_index("faq","user_id",array("user_id"),"normal");
      $this->add_index("faq","expert_id",array("expert_id"),"normal");
      $this->add_index("faq","fcategory_id",array("fcategory_id"),"normal");
      $this->add_foreign_key("news","linked","news_ibfk_2","news","id","null","no");

  }

  public function down()
  {
//      $this->drop_foreign_key("roles_users","roles_users_ibfk_1");
//      $this->drop_foreign_key("roles_users","roles_users_ibfk_2");
      $this->drop_foreign_key("news","news_ibfk_2");
//      $this->remove_index("roles_users","fk_roles_users_role_id");
      $this->remove_index("news","linked");
      $this->drop_table("faq");
      $this->drop_table("fcategories");
//      $this->add_foreign_key("roles_users","user_id","fk_roles_users_user_id","users","id","cascade","no");
//      $this->add_foreign_key("roles_users","role_id","fk_roles_users_role_id","roles","id","cascade","no");
      $this->remove_column("news","linked");

  }
}