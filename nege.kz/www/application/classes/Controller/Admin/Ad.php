<?php defined('SYSPATH') or die('No direct access allowed.');
class Controller_Admin_Ad extends Admin
{
    protected function _list_init($collection)
    {
        return $collection->order_by('id','DESC');
    }
}
