<?php defined('SYSPATH') or die('No direct access allowed.');

class Controller_Admin_News extends Admin
{
    public $option = array('model' => 'News');

    public function _after_save($model, $values = null)
    {
        if ($model->audio) {
            $duration = $model->get_audio_duration();
            $model->audio_duration = $duration;
            try {
                $model->save();
            } catch (ORM_Validation_Exception $e) {
                throw new HTTP_Exception_500($e->getMessage());
            }
        }
        parent::_after_save($model);
    }

    protected function _list_init($collection)
    {
        return $collection->order_by('date', 'DESC');
//        return $collection->where('reporter','=',0)->or_where_open()->where('reporter','=',1)->where('status','=',1)->or_where_close();
    }
}
