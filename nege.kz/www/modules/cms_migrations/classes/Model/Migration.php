<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Migration extends ORM {

    protected $_updated_column = array('column' => 'updated_at', 'format' => 'Y-m-d H:i:s');
    protected $_created_column = array('column' => 'created_at', 'format' => 'Y-m-d H:i:s');

	public function is_installed() {
		try {
      $this->count_all();
    } catch (Database_Exception $a) {
      return false;
    }
    return true;
	}

	public function fetch_migrations() {
		try {
  	  $this->find_all();
    } catch (Database_Exception $a) {
      if ($a->getCode() == 1146) { //Tabla no existe
        echo kohana::debug($a->getMessage());
    	}
	  }
	}
  
}