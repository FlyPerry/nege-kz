<?php


class Model_Media extends ORM_Embeded implements IC_Translatable
{

    protected $_table_name = 'news_media';
    protected $_parent_field = "news_id";
    protected $_parent_model = "News";
    protected $_route = "media";
    protected $_list_title = "Медиа";
    protected $_edit_title = "Медиа";

    protected $_updated_column = array('column' => 'updated_at', 'format' => 'Y-m-d H:i:s');
    protected $_created_column = array('column' => 'created_at', 'format' => 'Y-m-d H:i:s');

    protected $_belongs_to = array(
        'file_s'=>array(
            'model'=>'Storage',
            'foreign_key'=>'file'
        ),
    );

    public function fields_description()
    {
        return array(
            'author' => array(
                'edit' => true,
                'search'=>true,
                'type' => 'strings',
                'label' => 'Автор медиа',
                'block' => 'common',
            ),
            'place' => array(
                'edit' => true,
                'search'=>true,
                'type' => 'strings',
                'label' => 'Место съёмки',
                'block' => 'common',
            ),
            'source' => array(
                'edit' => true,
                'search'=>true,
                'type' => 'strings',
                'label' => 'Источник',
                'block' => 'common',
            ),
            'comment' => array(
                'edit' => true,
                'search'=>true,
                'type' => 'text',
                'label' => 'Комментарий',
                'block' => 'common',
            ),
            'type' => array(
                'edit' => true,
                'head' => false,
                'search' => false,
                'type' => 'select',
                'label' => 'Тип медиа',
                'params' => array(
                    'options' => array('0' => 'Видео', '1' => 'Фото')
                ),
                'block' => 'common',
            ),
            'media_type' => array(
                'head' => true,
                'edit' => false,
                'label' => 'Тип медиа',
                'type' => 'strings',
                'block' => 'common',
            ),
//            'news_id' => array(
//                'edit' => false,
//                'type' => 'select',
//                'label' => 'Новость',
//                'params' => array(
//                    'options' => $this->get_news_tree()
//                )
//            ),
            'video'=>array(
                'head' => true,
                'edit' => true,
                'label' => 'Ссылка на видео',
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
            'preview' => array(
                'head' => true,
                'edit' => false,
                'label' => 'Фото',
                'type' => 'strings',
            ),
        );
    }


    public function get_field($column)
    {
        if ($column == 'media_type') {
            if ($this->loaded()) {
                return $this->type == 1 ? "Фото" : "Видео";
            };
        };
        if ($column == "preview") {
            if ($this->loaded() && $this->file_s->loaded()) {
                return $this->file_s->html_cropped_img(50);
            } else {
                return "";
            }
        };
        return parent::get_field($column);
    }

    public function get_media($w = 780, $h = 440){
        if($this->loaded()){
            switch ($this->type){
                case 0:
                    return View::factory('news/media/video')
                        ->bind('w', $w)
                        ->bind('h', $h)
                        ->bind('model', $this);
                    break;
                case 1:
                    return View::factory('news/media/photo')
                        ->bind('w', $w)
                        ->bind('h', $h)
                        ->bind('model', $this);
                    break;
                default:
                    return "";
            }
        };
    }

    public function save(Validation $validation = NULL){
        if($this->type==0 && !$this->video){
            return false;
        }
        return parent::save($validation);
    }

}