<?php defined('SYSPATH') or die('No direct script access.');

class submain_in_news extends Migration
{
  public function up()
  {
      $this->add_column("news","sub_main",array("boolean"));

  }

  public function down()
  {
      $this->remove_column("news","sub_main");

  }
}