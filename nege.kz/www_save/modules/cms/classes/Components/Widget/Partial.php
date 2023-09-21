<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 17.09.12
 * Time: 12:44
 * To change this template use File | Settings | File Templates.
 */
class Components_Widget_Partial extends Components_Widget
{

    public static $langs=array('ru'=>'Русский','kz'=>'Казахский','en'=>'Английский');

    public function __construct(){
        $this->view=View::factory('components/widget/partial');
        $this->view->bind('elements',$this->elements);
        $this->view->bind('id',$this->id);

    }

    function add($options)
    {
        $langs=Arr::get($options['params'],'langs',self::$langs);
        $cp=Component::factory('components/plain');
        $field=$options['field'];
        foreach($langs as $lang=>$title_lang){
            if (!isset($this->elements[$lang])){
                $this->elements[$lang]=array();
            }
            $options['field']="partials][{$lang}][{$field}";// model[$field] => model[_partials][lang][field_]
            $model=$options['model'];
            $options['value']=$model->get_partial_field($field,$lang);
            $options['error']=Arr::get($cp->errors(),$field);
            $this->elements[$lang][]=$cp->create_component($options['component_name'],$options);
        }

    }

    function __toString(){
        $this->view->set('langs',array_keys($this->elements));
        $this->view->set('prefix',$this->id);
        return $this->view->render();
    }

}
