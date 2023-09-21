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
        return $collection
            ->where('material_type', '=', 1)
            ->order_by('date', 'DESC');
//        return $collection->where('reporter','=',0)->or_where_open()->where('reporter','=',1)->where('status','=',1)->or_where_close();
    }

    public function _search($model)
    {
        if ($model instanceof Cms_Interface_Partial) {
            $partial = $model->partial_model();

            $model
                ->join($partial->table_name(), 'LEFT')->on($partial->table_name() . '.object_id', '=', $model->object_name() . '.id');
            if (!$this->request->query('lang')) {
                $model->where('lang', '=', I18n::$lang);
            }
        }
        if(!($model instanceof IC_Translatable) && !(isset($model->lang)) && $this->request->param('lang')){
            $model->where('lang','=',$this->request->param('lang'));
        }
        $fields = $model->search_form();
        if($query = $this->request->query('search')){
            $model->and_where_open();
            foreach(Arr::get($fields,'search') as $field){
                $model->or_where($field, 'LIKE', "%{$query}%");
            }
            $model->and_where_close();
        }
        $fields = Arr::get($fields,'flags');
        $fields_description = $model->fields_description();
        foreach ($fields as $name => $f) {
            if(is_int($name)){
                $name=$f;
            }
            $range = false;
            if(is_array($f)){
                $range = Arr::get($f,'range',false);
            }
            $query = $this->request->query($name,null);
            $field = Arr::get($fields_description,$name);

            if($name === 'planned') {
                if($query) {
                    $model->where('date', '>=', date('Y-m-d H:i:s'));
                }
                continue;
            }

            if($field){
                $type = Arr::get($field,'type');
                if($type=='datetime'){
                    $type='date';
                }
                if ($query===null || $query==="") continue;
//                if (Arr::get($field, 'search')) {
                switch ($type) {
                    case 'strings':
                        $model->where($name, 'LIKE', "%{$query}%");
                        break;
                    case 'text':
                        $model->where($name, 'LIKE', "%{$query}%");
                        break;
                    case 'select':
                        $model->where($name, '=', $query);
                        break;
                    case 'date':

                        if($range){
                            list($from,$to) = explode('__',$query);

                            $from =date('Y-m-d 00:00:00', strtotime($from));
                            $to =date('Y-m-d 23:59:59', strtotime($to));
                            $model->where($name,'BETWEEN',array($from,$to));
                        }else{
                            $date = strtotime($query);
                            $model->where($name, '>=', date('Y-m-d 00:00:00', $date));
                            $model->where($name, '<=', date('Y-m-d 23:59:59', $date));
                        }

                        break;
                    default:
                        $model->where($name, '=', $query);
//                    }
                }
            }

        }
    }

    public function before()
    {
        parent::before();
        I18n::$lang = 'kz';
    }
}
