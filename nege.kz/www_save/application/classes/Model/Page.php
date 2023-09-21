<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Page extends ORM_Embeded implements IC_Translatable
{
    protected $_parent_field = "parent_id";
    protected $_parent_model = "Page";
    protected $_route = "page";
    protected $_updated_column = array('column' => 'updated_at', 'format' => 'Y-m-d H:i:s');
    protected $_created_column = array('column' => 'created_at', 'format' => 'Y-m-d H:i:s');

    protected $_list_title = "Страницы";
    protected $_edit_title = "Страницу";

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


    public static $_model_langs = array('ru'=>'Рус', 'kz'=>'Каз');

    protected $_has_many = array(
        'children' => array(
            'model' => 'page',
            'foreign_key' => 'parent_id',
        ),

    );

    protected $_belongs_to = array(
        'file_s'=>array(
            'model'=>'Storage',
            'foreign_key'=>'file'
        ),
    );

    public static function filter_sef($value, $model, $field)
    {
        if ($value == '' || !$value) {
            $value = ORM::translit($model->$field);
        }
        return $value;
    }

    public static function parent_null($model, $value)
    {
        if ($value == 0) {
            return NULL;
        }
        return $value;
    }

    public function filters()
    {
        return array(
            'parent_id' => array(
                array('Model_Page::parent_null',array(':model', ':value'))
            ),
            'sef' => array(
                array('Model_Page::filter_sef', array(':value', ':model', 'title')),
            ),
        );
    }



    public function rules()
    {
        return array(
            'title_ru' => array(
                array('not_empty')
            ),
            'description_ru' => array(
                array('not_empty')
            ),
        );
    }

    public function fields_description()
    {
        return array(
            'title' => array(
                'edit' => true,
                'head' => true,
                'search'=>true,
                'type' => 'strings',
                'label' => 'Заголовок',
                'params'=>array(
                    'widget'=>'multilang',
                    'langs'=>array('ru','en','kz', 'kk')
                ),
                'block' => 'common',

            ),
            'link' => array(
                'edit' => true,
                'type' => 'strings',
                'label' => 'Внешняя ссылка',
                'block' => 'common',
            ),
            'description' => array(
                'edit' => true,
                'search'=>true,
                'type' => 'text',
                'label' => 'Текст',
                'params'=>array(
                    'widget'=>'multilang',
                    'langs'=>array('ru','en','kz', 'kk')
                ),
                'block' => 'common',
            ),
            'sef' => array(
                'edit' => true,
                'type' => 'strings',
                'label' => 'ЧПУ',
                'block' => 'common',
            ),
            'parent_id' => array(
                'edit' => true,
                'type' => 'select',
                'label' => 'Родитель',
                'params' => array(
                    'options' => $this->get_pages_tree()
                ),
                'block' => 'common',
            ),
            'children' => array(
                'edit' => true,
                'type' => 'embeded',
                'label' => 'Дочерние страницы',
                'params' => array(
                    'target' => $this->children
                ),
                'block' => 'common',
            ),

            'position'=>array(
                'head' => true,
                'edit' => true,
                'label' => 'Приоритет',
                'type' => 'strings',
                'block' => 'common',
            ),
            'file'=>array(
                'head'=>false,
                'edit'=>true,
                'label'=>'Изображение',
                'type'=>'image',
                'block' => 'common',
            ),


        );
    }


    public function get_pages_tree()
    {
        return array(null => 'Нет') + ORM::factory('page')->where('id', '!=', $this->id)->find_all()->as_array('id', 'title');
    }

    public function menu_type()
    {

        $children = $this->children->count_all();

        if ($children > 0) {
            return "submenu";
        } else {
            return "item";
        }
    }

    public function children()
    {

        $children = $this->children->order_by(DB::expr('CASE'),DB::expr('when `position` is null then 1 else 0 end, `position`'))->find_all();

        return $children;
    }

    public function view_url($uri = false)
    {
        if ($this->loaded() && !empty($this->link)){
            return $uri?$this->link:URl::site($this->link);
        }
        $_uri = I18n::$lang."/".$this->_route."/view/{$this->sef}";
        return $uri ? $_uri : URL::site($_uri);
    }


}
