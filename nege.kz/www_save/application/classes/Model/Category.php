<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Category extends ORM_Embeded implements IC_Translatable
{
    protected $_table_name = 'categories';
    protected $_route = 'category';
    protected $_parent_field = "parent_id";
    protected $_parent_model = "Category";

    public $lang;

    public function ng_edit_url($uri = false)
    {
        return $this->_object_name . "/edit/"; // TODO: Change the autogenerated stub
    }

    public static $_model_blocks = array(
        'main' => array(
            'common' => array(
                'title' => 'Основное'
            ),
        ),
        'rt' => array(
            'rt_main' => array(
                'title' => 'Дополнительно'
            )
        ),
        'rb' => array()
    );

    public function search_form()
    {
        return array(
            'search' => array('title_ru', 'title_en', 'title_kz', 'description_ru', 'description_kz', 'description_en'),
            'flags' => array()
        );
    }

    public function filters()
    {
        return array(
            'sef' => array(
                array('Model_Page::filter_sef', array(':value', ':model', 'title')),
            ),
            'title_ru' => array(
                array('strip_tags')
            ),
            'title_kz' => array(
                array('strip_tags')
            ),
            'title_en' => array(
                array('strip_tags')
            ),
            'title_kk' => array(
                array('strip_tags')
            ),
            'parent_id' => array(
                array('Model_Page::parent_null', array(':model', ':value'))
            ),

        );
    }

    protected $_has_many = array(
        'children' => array('model' => 'Category', 'foreign_key' => 'parent_id'),
        'news' => array('model' => 'News', 'foreign_key' => 'category_id'),
        'sub_cat_news' => array('model' => 'News', 'foreign_key' => 'category_id'),
    );

    protected $_belongs_to = array(
        'parent' => array(
            'model' => 'Category',
            'foreign_key' => 'parent_id'
        ),
    );

    public function rules()
    {
        return array(
            'title_ru' => array(
                array('not_empty')
            ),
        );
    }

    public function fields_description()
    {
        return array(
            'id' => array(
                'head' => false,
                'label' => '#',
            ),
            'title' => array(
                'edit' => true,
                'head' => true,
                'search' => true,
                'type' => 'strings',
                'label' => 'Заголовок',
                'params' => array(
                    'widget' => 'multilang',
//                    'langs'=>array('ru','en','kz')
                ),
                'block' => 'common',
            ),
            'description' => array(
                'edit' => true,
                'head' => true,
                'search' => true,
                'type' => 'text',
                'label' => 'Описание категории',
                'params' => array(
                    'widget' => 'multilang',
//                    'langs'=>array('ru','en','kz')
                ),
                'block' => 'common',
            ),
            'show' => array(
                'edit' => true,
                'head' => true,
                'search' => false,
                'type' => 'select',
                'label' => 'Отображать на сайте',
                'params' => array(
                    'options' => array('1' => 'Да', '0' => 'Нет')
                ),
                'block' => 'rt_main',
            ),
            'on_main' => array(
                'edit' => true,
                'head' => true,
                'search' => false,
                'type' => 'select',
                'label' => 'Отображается на главной',
                'params' => array(
                    'options' => array('1' => 'Да', '0' => 'Нет')
                ),
                'block' => 'rt_main',
            ),
            'color' => array(
                'edit' => true,
                'head' => false,
                'search' => false,
                'type' => 'strings',
                'label' => 'Цвет',
                'block' => 'common',
            ),
            'position' => array(
                'edit' => true,
                'head' => false,
                'search' => false,
                'type' => 'strings',
                'label' => 'Позиция',
                'block' => 'common',
            ),
//            'children' => array(
//                'edit' => true,
//                'type' => 'embeded',
//                'label' => 'Дочерние категории',
//                'params' => array(
//                    'target' => $this->children
//                ),
//                'block' => 'common',
//            ),
            'sef' => array(
                'edit' => true,
                'head' => false,
                'search' => false,
                'type' => 'strings',
                'label' => 'ЧПУ',
                'block' => 'common',
            ),
            'meta_title' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'strings',
                'label' => 'SEO-заголовок',
                'block' => 'common',
                'params' => array(
                    'widget' => 'multilang'
                )
            ),
            'meta_description' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'strings',
                'label' => 'SEO-описание',
                'block' => 'common',
                'params' => array(
                    'widget' => 'multilang'
                )
            ),
            'meta_keywords' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'strings',
                'label' => 'SEO - ключевые слова',
                'block' => 'common',
                'params' => array(
                    'widget' => 'multilang'
                )
            ),
        );
    }

    /**
     * Урл для просмотра
     */
    public function view_url($uri = false)
    {
        if ($this->loaded()) {
            if ($this->parent->loaded()) {
                $_uri = "news/{$this->parent->sef}/{$this->sef}";
            } else {
                $_uri = "news/{$this->sef}";
            };
        } else {
            return '/';
        };
        $_uri = I18n::$lang . '/' . $_uri;
        return $uri ? $_uri : URL::site($_uri);
    }

    public function get_field($column)
    {
        if ($column == 'show') {
            return $this->show == 1? 'Да':'Нет';
        }
        if ($column == 'on_main') {
            return $this->on_main == 1? 'Да':'Нет';
        }
        return parent::get_field($column);
    }


}