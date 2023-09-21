<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Longread extends Model_News implements ISearchable
{
    protected $_route = 'longread';

    protected $_table_name = 'news';

    protected $_has_many = array(
        'media' => array(
            'model' => 'Media',
            'foreign_key' => 'news_id',
        ),
        'children' => array(
            'model' => 'Chapter',
            'foreign_key' => 'longread_id',
        ),
        'chapters' => array(
            'model' => 'Chapter',
            'foreign_key' => 'longread_id',
        ),
    );

    public function fields_description()
    {
        return array(
            'date' => array(
                'edit' => true,
                'head' => true,
                'search' => false,
                'type' => 'datetime',
                'label' => 'Дата публикации',
                'block' => 'rt_main',
            ),
            'status' => array(
                'edit' => true,
                'head' => false,
                'search' => false,
                'type' => 'checkbox',
                'label' => 'Активна',
                'params' => array(
                    'default_checked' => false
                ),
                'block' => 'rt_main',
            ),
            'title' => array(
                'edit' => true,
                'head' => true,
                'search' => true,
                'type' => 'strings',
                'label' => 'Заголовок',
                'block' => 'common',
            ),
            'sef' => array(
                'edit' => true,
                'head' => false,
                'search' => false,
                'type' => 'strings',
                'label' => 'ЧПУ',
                'block' => 'common',
            ),
            'description' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'text',
                'label' => 'Короткая новость',
                'block' => 'common',
            ),
            /*'text' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'text',
                'label' => 'Полная новость',
                'block' => 'common',
            ),*/
            'file' => array(
                'head' => false,
                'edit' => true,
                'label' => 'Главное изображение',
                'type' => 'image',
                'block' => 'common',
                'params' => array(
                    'aspect' => 16 / 9
                )
            ),
           /* 'media' => array(
                'head' => false,
                'edit' => true,
                'label' => 'Слайдер',
                'type' => 'photo_gallery',
                'block' => 'common',
                'params' => array(
                    'size' => 100,
                    'image_field' => 'file',
                    'fields' => array(
                        'author' => 'Автор',
                        'comment' => 'Комментарий'
                    ),
                    'hidden_fields' => array(
                        'type' => '1'
                    ),
                    'aspect' => 16 / 9
                )
            ),*/
           /* 'infograph' => array(
                'head' => false,
                'edit' => true,
                'label' => 'Инфографика',
                'type' => 'image',
                'block' => 'media',
                'params' => array(
                    'aspect' => 10 / 16
                )
            ),*/
            /*'audio' => array(
                'head' => false,
                'edit' => true,
                'label' => 'Аудиофайл',
                'type' => 'file',
                'block' => 'media'
            ),*/
            /*'video' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'strings',
                'label' => 'Видео',
                'block' => 'media',
            ),*/
            'main' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'checkbox',
                'label' => 'Главная новость',
                'block' => 'main_key',
            ),
            'author_id' => array(
                'edit' => true,
                'head' => true,
                'search' => true,
                'type' => 'select',
                'label' => 'Автор',
                'params' => array(
                    'options' => $this->get_authors()
                ),
                'block' => 'common',
            ),
            'category_id' => array(
                'edit' => true,
                'head' => true,
                'search' => true,
                'type' => 'select',
                'label' => 'Категория',
                'params' => array(
                    'options' => $this->get_category_tree()
                ),
                'block' => 'main_key',
            ),

            /*'author_name' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'strings',
                'label' => 'Автор (если его нет в базе)',
                'block' => 'add',
            ),*/


            'meta_title' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'strings',
                'label' => 'SEO-заголовок',
                'block' => 'seo',
            ),
            'meta_description' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'strings',
                'label' => 'SEO-описание',
                'block' => 'seo',
            ),
            'meta_keywords' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'strings',
                'label' => 'SEO - ключевые слова',
                'block' => 'seo',
            ),
            'planned' => array(
                'edit' => false,
                'head' => false,
                'search' => false,
                'hidden' => true,
                'type' => 'checkbox',
                'label' => 'Запланированные публикации',
                'block' => 'main_key',
            ),
            'children' => array(
                'edit' => true,
                'type' => 'embeded',
                'label' => 'Разделы',
                'params' => array(
                    'target' => $this->children
                ),
                'block' => 'common',
            ),

        );
    }


   /* public function children()
    {

        $children = $this->chapter->find_all();

        return $children;
    }*/

    public function save(Validation $validation = NULL)
    {
        $this->material_type = 2;
        return parent::save($validation); // TODO: Change the autogenerated stub
    }

    public function rules()
    {
        return array(
            'author_id' => array(
                array('not_empty')
            ),
            'file' => array(
                array('not_empty')
            ),

//            'title' => array(
//                array('not_empty')
//            ),
//            'sef' => array(
//                array(array($this, 'unique'), array('sef', ':value')),
//            ),
//            'text' => array(
//                array('not_empty')
//            ),
//            'file' => array(
//                array('not_empty')
//            ),
        );
    }

    public function view_url($uri = false, $protocol = NULL)
    {
        $sef = !is_null($this->sef) && strlen($this->sef) > 0 ? $this->sef : $this->id;
        if ($this->category->loaded()) {
            $_uri = "news/{$this->category->sef}/{$sef}";
        } else {
            $_uri = "news/{$sef}";
        };

        if(I18n::$lang !== 'kz') {
            $_uri = I18n::$lang . '/' . $_uri;
        }
        $uri = $uri ? $_uri : URL::site($_uri, $protocol);
        return $uri;
    }

}