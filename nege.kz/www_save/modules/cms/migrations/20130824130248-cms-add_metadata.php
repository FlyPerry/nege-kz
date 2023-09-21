<?php defined('SYSPATH') or die('No direct script access.');

class add_metadata extends Migration
{
  public function up()
  {
      //Для хранения данных о файле в json формате
      //К примеру можно хранить инфу об обрезки фото
      $this->add_column("storages","metadata",array("text"));
  }

  public function down()
  {
      $this->remove_column("storages","metadata");
  }
}