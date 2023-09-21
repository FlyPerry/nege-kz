<?php defined('SYSPATH') or die('No direct script access.');

class reporter extends Migration
{
  public function up()
  {
      $this->add_column("news","reporter",array(0=>"boolean","null"=>FALSE,"unsigned"=>TRUE));
  }

  public function down()
  {
      $this->remove_column("news","reporter");

  }
}