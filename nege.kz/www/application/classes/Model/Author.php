<?php
/**
 * Created by PhpStorm.
 * User: sgm
 * Date: 20.10.15
 * Time: 10:47
 */

class Model_Author extends ORM implements IC_Translatable
{

    protected $_table_name = 'authors';
    protected $_route = 'author';

    protected $_has_many = array(
        'news' => array(
            'model' => 'News',
            'foreign_key' => 'author_id'
        )
    );

    protected $_belongs_to = array(
        'photo_s' => array(
            'model' => 'Storage',
            'foreign_key' => 'photo'
        ),
    );

    protected $_list_title = "Авторы";
    protected $_edit_title = "Автора";

    public static $_model_blocks = array(
        'main' => array(
            'common' => array(
                'title' => 'Основное'
            )
        ),
        'rt' => array(
            'rt_main' => array(
                'title' => 'Дополнительно'
            )
        ),
        'rb' => array()
    );


    public function fields_description()
    {
        return array(
            'id' => array(
                'edit' => false,
                'search' => true,
                'head' => true,
                'label' => '#',
                'block' => 'common',
                'type' => 'strings'
            ),
            'name' => array(
                'edit' => true,
                'search' => true,
                'head' => true,
                'block' => 'common',
                'label' => 'Имя',
                'type' => 'strings',
            ),
            'photo' => array(
                'head' => false,
                'edit' => true,
                'label' => 'Фото',
                'type' => 'image',
                'block' => 'common',
                'params' => array(
                    'aspect' => 1 / 1
                )
            ),
        );
    }


    public function rules()
    {
        return array(
            'name' => array(
                array('not_empty')
            ),
        );
    }

    public function view_url()
    {
        return URL::site(I18n::$lang."/author/{$this->id}");
    }

    public function news() {
        $date_expr = Date::formatted_time('now', 'Y-m-d H:i');
        return $this->news
            ->where('status', '=', 1)
            ->where('date', '<=', $date_expr)
            ->order_by('date', 'DESC');
    }

}