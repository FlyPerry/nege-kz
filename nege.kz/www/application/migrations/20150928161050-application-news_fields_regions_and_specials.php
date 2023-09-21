<?php defined('SYSPATH') or die('No direct script access.');

class news_fields_regions_and_specials extends Migration
{
  public function up()
  {
      $this->add_column("news","special_id",array(0=>"integer","unsigned"=>TRUE));
      $this->add_column("news","region_id",array(0=>"integer","unsigned"=>TRUE));

      $this->add_foreign_key("news","region_id","news_ibfk_4","categories","id","null","no");
      $this->add_foreign_key("news","special_id","news_ibfk_3","categories","id","null","no");
  }

  public function down()
  {
      $this->drop_foreign_key("news","news_ibfk_4");
      $this->drop_foreign_key("news","news_ibfk_3");
      $this->remove_column("news","special_id");
      $this->remove_column("news","region_id");
  }
}