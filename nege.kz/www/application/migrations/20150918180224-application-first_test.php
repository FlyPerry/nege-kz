<?php defined('SYSPATH') or die('No direct script access.');

class first_test extends Migration
{
  public function up()
  {
      $this->create_table("banners",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"title"=>array("string[255]"),"active"=>array("integer"),"position"=>array("integer"),"URL"=>array("string[500]"),"file"=>array(0=>"integer","unsigned"=>TRUE)),array("id"));
      $this->create_table("categories",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"title_ru"=>array("string[500]"),"title_en"=>array("string[500]"),"title_kz"=>array("string[500]"),"description_ru"=>array("text"),"description_en"=>array("text"),"description_kz"=>array("text"),"color"=>array("string[40]"),"position"=>array("integer"),"parent_id"=>array(0=>"integer","unsigned"=>TRUE),"on_main"=>array("integer"),"sef"=>array("string[500]")),array("id"));
      $this->create_table("feedbacks",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"name"=>array("string[500]"),"email"=>array("string[255]"),"text"=>array("text")),array("id"));
      $this->create_table("live_photos",array("live_id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE),"file_id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE)),array("live_id","file_id"));
      $this->create_table("live_questions",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"live_id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE),"name"=>array("string[500]"),"email"=>array("string[500]"),"text"=>array("mediumtext")),array("id"));
      $this->create_table("live_speakers",array("live_id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE),"speaker_id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE)),array("live_id","speaker_id"));
      $this->create_table("lives",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"title"=>array(0=>"string[600]","null"=>FALSE),"sef"=>array(0=>"string[700]","null"=>FALSE),"description"=>array(0=>"mediumtext","null"=>FALSE),"text"=>array("mediumtext"),"date"=>array("datetime"),"updated_at"=>array("datetime"),"created_at"=>array("datetime"),"status"=>array("boolean"),"lang"=>array(0=>"string[3]","default"=>"ru"),"main"=>array("integer"),"views"=>array(0=>"integer","unsigned"=>TRUE),"allow_comments"=>array(0=>"integer","default"=>"1"),"meta_title"=>array("string[500]"),"meta_description"=>array("text"),"meta_keywords"=>array("text"),"file"=>array(0=>"integer","unsigned"=>TRUE),"main_time_start"=>array("datetime"),"main_time_end"=>array("datetime"),"type"=>array(0=>"integer","unsigned"=>TRUE,"default"=>"1"),"video"=>array("string[500]"),"comments"=>array(0=>"integer","null"=>FALSE)),array("id"));
      $this->create_table("media",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"video"=>array("string[500]"),"file"=>array(0=>"integer","unsigned"=>TRUE),"comment"=>array("text"),"author"=>array("string[500]"),"place"=>array("string[500]"),"source"=>array("string[500]"),"news_id"=>array(0=>"integer","unsigned"=>TRUE),"updated_at"=>array("datetime"),"created_at"=>array("datetime"),"type"=>array("integer"),"live_id"=>array(0=>"integer","unsigned"=>TRUE)),array("id"));
      $this->create_table("news",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"title"=>array(0=>"string[600]","null"=>FALSE),"link"=>array("string[500]"),"sef"=>array("string[700]"),"description"=>array("mediumtext"),"text"=>array("mediumtext"),"parent_id"=>array(0=>"integer","unsigned"=>TRUE),"position"=>array("integer"),"date"=>array("datetime"),"updated_at"=>array("datetime"),"created_at"=>array("datetime"),"status"=>array("boolean"),"category_id"=>array(0=>"integer","unsigned"=>TRUE),"lang"=>array(0=>"string[3]","default"=>"ru"),"main"=>array("integer"),"key"=>array("integer"),"author_id"=>array(0=>"integer","unsigned"=>TRUE),"author_name"=>array("string[500]"),"views"=>array(0=>"integer","unsigned"=>TRUE),"redactor_id"=>array(0=>"integer","unsigned"=>TRUE),"chosen"=>array("integer"),"allow_comments"=>array(0=>"integer","default"=>"1"),"meta_title"=>array("string[500]"),"meta_description"=>array("text"),"meta_keywords"=>array("text"),"file"=>array(0=>"integer","unsigned"=>TRUE),"photo_place"=>array("string[500]"),"photo_author"=>array("string[500]"),"main_time_start"=>array("datetime"),"main_time_end"=>array("datetime"),"type"=>array(0=>"integer","unsigned"=>TRUE),"tags"=>array("string[1000]"),"video"=>array("string[500]"),"comments"=>array("integer")),array("id"));
      $this->create_table("news_speakers",array("speaker_id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE),"news_id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE)),array());
      $this->create_table("points",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"title_ru"=>array("string[500]"),"title_en"=>array("string[500]"),"title_kz"=>array("string[500]"),"lng"=>array("string[50]"),"lat"=>array("string[50]")),array("id"));
      $this->create_table("sliders",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"title"=>array(0=>"string[600]","null"=>FALSE),"link"=>array("string[500]"),"sef"=>array("string[700]"),"url"=>array("mediumtext"),"updated_at"=>array("datetime"),"created_at"=>array("datetime"),"status"=>array("boolean"),"file"=>array(0=>"integer","unsigned"=>TRUE),"lang"=>array(0=>"string[3]","default"=>"ru")),array("id"));
      $this->create_table("speakers",array("id"=>array(0=>"integer","null"=>FALSE,"unsigned"=>TRUE,"auto"=>TRUE),"fullname"=>array(0=>"string[500]","null"=>FALSE),"biography"=>array("mediumtext"),"photo"=>array("integer"),"lang"=>array("string[2]"),"job"=>array("string[700]"),"date"=>array("date")),array("id"));
      $this->add_column("pages","file",array(0=>"integer","unsigned"=>TRUE));
      $this->add_index("live_questions","live_id",array("live_id"),"normal");
      $this->add_index("live_speakers","speaker_id",array("speaker_id"),"normal");
      $this->add_index("media","news_id",array("news_id"),"normal");
      $this->add_index("news","category_id",array("category_id"),"normal");
      $this->add_index("news_speakers","speaker_id",array("speaker_id"),"normal");
      $this->add_index("news_speakers","news_id",array("news_id"),"normal");
      $this->add_foreign_key("media","news_id","media_ibfk_1","news","id","cascade","no");
      $this->add_foreign_key("news","category_id","news_ibfk_1","categories","id","null","no");
      $this->add_foreign_key("news_speakers","news_id","news_speakers_ibfk_2","news","id","cascade","no");
      $this->add_foreign_key("news_speakers","speaker_id","news_speakers_ibfk_1","speakers","id","cascade","no");

  }

  public function down()
  {
    // $this->drop_table('table_name');

    // $this->remove_column('table_name', 'column_name');
  }
}