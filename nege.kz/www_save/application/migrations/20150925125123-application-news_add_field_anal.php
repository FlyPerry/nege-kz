<?php defined('SYSPATH') or die('No direct script access.');

class news_add_field_anal extends Migration
{
  public function up()
  {
     $this->add_column("news", "anal", array('integer', 'default' => 0));
  }

  public function down()
  {
    $this->remove_column("news", 'anal');
  }
}