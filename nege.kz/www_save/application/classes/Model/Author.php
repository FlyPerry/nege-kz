<?php
/**
 * Created by PhpStorm.
 * User: sgm
 * Date: 20.10.15
 * Time: 10:47
 */

class Model_Author extends ORM{

    protected $_route='author';

    protected $_has_many = array(
        'news' => array(
            'model' => 'News',
            'foreign_key' => 'author_id'
        )
    );

    public function fields_description(){
        return array(
            'id'=>array(
                'edit'=>false,
                'search'=>true,
                'head'=>true,
                'label'=>'#',
                'type'=>'strings'
            ),
            'title'=>array(
                'edit'=>true,
                'search'=>true,
                'head'=>true,
                'label'=>'Имя',
                'type'=>'strings',
                'params'=>array(
                    'widget'=>'multilang',
                    'langs'=>array('ru','en','kz', 'kk')
                ),
            )
        );
    }

    public function view_url() {
        return URL::site(I18n::$lang."/news/author/{$this->id}");
    }

}