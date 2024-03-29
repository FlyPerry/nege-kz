<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sgm
 * Date: 04.06.13
 * Time: 12:28
 * To change this template use File | Settings | File Templates.
 */

class ORM_Embeded extends ORM {

    protected $_parent_field="parent_id";
    protected $_parent_model="parent";

//    public function edit_url($uri=false)
//    {
//        $id=$this->id?$this->id:0;
//        $_uri =$this->route()."/edit/{$id}/{$this->{$this->parent_field()}}";
//        return $uri?$_uri:URL::site($_uri);
//    }

    public function edit_url($uri = false)
    {
        $id=intval($this->id);
        $params = array(
            'model'=>$this->object_name(),
            'action'=>'edit',
            'id'=>$id,
            'id2'=>$this->{$this->parent_field()}
        );
        if(!($this instanceof IC_Translatable) && count($this::$_model_langs) && (($this->lang() AND $lang=$this->lang()) OR $lang=Request::$current->param('lang') OR $lang=I18n::$lang)){
            $params['lang'] = $lang;
        }
        $_uri = Route::get('admin')->uri($params);
//        $_uri = $this->route()."/edit/{$id}";
        if ($this instanceof Cms_Interface_Tree){
            $parent=$this->{$this->tree_parent_field()};
            $_uri.='/'.$parent;
        }

        return $uri ? $_uri : URL::site($_uri);
    }

    public function parent_url($uri=false)
    {
        $parent=ORM::factory($this->parent_model(),$this->{$this->parent_field()});
        if ($parent->loaded()==false){
            return $this->list_url(true);
        }
        if(Request::current()->directory()=='Admin')
            return $parent->edit_url(true);
        else
            return $parent->view_url($uri);
    }

//    public function list_url($uri=false){
//        $_uri = $this->route()."/list";
//        if ($this->loaded()){
//            $id=$this->{$this->parent_field()};
//            if (!empty($id) || $id!=0){
//                $_uri.="/{$id}";
//            }
//        }
//        return $uri?$_uri:URL::site($_uri);
//    }

    public function ng_edit_url($uri = false)
    {
//        $id=$this->id?$this->id:0;
        return $_uri = $this->_object_name."/edit/{$this->{$this->parent_field()}}";// TODO: Change the autogenerated stub
    }

    public function ng_list_url($uri = false)
    {
        $_uri = $this->_object_name."/list/"; // TODO: Change the autogenerated stub
        if ($this->loaded()){
            $id=$this->{$this->parent_field()};
            if (!empty($id) || $id!=0){
                $_uri.="/{$id}";
            }
        }
        return $_uri;
    }

    public function parent_field(){
        return $this->_parent_field;
    }

    public function parent_model(){
        return $this->_parent_model;
    }

}