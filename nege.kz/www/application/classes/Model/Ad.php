<?php

/**
 * Created by PhpStorm.
 * User: Almas
 * Date: 17.02.2016
 * Time: 11:49
 */
class Model_Ad extends ORM implements IC_Translatable
{
    protected $_table_name = 'ads';
    protected $_route = 'ad';
    protected $_list_title = "Реклама";
    protected $_edit_title = "Рекламу";

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

    protected $_belongs_to = array(
        'file_s' => array(
            'model' => 'Storage',
            'foreign_key' => 'file'
        )
    );

    public function fields_description()
    {
        return array(
            'is_published' => array(
                'edit' => true,
                'head' => false,
                'search' => false,
                'type' => 'checkbox',
                'label' => 'Активна',
                'params' => array(
                    'default_checked' => true
                ),
                'block' => 'rt_main',
            ),
            'title' => array(
                'edit' => true,
                'head' => true,
                'search' => true,
                'type' => 'strings',
                'label' => 'Название',
                'block' => 'common',
                'params' => array(
                    'widget' => 'multilang',
                    'langs' => array('ru', 'kz')
                ),
            ),
            'link' => array(
                'edit' => true,
                'head' => true,
                'search' => true,
                'type' => 'strings',
                'label' => 'Ссылка',
                'block' => 'common',
            ),
            'file' => array(
                'head' => false,
                'edit' => true,
                'label' => 'Изображение',
                'type' => 'image',
                'block' => 'common',
                'params' => array(
                    'aspect' => 16 / 9
                )
            )
        );
    }

    public static function get_main_ads()
    {
        $collection = ORM::factory('Ad')->where('title_' . I18n::$lang, '!=', '')->where('is_published', '=', 1)->find_all();
        return $collection;
    }

}