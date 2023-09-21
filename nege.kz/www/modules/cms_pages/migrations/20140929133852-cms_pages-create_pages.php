<?php defined('SYSPATH') or die('No direct script access.');

class create_pages extends Migration
{
  public function up()
  {
    // $this->create_table
    // (
    //   'table_name',
    //   array
    //   (
    //     'updated_at'          => array('datetime'),
    //     'created_at'          => array('datetime'),
    //   )
    // );
      $this->create_table('pages',array(
          'id' => array('integer', 'unsigned' => true),

          'title_ru'=>array('string[600]','null'=>false),
          'title_kz'=>array('string[600]','null'=>false),
          'title_en'=>array('string[600]','null'=>false),
          'link'=>array('string[500]','null'=>true),
          'sef'=>array('string[700]','null'=>true),
          'description_ru'=>array('mediumtext','null'=>true),
          'description_kz'=>array('mediumtext','null'=>true),
          'description_en'=>array('mediumtext','null'=>true),
          'parent_id' => array('integer', 'unsigned' => true),
          'position' => array('integer', 'default' => 0),
          'updated_at'          => array('datetime'),
          'created_at'          => array('datetime'),
      ));

    // $this->add_column('table_name', 'column_name', array('datetime', 'default' => NULL));
  }

  public function down()
  {

      $this->drop_table('pages');
    // $this->drop_table('table_name');

    // $this->remove_column('table_name', 'column_name');
  }
}