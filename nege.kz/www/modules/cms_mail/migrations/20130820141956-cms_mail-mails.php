<?php defined('SYSPATH') or die('No direct script access.');

class mails extends Migration
{
    public function up()
    {
        $this->create_table("mails", array("id" => array(0 => "integer", "null" => FALSE, "unsigned" => TRUE, "auto" => TRUE), "subject" => array(0 => "string[300]", "null" => FALSE), "text" => array(0 => "mediumtext", "null" => FALSE), "to" => array(0 => "string[100]", "null" => FALSE), "from" => array(0 => "string[100]", "null" => FALSE), "status" => array(0 => "boolean", "unsigned" => TRUE), "error_text" => array("string[500]"), "priority" => array("boolean")), array("id"));

    }

    public function down()
    {
        $this->drop_table("mails");
    }
}