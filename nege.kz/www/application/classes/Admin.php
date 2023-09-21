<?php

class Admin extends Cms_Admin
{


    public function init_menu()
    {
        return parent::init_menu() + array(
//            'User' => array(
//                'active' => false,
//                'url' => ORM::factory('User')->list_url(),
//                'title' => 'Пользователи',
//            ),
//            'Author' => array(
//                'active' => false,
//                'url' => ORM::factory('Author')->list_url(),
//                'title' => 'Авторы',
//            ),
                'Page' => array(
                    'active' => false,
                    'url' => ORM::factory('Page')->list_url(),
                    'title' => 'Статичные страницы',
                ),
                'Category' => array(
                    'active' => false,
                    'url' => ORM::factory('Category')->list_url(),
                    'title' => 'Категории новостей',
                ),
                'Author' => array(
                    'active' => false,
                    'url' => ORM::factory('Author')->list_url(),
                    'title' => 'Авторы новостей',
                ),
                'News' => array(
                    'active' => false,
                    'url' => ORM::factory('News')->list_url(),
                    'title' => 'Новости',
                ),
                'Longread' => array(
                    'active' => false,
                    'url' => ORM::factory('Longread')->list_url(),
                    'title' => 'Лонгриды',
                ),
                'Banner' => array(
                    'active' => false,
                    'url' => ORM::factory('Banner')->list_url(),
                    'title' => 'Баннеры',
                ),
                'Ad' => array(
                    'active' => false,
                    'url' => ORM::factory('Ad')->list_url(),
                    'title' => 'Реклама',
                ),


            );
    }

    protected function _list_init($collection)
    {
        return $collection->order_by('id', 'DESC');
    }


}
