<?php defined('SYSPATH') or die('No direct script access.');

class feedback2 extends Migration
{
  public function up()
  {
      $this->add_column("feedbacks","file",array(0=>"integer","unsigned"=>TRUE));
  }

  public function down()
  {
      $this->remove_column("feedbacks","file");

  }
}