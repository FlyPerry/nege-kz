<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 21.11.12
 * Time: 14:39
 * To change this template use File | Settings | File Templates.
 */
class Components_Widget_MapPoint extends Components_Widget
{
    public $roles=array(
        'lat'=>true,'lng'=>true,'address'=>true
    );

    public $lat;
    public $lng;
    public $address;

    public function __construct(){
        $this->view=View::factory('components/widget/mappoint');
        $this->view->bind('elements',$this->elements);
        $this->view->bind('id',$this->id);
        $this->view->bind('lat',$this->lat);
        $this->view->bind('lng',$this->lng);
        $this->view->bind('address',$this->address);
    }

    function add($options)
    {
        $field=$options['field'];
        $value=$options['value'];
        $params=Arr::get($options,'params',array());
        $role=Arr::get($params,'role',$field);

        if (isset($this->roles[$role])){
            $this->{$role}=$value;
            $attr=Arr::get($params,'attr',array());
            $attr['role']=$role;
            $params['attr']=$attr;
            $options['params']=$params;
            $cp=Component::factory('components/plain');
            $this->elements[$role]=$cp->create_component($options['component_name'],$options);
        }
    }

}
