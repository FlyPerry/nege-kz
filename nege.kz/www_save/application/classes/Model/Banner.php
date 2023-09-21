<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_Banner extends ORM
{
    protected $_table_name = 'banners';
    protected $_route = 'banner';
    protected $_list_title = "Баннеры";
    protected $_edit_title = "Баннер";

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

    public static $langs = array(
        'ru' => 'ru',
        'en' => 'en',
        'kz' => 'kz',
        'kk' => 'kk'
    );

    protected $_belongs_to = array(
        'file_s' => array(
            'model' => 'Storage',
            'foreign_key' => 'file'
        ),
        'file2_s' => array(
            'model' => 'Storage',
            'foreign_key' => 'file2'
        ),
    );

    public function search_form()
    {
        return array(
            'search' => array('title', 'URL'),
            'flags' => array(
                'active', 'location'
            )
        );
    }

    public function filters()
    {
        return array(
            'title' => array(
                array('strip_tags')
            ),
            'URL' => array(
                array('strip_tags')
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
            'location' => array(
                'edit' => true,
                'head' => true,
                'label' => 'Положение',
                'search' => true,
                'type' => 'select',
                'params' => array(
                    'options' => self::$locations
                ),
                'block' => 'common',
            ),
            'lang' => array(
                'edit' => true,
                'head' => false,
                'label' => 'Язык',
                'search' => true,
                'type' => 'select',
                'params' => array(
                    'options' => self::$langs
                ),
                'block' => 'common',
            ),
            'target_blank' => array(
                'edit' => true,
                'head' => false,
                'search' => false,
                'type' => 'select',
                'label' => 'В новой вкладке',
                'params' => array(
                    'options' => array('1' => 'Да', '0' => 'Нет')
                ),
                'block' => 'common',
            ),
            'title' => array(
                'edit' => true,
                'head' => true,
                'search' => true,
                'type' => 'strings',
                'label' => 'Заголовок',
                'block' => 'common',
            ),
            'active' => array(
                'edit' => true,
                'head' => false,
                'search' => false,
                'type' => 'select',
                'label' => 'Активен',
                'params' => array(
                    'options' => array('1' => 'Да', '0' => 'Нет')
                ),
                'block' => 'common',
            ),
            'is_active' => array(
                'edit' => false,
                'head' => true,
                'search' => false,
                'label' => 'Активен',
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
            'URL' => array(
                'edit' => true,
                'head' => false,
                'search' => false,
                'type' => 'strings',
                'label' => 'Адрес ресурса',
                'block' => 'common',
            ),
            'file' => array(
                'head' => false,
                'edit' => true,
                'label' => 'Картинка баннера',
                'type' => 'file',
                'block' => 'common',
            ),
            'file2' => array(
                'head' => false,
                'edit' => true,
                'label' => 'Картинка баннера (мобильная версия)',
                'type' => 'file',
                'block' => 'common',
            ),
            'conversion' => array(
                'head' => true,
                'edit' => false,
                'label' => 'Переходов',
                'block' => 'common',
            ),
            'shows' => array(
                'head' => true,
                'edit' => false,
                'label' => 'Показов',
                'block' => 'common',
            )
        );
    }

    public function get_field($column)
    {
        if ($column == "is_active") {
            if ($this->loaded()) {
                return $this->active == 1 ? "Да" : "Нет";
            } else {
                return "";
            }
        };
        if ($column == 'location') {
            return Arr::get(self::$locations, $this->location);
        }
        return parent::get_field($column);
    }


    public static $locations = array(
        1 => 'Середина',
        2 => 'Шапка',
        3 => 'Под главной новостью',
    );


    public static function get_banners($location)
    {
        return ORM::factory('Banner')
            ->where('lang', '=', I18n::$lang)
            ->where('active', '=', 1)
            ->order_by('position', 'asc')
            ->where('location', '=', $location)
            ->find_all();
    }

    public static function get_banner($location)
    {
        $banner = ORM::factory('Banner')
            ->where('lang', '=', I18n::$lang)
            ->where('active', '=', 1)
            ->where('location', '=', $location)
            ->order_by(DB::expr('RAND()'))
            ->find();
        if ($banner->loaded()) {
            DB::update('banners')
                ->set(array('shows' => DB::expr('shows+1')))
                ->where('id', '=', $banner->id)->execute();
        }
        return $banner;

    }

    public function file_url($mobile = false)
    {
        if ($mobile) {
            if ($this->loaded() && $this->file2_s->loaded()) {
                return $this->file2_s->url();
            };
        };
        if ($this->loaded() && $this->file_s->loaded()) {
            return $this->file_s->url();
        };
        return '/img/blank.png';
    }

    public function view_url()
    {
        return URL::site('redirect/banner/' . $this->id);
    }

}

