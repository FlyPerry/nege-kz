<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 06.09.12
 * Time: 13:39
 * To change this template use File | Settings | File Templates. <br>
 * ------------------------------------------------------------------------------<br>
 * 1) Данный класс предназначен для реализации управляющих элемнтов в админ панели. <br>
 * 2) Класс определяет/переопределяет дополнительные методы для реализации отображения, управления,
 * добавления и редактирования <b> модели, структура которой -  имеет вид дерева полей (из БД) связанных между собой
 * параметрами id и pid.</b><br>
 */
class Admin_Embeded extends Admin
{
    public function action_list()
    {
        parent::action_list();
        if($this->request->param('id')){
            $this->render=false;
            $this->response->body($this->page->content());
        }
    }


    protected function _list_init($collection)
    {
        $this->_mass_delete();
        $collection=parent::_list_init($collection);
        if (!$this->request->query('search')){
            $parent_id=$this->request->param('id');
            if ($parent_id == ''){
                $parent_id = null;
            };
            $collection->where($collection->parent_field(),'=',$parent_id);
            $collection->{$collection->parent_field()}=$parent_id;
        }
        return $collection;
    }




    protected function _before_cancel($model)
    {
        if (!$model->loaded()){ //Это если модель не сохранена, то надо установить родительский айди для редиректа
            $model->{$model->parent_field()}=$this->request->param('id2');
        }
        $this->redirect($model->parent_url());
        return parent::_before_cancel($model);
    }

    protected function _after_edit_init($model)
    {

        if (!$model->loaded()){ //Это если модель не сохранена, то надо установить родительский айди для редиректа
            $model->{$model->parent_field()}=$this->request->param('id2',0);
        }
        return parent::_after_edit_init($model);
    }


    protected function _edit_init($model)
    {
        $model = parent::_edit_init($model);
        $parent_id = $this->request->param('id2');
        if ($parent_id){
            $model->where($model->parent_field(),'=',$parent_id);
        };
        return $model;
    }




}
