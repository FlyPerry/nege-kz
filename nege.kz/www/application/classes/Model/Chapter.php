<?php


class Model_Chapter extends ORM_Embeded implements IC_Translatable
{
    protected $_parent_field = "longread_id";
    protected $_parent_model = "Longread";
    protected $_route = "chapter";

    protected $_edit_title = 'Разделы';
    protected $_list_title = 'Разделы';

    public static $_model_blocks = array(
        'main' => array(
            'common' => array(
                'title' => 'Основное'
            ),

        ),
        'rt' => array(
            'rt_main'=>array(
                'title' => 'Дополнительно'
            )
        ),
        'rb' => array()
    );

    protected $_default_lang = 'kz';

    protected $_belongs_to = array(
        'longread' => array(
            'model' => 'Longread',
            'foreign_key' => 'longread_id'
        ),
        'file_s' => array(
            'model' => 'Storage',
            'foreign_key' => 'file'
        ),
    );

    public function fields_description()
    {
        return array(
            'title' => array(
                'edit' => true,
                'head' => true,
                'type' => 'strings',
                'label' => 'Заголовок',
                'block' => 'common',
            ),
            'sub_title' => array(
                'edit' => true,
                'head' => true,
                'type' => 'strings',
                'label' => 'Подзаголовок',
                'block' => 'common',
            ),
            'text' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'text',
                'label' => 'Контент',
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
            ),
            'sidebar_text' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'text',
                'label' => 'Контент в сайдбаре',
                'block' => 'common',
            ),
            'sidebar_status' => array(
                'edit' => true,
                'head' => false,
                'search' => false,
                'type' => 'checkbox',
                'label' => 'Показать контент в сайдбаре',
                'params' => array(
                    'default_checked' => false
                ),
                'block' => 'rt_main',
            ),
            'priority'=>array(
                'head' => true,
                'edit' => true,
                'label' => 'Приоритет',
                'type' => 'strings',
                'block' => 'common',
            ),
        );
    }
}