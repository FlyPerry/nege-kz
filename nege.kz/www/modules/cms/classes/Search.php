<?php

/**
 * Created by PhpStorm.
 * User: AxCx
 * Date: 23.10.2015
 * Time: 12:39
 */
class Search
{
    public static function update($model)
    {
        $model_name = get_class($model);
        $search = ORM::factory('Search', array(
            'model' => $model_name,
            'model_id' => $model->id
        ));
        if ($search->loaded()) {
            $search->delete();
        }
        $values = array(
            'model_id' => $model->id,
            'model' => $model_name
        );
        switch ($model_name) {
            case 'Model_News':
                if ($model->status != 1) {
                    return false;
                }
                $values['title_ru'] = $model->title_ru;
                $values['title_en'] = $model->title_en;
                $values['title_kz'] = $model->title_kz;
                $values['text_ru'] = strip_tags($model->text_ru);
                $values['text_en'] = strip_tags($model->text_en);
                $values['text_kz'] = strip_tags($model->text_kz);
                $values['url'] = 'news/' . $model->sef;
                break;
            case 'Model_Page':
                if ($model->link) {
                    return false;
                }
                $values['title_ru'] = $model->title_ru;
                $values['title_en'] = $model->title_en;
                $values['title_kz'] = $model->title_kz;
                $values['text_ru'] = strip_tags($model->description_ru);
                $values['text_en'] = strip_tags($model->description_en);
                $values['text_kz'] = strip_tags($model->description_kz);
                $values['url'] = 'page/view/' . $model->sef;
                break;
            case 'Model_Media_Video':
                $values['title_ru'] = $model->title_ru;
                $values['title_en'] = $model->title_en;
                $values['title_kz'] = $model->title_kz;
                $values['text_ru'] = strip_tags($model->description_ru);
                $values['text_en'] = strip_tags($model->description_en);
                $values['text_kz'] = strip_tags($model->description_kz);
                $values['url'] = 'media/video/' . $model->sef;
                break;
            case 'Model_Media_Album':
                $values['title_ru'] = $model->title_ru;
                $values['title_en'] = $model->title_en;
                $values['title_kz'] = $model->title_kz;
                $values['text_ru'] = strip_tags($model->text_ru);
                $values['text_en'] = strip_tags($model->text_en);
                $values['text_kz'] = strip_tags($model->text_kz);
                $values['url'] = 'media/album/' . $model->sef;
                break;
        }
        ORM::factory('Search')->values($values)->save();
    }


    public static function delete($model)
    {
        DB::query(Database::DELETE, 'delete from search where model="' . get_class($model) . '" and model_id = ' . $model->id . ' limit 1')->execute();
    }
}