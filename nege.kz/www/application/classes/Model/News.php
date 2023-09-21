<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_News extends ORM implements ISearchable
{
    protected $_table_name = 'news';
    protected $_route = 'news';
    protected $_updated_column = array('column' => 'updated_at', 'format' => 'Y-m-d H:i:s');
    protected $_created_column = array('column' => 'created_at', 'format' => 'Y-m-d H:i:s');
    protected $_list_title = "Новости";
    protected $_edit_title = "Новость";


    public static $_model_blocks = array(
        'main' => array(
            'common' => array(
                'title' => 'Основное'
            ),
            'main_key' => array(
                'title' => 'Главные и ключевые'
            ),
            'media' => array(
                'title' => 'Медиа',
            ),

            'add' => array(
                'title' => 'Дополнительная информация',
                'hidden' => true
            ),
            'seo' => array(
                'title' => 'SEO',
                'hidden' => true
            ),
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
        ),
        'audio_s' => array(
            'model' => 'Storage',
            'foreign_key' => 'audio'
        ),
        'infograph_s' => array(
            'model' => 'Storage',
            'foreign_key' => 'infograph'
        ),
        'category' => array(
            'model' => 'Category',
            'foreign_key' => 'category_id'
        ),
        'author' => array(
            'model' => 'Author',
            'foreign_key' => 'author_id'
        ),
    );

    protected $_has_many = array(
        'media' => array(
            'model' => 'Media',
            'foreign_key' => 'news_id',
        ),
    );

    public function filters()
    {
        return array(
            'title' => array(
                array('strip_tags')
            ),
            'description' => array(
                array('ORM::clear_html')
            ),
            'sef' => array(
                array('ORM::filter_sef', array(':value', ':model', 'title')),
            ),
            'date' => array(
                array('Date::formatted_time')
            ),
            'category_id' => array(
                array('Model_Page::parent_null', array(':model', ':value'))
            ),
            'audio' => array(
                array('Model_Page::parent_null', array(':model', ':value'))
            ),
        );
    }


    public function rules()
    {
        return array(
            'author_id' => array(
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
                    'default_checked' => true
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
            'text' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'text',
                'label' => 'Полная новость',
                'block' => 'common',
            ),
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
            'media' => array(
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
            ),
            'infograph' => array(
                'head' => false,
                'edit' => true,
                'label' => 'Инфографика',
                'type' => 'image',
                'block' => 'media',
                'params' => array(
                    'aspect' => 10 / 16
                )
            ),
            'audio' => array(
                'head' => false,
                'edit' => true,
                'label' => 'Аудиофайл',
                'type' => 'file',
                'block' => 'media'
            ),
            'video' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'strings',
                'label' => 'Видео',
                'block' => 'media',
            ),
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

            'author_name' => array(
                'edit' => true,
                'head' => false,
                'search' => true,
                'type' => 'strings',
                'label' => 'Автор (если его нет в базе)',
                'block' => 'add',
            ),


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
                'head' => true,
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

        );


    }

    public function search_form()
    {
        return array(
            'search' => array('title', 'text', 'description', 'meta_title', 'meta_keywords', 'meta_description'),
            'flags' => array(
                'date' => array('range' => true),
                'status',
                'planned',
//                'author_id', 'sub_main', 'main_in_cat',
                'category_id',
            )
        );
    }

    public function get_category_tree()
    {
        $result_list = array();
        $list = ORM::factory('Category');
        if (!empty($exclude)) {
            $list
                ->where_open()
                ->where('parent_id', 'NOT IN', $exclude)
                ->or_where('parent_id', 'IS', null)
                ->where_close()
                ->where_open()
                ->or_where('id', 'IS', null)
                ->where_close();
        };
        $list->order_by('position', 'DESC');
        foreach ($list->find_all() as $cat) {
            if (!is_null($cat->parent_id) && $cat->parent_id != 0) {
                $result_list[$cat->id] = $cat->parent->title . ' / ' . $cat->title;
            } else {
                if ($cat->children->count_all() == 0 || true) {
                    $result_list[$cat->id] = $cat->title;
                };
            };
        };
        return array(null => 'Нет') + $result_list;
    }

    protected function get_authors()
    {
        $authors = [];
        foreach (ORM::factory('Author')->order_by('name', 'asc')->find_all() as $author) {
            $authors[$author->id] = $author->name;
        }
        return array(null => 'Нет') + $authors;
    }

    public function get_second_category_tree()
    {
        return array(null => 'Нет') + ORM::factory('Category')->where('parent_id', 'IS NOT', null)->find_all()->as_array('id', 'title_ru');
    }

    public function get_news_tree()
    {
        return array(null => 'Нет') + ORM::factory('News')->where('id', '!=', $this->id)->find_all()->as_array('id', 'title');
    }

    /**
     * Урл для просмотра
     */
    public function view_url($uri = false, $protocol = NULL)
    {
        $sef = !is_null($this->sef) && strlen($this->sef) > 0 ? $this->sef : $this->id;
        if ($this->category->loaded()) {
            $_uri = "{$this->_route}/{$this->category->sef}/{$sef}";
        } else {
            $_uri = "{$this->_route}/{$sef}";
        };

        if(I18n::$lang !== 'kz') {
            $_uri = I18n::$lang . '/' . $_uri;
        }
        $uri = $uri ? $_uri : URL::site($_uri, $protocol);
        return $uri;
    }

    public function sef_date()
    {
        if ($this->loaded()) {
            return Date::formatted_time($this->date, "Y_m_d");
        };
        return "";
    }

    public static function get_main_news()
    {
        $date_expr = Date::formatted_time('now', 'Y-m-d H:i');
        $model = ORM::factory('News')
            ->where('lang', '=', 'kz')
            ->where('status', '=', 1)
            ->where('main', '=', 1)
            ->where('date', '<=', $date_expr)
            ->where('main_time_start', '<=', $date_expr)
            ->where('main_time_end', '>=', $date_expr)
            ->order_by('id', 'DESC')
            ->limit(3)
            ->find_all();
        if (!$model->count()) {
            $model = ORM::factory('News')
                ->where('lang', '=', 'kz')
                ->where('status', '=', 1)
                ->where('main', '=', 1)
                ->where('date', '<=', $date_expr)
                ->order_by('date', 'DESC')
                ->limit(3)
                ->find_all();
        };
        return $model;
    }

    public static function get_popular($limit = 1, $offset = 1)
    {
        $date_expr = Date::formatted_time('now', 'Y-m-d H:i');
        $model = ORM::factory('News')
            ->where('lang', '=', 'kz')
            ->where('status', '=', 1)
            ->where('main', '=', 0)
            ->where('date', '<=', $date_expr)
            ->order_by('views', 'DESC')
            ->order_by('date', 'DESC')
            ->limit($limit)
            ->offset($offset);
        return $model;
    }

    public static function get_key_news($limit = 1, $offset = 1)
    {
        $date_expr = Date::formatted_time('now', 'Y-m-d H:i');
        $model = ORM::factory('News')
            ->where('lang', '=', 'kz')
            ->where('status', '=', 1)
            ->where('main', '=', 0)
            ->where('date', '<=', $date_expr)
            ->order_by('date', 'DESC')
            ->limit($limit)
            ->offset($offset)
            ->where('key', '=', 1);
        return $model;
    }

    public function get_field($column)
    {
        if ($column == 'category_id') {
            return $this->category->title;
        }
        return parent::get_field($column);
    }

    public function __get($column)
    {
        if ($column == 'planned') {
            return false;
        }

        return parent::__get($column); // TODO: Change the autogenerated stub
    }

    public function inc_views()
    {
        if (!$this->loaded()) {
            return;
        };
        DB::query(Database::UPDATE, 'UPDATE news SET views = views+1 WHERE id=:id')
            ->param(':id', $this->id)
            ->execute();
    }

    public function get_audio()
    {
        if ($this->audio) {
            return $this->audio;
        };
        return false;
    }

    public static function get_infographic_banner()
    {
        $model = ORM::factory('News')
            ->where('lang', '=', 'kz')
            ->where('date', '<=', date('Y-m-d H:i:s'))
            ->where('infograph', '!=', null)
            ->order_by('date', 'DESC')
            ->find();
        if ($model->loaded()) {
            return View::factory('blocks/infographics')->bind('model', $model);
        };
        return "";
    }

    public static function get_main_last_news($ids)
    {
        $collection = ORM::factory('News')
            ->where('lang', '=', 'kz')
            ->where('status', '=', 1)
            ->where('id', 'NOT IN', $ids)
            ->where('date', '<=', date('Y-m-d H:i:s'))
            ->order_by('date', 'DESC')
            ->limit(50)
            ->find_all();
        return $collection;
    }

    public function get_type_icon()
    {
        if ($this->audio) {
            return '<img src="/img/audio.png" alt="audio">';
        } elseif ($this->video) {
            return '<img src="/img/video.png" alt="news video">';
        } else {
            return '';
        }
    }

    public function get_image_url()
    {
        return $this->file_s->loaded() ? $this->file_s->uri() : null;
    }

    public function get($field)
    {
//        if ($field == 'file_s' && !$this->file) {
//            $file = Storage::instance()->add(DOCROOT . "assets/img/custom_image_2.jpg");
//            $this->file_s = $file;
//            $this->save();
//            return $file;
//        }
//        if ($field == 'category') {
//            if (!parent::get($field) || !(parent::get($field)->loaded())) {
//                $field = 'special';
//
//            }
//        }
        return parent::get($field);

    }

    public function get_annotation($strip_tags = false)
    {
        if ($strip_tags) {
            return strip_tags($this->description ? $this->description : $this->text);
        } else {
            return $this->description ? $this->description : $this->text;
        }
    }

    public function as_array_ext($fields = array(), $action = null)
    {
        $data = parent::as_array_ext($fields, $action);
        $data['img_url'] = $this->file_s->html_img_url(360, 202);
        $data['date'] = Date::textdate($this->date, 'd m');
        $data['icon'] = $this->get_type_icon();
        $data['url'] = $this->view_url();
        return $data;
    }

    public static function get_category_news()
    {
        $data = array();
        $fields = array('date', 'title', 'description');
        $categories = ORM::factory('Category')->where('show', '=', 1)->order_by('position', 'DESC')->find_all();
        $index = 1;
        $limit = 3;
        foreach ($categories as $category) {
            $data[$category->id] = array('category' => $category->title, 'news' => array(), 'view_url' => $category->view_url());
            $cat_news = ORM::factory('News')
                ->where('category_id', '=', $category->id)
                ->where('lang', '=', 'kz')
                ->where('status', '=', 1)
                ->where('date', '<=', date('Y-m-d H:i:s'))
                ->order_by('date', 'DESC')
                ->limit($limit)
                ->find_all();
            foreach ($cat_news as $item) {
                $data[$category->id]['news'][$item->id] = $item->as_array_ext($fields);
            }
            $index++;
        }
        return $data;
    }

    public function get_schema_duration()
    {
        $duration = $this->audio_duration;
        $min = floor($duration / 60);
        $sec = $duration - $min * 60;
        return 'T' . $min . 'M' . $sec . 'S';
    }

    public function get_audio_duration()
    {
        $ffprobe = FFMpeg\FFProbe::create(array(
            'ffmpeg.binaries' => '/usr/bin/ffmpeg',
            'ffprobe.binaries' => '/usr/bin/ffprobe',
            'timeout' => 3600, // The timeout for the underlying process
            'ffmpeg.threads' => 12,   // The number of threads that FFMpeg should use
        ));
        $duration = $ffprobe
            ->format($this->audio_s->full_path())// extracts file informations
            ->get('duration');
        return $duration;
    }

    public static function get_popular_news()
    {
//        $week_ago_ts = strtotime("-7 day");
//        $week_ago_stamp = date("Y-m-d H:i", $week_ago_ts);
//        $today_stamp = date("Y-m-d H:i", time());
        $popular_news = ORM::factory('News')
            ->where('lang', '=', 'kz')
            ->where('status', '=', 1)
//            ->where('date','between',array($week_ago_stamp, $today_stamp))
            ->where('date', '<=', date('Y-m-d H:i:s'))
            ->order_by('date', 'DESC')
            ->order_by('views', 'DESC')
            ->limit(8)
            ->find_all();
        return $popular_news;
    }

    public function format_date()
    {
        if ($this->loaded()) {
            if (Date::formatted_time('now', 'd.m.y') === $this->date()) {
                return Date::formatted_time($this->date, 'H:i');
            };
            return $this->date();
        };
        return '';
    }


    public static function clear_html($dirty_html)
    {
        require_once Kohana::find_file('vendors/htmlpurifier/library/', 'HTMLPurifier.auto');

        $config = HTMLPurifier_Config::createDefault();
        $config->set('URI.Host', 'www.nege.kz');
        $config->set('HTML.SafeIframe', true);
        $config->set('HTML.Nofollow', false);
//        $config->set('URI.SafeIframeRegexp', '%^http://(www.youtube(?:-nocookie)?.com/embed/|player.vimeo.com/video/)%'); //allow YouTube and Vimeo
        $config->set('URI.SafeIframeRegexp', '%^http(s)+://(www.youtube(?:-nocookie)?.com/embed/|player.vimeo.com/video/)%'); //allow YouTube and Vimeo
        $config->set('Attr.AllowedFrameTargets', array("_blank"));
        $purifier = new HTMLPurifier($config);
        $clean_html = $purifier->purify($dirty_html);
        return $clean_html;
    }
}