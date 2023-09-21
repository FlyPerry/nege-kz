<?php


class Controller_Admin_Chapter extends Admin_Embeded
{
    public function factory_model()
    {
        return ORM::factory('Chapter');
    }

    /**
     * @var $collection ORM
     */
    protected function _list_init($collection)
    {
        parent::_list_init($collection);
        return $collection->order_by('priority', 'asc');
    }

    public function before()
    {
        parent::before();
        I18n::$lang = 'kz';
    }
}