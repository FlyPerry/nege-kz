<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 17.09.12
 * Time: 12:44
 * To change this template use File | Settings | File Templates.
 */
class Components_Widget_Multilang extends Components_Widget
{

    public function __construct(){
        $this->view=View::factory('components/widget/multilang');
        $this->view->bind('elements',$this->elements);
        $this->view->bind('id',$this->id);

    }

    function add($options)
    {
        $model=$options['model'];
        $langs=$model::$_model_langs;
        $cp=Component::factory('components/plain');
        $field=$options['field'];
        foreach($langs as $lang=>$title){
            if (!isset($this->elements[$lang])){
                $this->elements[$lang]=array();
            }
            $options['field']="{$field}_{$lang}";

            $options['value']=$model->__get($options['field']);
            $options['error']=Arr::get($cp->errors(),$options['field']);
            $this->elements[$lang][]=$cp->create_component($options['component_name'],$options);
        }

    }

    function __toString(){
        $this->view->set('langs',array_keys($this->elements));
        $this->view->set('prefix',$this->id);
        return $this->view->render();
    }

}
