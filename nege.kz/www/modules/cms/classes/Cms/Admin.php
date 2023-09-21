<?php

/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 21.11.12
 * Time: 10:45
 * To change this template use File | Settings | File Templates.
 */
class Cms_Admin extends Cms_Controller_Admin
{
    protected $need_auth = true;

    public $option = array();


    protected $menu = array();
    protected $values;
    /**
     * @var string URI для входа
     */
    protected $login_uri = "user/login";

    protected $crumbs = array();

    public function before()
    {
//        try {
//            parent::before();
//
//        } catch (HTTP_Exception_403 $e){
//            $this->request->action('403');
//        }
        parent::before();
        I18n::lang('ru');

//
//        $this->menu['main'] = array(
//            'title' => 'Главная',
//            'active' => false,
//            'url' => URL::site('admin')
//        );

        $scripts = $this->scripts();
        $ng_controller = Arr::get($scripts,'ng-controller',false);
        View::bind_global('ng_controller',$ng_controller);


        $this->template->bind("menu", $this->menu);
        $this->template->bind("crumbs", $this->crumbs);

        $this->menu += $this->init_menu();
        $menu = $this->menu + $this->init_menu();
        $this->generate_menu($menu);
        $this->menu = $menu;



        if (isset($this->menu[$this->request->param('model')])) {
            $this->menu[$this->request->param('model')]['active'] = true;
            $this->page->title($this->menu[$this->request->param('model')]['title']);
        } else {
            $this->page->title("Панель управления");
//            $this->menu['main']['active'] = true;
        }

        $this->crumbs[] = array('title' => 'Панель управления', 'uri' => 'admin/panel/index');
        if (isset($this->menu[Arr::get($this->option, 'model')])) {
            $this->menu[$this->option['model']]['active'] = true;
            $this->page->title($this->menu[$this->option['model']]['title']);
            $this->crumbs[] = array('title' => $this->page->title(), 'uri' => $this->menu[$this->option['model']]['url']);
        } else {
            $this->page->title("Панель управления");
//            $this->menu['main']['active'] = true;
        }

        Component::errors($this->errors);
    }

    public function generate_menu(&$menu)
    {
        foreach ($menu as $k => $val) {
            if (Authority::cannot('list', strtolower($k), $this->user)) {
                unset($menu[$k]);
            } elseif (isset($menu[$k]['sub'])) {
                $this->generate_menu($menu[$k]['sub']);
            }
        }
    }

    public function after()
    {
        if (!$this->request->is_external() && ($this->request->post('only_content') || $this->request->query('only_content'))) {
            $this->response->body($this->page->content());
            return;
        }
        parent::after();
    }

    protected function _save(&$model, $values, $external = null, $expected = null)
    {
        $option = Arr::get($this->option, 'model');
        if ($option == 'User') {
            $password = Arr::get($values, 'password');
            if (!$password) {
                unset($values['password']);
            }
        }
        $values = array_merge($values,$model->_default_values);
        return parent::_save($model, $values, $external, $expected);
    }

    public function factory_model()
    {
        return ORM::factory(ucfirst($this->request->param('model')));
    }

    /**
     * Активация текущего пункта меню
     * @param $model
     */
    public function menu($model)
    {
        if (Arr::get($this->menu, $item = $model->route())) {
            $this->page->title($this->menu[$item]['title']);
            $this->menu[$item]['active'] = true;
            $this->menu['main']['active'] = false;
        }
    }

    /**
     * Установка массива для формирования меню админки
     * @return array
     */
    public function init_menu()
    {
        return  array(
            'Users' => array(
                'active' => false,
                'url' => URL::site('controlpanel/user/list'),
                'title' => 'Пользователи',
                'icon' => 'fa-user',
            ),
        );
    }

    public function scripts()
    {
        return parent::scripts()+ array(
            'jquery' => 'bower_components/jquery/dist/jquery.min.js',
//            'jquery-ui'=>'js/lib/jquery-ui-1.9.1.custom.min.js',
            'cropper' => 'bower_components/cropper/dist/cropper.min.js',
            'angular' => 'bower_components/angular/angular.min.js',
            'admin_app' => 'js/app/app.js',
            'bootstrap' => 'bower_components/bootstrap/dist/js/bootstrap.min.js',
            'moment' => 'bower_components/moment/min/moment.min.js',
            'moment-locale-ru' => 'bower_components/moment/locale/ru.js',
            'bootstrap-datetimepicker' => 'bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
            'selectize' => 'bower_components/selectize/dist/js/standalone/selectize.js',
            'ckeditor' => 'bower_components/ckeditor/ckeditor.js',
            'ckeditor.jquery' => 'bower_components/ckeditor/adapters/jquery.js',
            'storage' => 'js/lib/storage.js',
            'medtisMenu'=>'bower_components/metisMenu/dist/metisMenu.min.js',
            'charts'=>'bower_components/raphael/raphael-min.js',
            'charts2'=>'bower_components/morrisjs/morris.min.js',
//            'date_time_picker' => 'js/lib/datetimepicker.js',
            'jquery.Jcrop.min.js' => 'js/lib/jcrop/js/jquery.Jcrop.min.js',
            'material' => 'bower_components/bootstrap-material-design/dist/js/material.min.js',
            'ripples' => 'bower_components/bootstrap-material-design/dist/js/ripples.js',
            'admin' => 'js/admin.js',
            'admin2' => 'bower_components/startbootstrap-sb-admin-2/dist/js/sb-admin-2.js',
            'map' => 'js/map.js',
            'valueInit.directive' => 'js/app/directives/valueInit.directive.js',
            'textEditor.directive' => 'js/app/directives/textEditor.driective.js',
            'fileUploader.directive' => 'js/app/directives/fileUploader.directive.js',
            'uploader.service' => 'js/app/services/uploader.service.js',
            'selectExtended.directive' => 'js/app/directives/selectExtended.directive.js',
            'imageUploader.directive' => 'js/app/directives/imageUploader.directive.js',
            'photoGallery.directive' => 'js/app/directives/photoGallery.directive.js',
            'videoGallery.directive' => 'js/app/directives/videoGallery.directive.js',
            'checkbox.directive' => 'js/app/directives/checkbox.directive.js',
            'search_checkbox.directive' => 'js/app/directives/search_checkbox.directive.js',
            'listExtended.directive' => 'js/app/directives/listExtended.directive.js'
            //'redactor_lang' => $this->page->find_content('js/lib/redactor/ru.js')
        );
    }

    public function styles()
    {
        return parent::styles()+ array(
//            'jquery-ui'=>'js/lib/jquery-ui-1.9.1.custom/css/smoothness/jquery-ui-1.9.1.custom.min.css',
            'bootstrap' => 'bower_components/bootstrap/dist/css/bootstrap.min.css',
            'metisMenu' => 'bower_components/metisMenu/dist/metisMenu.min.css',
            'timeline' => 'bower_components/startbootstrap-sb-admin-2/dist/css/timeline.css',
            'sbadmin' => 'bower_components/startbootstrap-sb-admin-2/dist/css/sb-admin-2.css',
            'material' => 'bower_components/bootstrap-material-design/dist/css/bootstrap-material-design.min.css',
            'material.ripples' => 'bower_components/bootstrap-material-design/dist/css/ripples.css',
            'material.roboto' => 'css/roboto.min.css',
            'charts'=>'bower_components/morrisjs/morris.css',
            'fonts'=>'bower_components/font-awesome/css/font-awesome.min.css',
            'bootstrap-datetimepicker' => 'bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
            'redactor' => 'js/lib/redactor/redactor.css',
            'jquery.Jcrop.min.css' => 'js/lib/jcrop/css/jquery.Jcrop.min.css',
            'admin' => 'css/admin.css',
            'cropper' => 'bower_components/cropper/dist/cropper.min.css'
        );
    }


    public function action_list()
    {

        $this->_mass_delete();
        $collection = $this->factory_model();
        $this->menu($collection);
        $fields = $collection->fields_description();
        Event::instance()->dispatch("admin.list.init", $collection);
        $collection = $this->_list_init($collection);
        $this->_search($collection);
//        $ruri = $_SERVER['REQUEST_URI'];
//        if (strpos(URL::base(), $ruri) === 0) {
//            $ruri = substr($ruri, strlen(URL::base()));
//        }
        $pagination = Pagination::factory(array(
            'total_items' => $collection->reset(false)->count_all(),
            'items_per_page' => 30,
        )); //Критично для embeded полей
        $pagination->apply($collection);
        $model = $collection->find_all();
        $this->page->content(
            View::factory("admin/list")
                ->bind('model', $model)
                ->bind('collection', $collection)
                ->bind('request', $this->request)
                ->bind('fields', $fields)
                ->bind('pagination', $pagination)
        );
    }

    public function action_tree()
    {
        $this->page->content(
            View::factory("admin/tree")
                ->bind('model', $model)
                ->bind('collection', $collection)
                ->bind('request', $this->request)
                ->bind('fields', $fields)
                ->bind('pagination', $pagination)
                ->bind('ancestors', $ancestors)
                ->bind('tree_model', $tree_model)
        );
        $id = $this->request->param('id');
        $tree_model = $this->factory_model();
        $tree_model->where('id', '=', $id)->find();
        if (!$tree_model->loaded() && $id) {
            $this->response->status(404);
            throw new HTTP_Exception_404;
        } elseif ($tree_model->loaded()) {
            $ancestors = $tree_model->tree_ancestors()->find_all();
        } else {
            $ancestors = array();
        }
        $this->_mass_delete();
        /** @var Cms_ORM $collection */
        $collection = $this->factory_model();
        if ($this->request->query('search')) {
            if ($tree_model->loaded()) {
                $collection = $tree_model->tree_descendant();
            }
        } else {
            $collection->where($collection->tree_parent_field(), '=', $id);
        }
        $this->menu($collection);
        $fields = $collection->fields_description();
        Event::instance()->dispatch("admin.tree.init", $collection);
        $collection = $this->_list_init($collection);
        $this->_search($collection);
//        $ruri = $_SERVER['REQUEST_URI'];
//        if (strpos(URL::base(), $ruri) === 0) {
//            $ruri = substr($ruri, strlen(URL::base()));
//        }
        $pagination = Pagination::factory(array(
            'total_items' => $collection->reset(false)->count_all()
        )); //Критично для embeded полей
        $pagination->apply($collection);
        $model = $collection->find_all();
    }

    public function action_external_list()
    {
        $this->render = false;
        $this->page->content(
            View::factory("admin/external_list")
                ->bind('model', $model)
                ->bind('collection', $collection)
                ->bind('request', $this->request)
                ->bind('fields', $fields)
                ->bind('pagination', $pagination)
        );
//        $this->_mass_delete();
        $collection = $this->factory_model();
//        $this->menu($collection);
        $fields = $collection->fields_description();
        Event::instance()->dispatch("admin.external_list.init", $collection);
        $collection = $this->_list_init($collection);
        $this->_search($collection);
//        $ruri = $_SERVER['REQUEST_URI'];
//        if (strpos(URL::base(), $ruri) === 0) {
//            $ruri = substr($ruri, strlen(URL::base()));
//        }
        $pagination = Pagination::factory(array(
            'total_items' => $collection->reset(false)->count_all()
        )); //Критично для embeded полей
        $pagination->apply($collection);
        $model = $collection->find_all();
        $this->response->body($this->page->content());
    }

    public function _mass_delete()
    {
        $model = $this->factory_model();

        if ($this->request->post('delete')) {
            if (Authority::cannot('delete', $this->resource(),$this->user)) {
                $this->redirect('admin/panel/403');
            }
            $ids = $this->request->post('model');
            $count = 0;
            if (count($ids) > 0) {
                $model = $model->where("id", "IN", $ids)->find_all();
                $count = count($model);
                foreach ($model as $el) {
                    Event::instance()->dispatch("admin.delete.before", $el);
                    $el = $this->_delete_init($el);
                    $el->delete();
                }
            }
            $list = $this->last_uri;
            $this->page->message("Удалено элементов: " . $count);
//            $this->redirect($list);
        }
    }

    public function action_edit()
    {

        $this->page->content(
            View::factory("admin/edit")
                ->bind('model', $model)
                ->bind('fields', $fields)
                ->bind('blocks', $blocks)

        );

        $model = $this->factory_model();
        Event::instance()->dispatch("admin.edit.init", $model);
        $this->_edit_init($model);

        if ($this->request->param('id') != null) {
            $model->where("id", "=", (int)$this->request->param('id'))->find();
        }
        Event::instance()->dispatch("admin.edit.init.after", $model);
        /** @var Cms_ORM $model */
        $model = $this->_after_edit_init($model);
        $fields = $model->fields_description();
        $blocks = $model->fields_description();
        if ($model instanceof Cms_Interface_Tree) {
            $id2 = $this->request->param('id2');
            if ($id2) {
                $parent = $this->factory_model()->where('id', '=', $id2)->find();
                if (!$parent->loaded()) {
                    $this->response->status(404);
                    throw new HTTP_Exception_404;
                }
                $model->{$model->tree_parent_field()} = $parent->id;
                $this->crumbs[] = array('title' => $parent->{$parent->tree_title_field()}, 'uri' => $parent->tree_url(true));
            }
        }
        if ($model->loaded()) {
            $this->crumbs[] = array('title' => 'Редактировать', 'uri' => '#');
        } else {
            $this->crumbs[] = array('title' => 'Создать', 'uri' => '#');
            if (Authority::cannot('create', $this->resource(),$this->user)) {
                $this->redirect('admin/panel/403');
            }
        }
        if ($this->request->post('save') || $this->request->post('save_and_resume')) {
            Event::instance()->dispatch("admin.edit.save.before", $model);
            $this->_before_save($model);
            $this->values = $this->request->post('model');
            if ($this->_save($model, $this->values, $this->extrl_validation($model))) {
                Event::instance()->dispatch("admin.edit.save.after", $model);
                $this->_after_save($model);
                $this->page->message("Изменения сохранены");
                if ($model instanceof IC_Editable) {
                    if ($this->request->post('save_and_resume')){
                        $new_model = $this->factory_model();
                        if ($model instanceof ORM_Embeded){
                            $parent = $model->{$model->parent_field()};
                            $new_model->{$model->parent_field()} = $parent;
                        }
                        $this->redirect($new_model->edit_url(true));
                     }
                    else{
                        $this->redirect($model->edit_url(true));
                    };
                } else {
                    $this->redirect($this->last_uri);
                }
            } else {
                Component::errors($this->errors);
                $this->page->message("Ошибка при сохранении", Cms_Page::PAGE_MESSAGE_ERROR);
            }
        }
        if ($this->request->post('cancel')) {
            Event::instance()->dispatch("admin.edit.cancel.before", $model);
            $this->_before_cancel($model);
            if ($model instanceof Cms_Interface_Tree) {
                $this->redirect($model->tree_url(true));
            } else {
                $this->redirect($model->list_url(true));
            }
        }
    }

    public function action_delete()
    {
        $model = $this->factory_model();
        if ($this->request->post('delete')) {
//            $ids = $this->request->post('model');
//            $count = 0;
//            if (count($ids) > 0) {
//                $model = $model->where("id", "IN", $ids)->find_all();
//                $count = count($model);
//                foreach ($model as $el) {
//                    $el = $this->_delete_init($el);
//                    $el->delete();
//                }
//            }
//            $list = $this->last_uri;
//            $this->page->message("Удалено элементов: ".$count);
//            $this->redirect($list);
        } else {
            $model->where("id", "=", $this->request->param('id'))->find();
            $list = $model->list_url(true);
            if ($model instanceof Orm_Embeded) {
                $list = $model->parent_url(true);
            }
            if ($this->request->post('cancel')) {
                $this->redirect($list);
            }
            if ($model->loaded() && $this->request->post('save')) {
                Event::instance()->dispatch("admin.delete.before", $model);
                $model = $this->_delete_init($model);
                $model->delete();
                $this->page->message("Элемент удален");
                $this->redirect($list);
            } else {
                $this->page->content(View::factory('admin/delete'));
            }
        }


    }

    protected function _list_init($collection)
    {
        return $collection->order_by('id', 'DESC');
    }



    public function inRoles($roles)
    {
        $roles = explode('|', $roles);
        $r_id = ORM::factory('Role')->where('name', 'in', $roles)->find_all()->as_array('id', 'name');
        return function ($user) use ($roles, $r_id) {
            if (!count($r_id)) {
                return false;
            }
            return $user->roles->where('id', 'in', array_keys($r_id))->count_all() > 0;
        };
    }

    /**
     * Вызывается после попытки загрузить модель
     * @param $model
     * @deprecated следует использовать событие
     */
    protected function _edit_init($model)
    {
        return $model;
    }

    /**
     * Вызывается после попытки предзагрузки модели
     * @param $model
     * @deprecated следует использовать событие
     */
    protected function _after_edit_init($model)
    {
        if(!($model instanceof IC_Translatable) && (!$model->loaded() || !$model->lang())){
            $model->lang = $this->request->param('lang') OR $model->lang = I18n::$lang;
        }
        return $model;
    }

    /**
     * Вызывается перед сохранением модели
     * @param $model
     * @deprecated следует использовать событие
     */
    protected function _before_save($model)
    {
        return $model;
    }

    /**
     * Вызывается после сохранения модели
     * @param $model
     * @param null $values
     * @return void
     * @deprecated следует использовать событие
     */
    protected function _after_save($model, $values = null)
    {
        if ($values) {
            $model->values($values)->save();
        }

    }

    /**
     * Вызывается перед удалением модели
     * @param $model
     * @deprecated следует использовать событие
     */
    protected function _delete_init($model)
    {
        return $model;
    }

    /**
     * @param $model
     * @return mixed
     * @deprecated следует использовать событие
     */
    protected function _before_cancel($model)
    {
        return $model;
    }

    /**
     * @param $model
     */
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
            if($field){
                $type = Arr::get($field,'type');
                if($type=='datetime'){
                    $type='date';
                }
                if ($query===null || $query==="") continue;
//                if (Arr::get($field, 'search')) {
                    switch ($type) {
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

    /* Метод шаблон для установки внешней Валидации при сохранении */
    public function extrl_validation($model)
    {
        return null;
    }

    protected function init_authority()
    {
        $user = $this->user;

        $allow_admin = function ($user) {
            return $user->has('roles', ORM::factory('Role', array('name' => 'admin')));
        };

        //По умолчанию юзерам с ролью админ можно все
        //Но, т.к. действует принцип последнего правила, в методах потомках, мы можем запретить определенным ролям
        //доступ частично или полностью
        Authority::allow('access', 'all', $allow_admin);
        Authority::allow('view', 'all');
        //По умолчанию действия над моделями соответсвуют разрашениям для действия над экшенами
        //Т.е. если разрешено действия "access" к экшену "edit", значит и над моделью этого контроллера
        //разрешено это действие
        //Следовательно чтобы запретить удаление, нужно запретить доступ к экшену:
        // Authority::deny('access','delete');
        Authority::allow('create', 'all', function () use ($user) {
            return Authority::can('access', 'edit', $user);
        });
        Authority::allow('edit', 'all', function () use ($user) {
            return Authority::can('access', 'edit', $user);
        });
        Authority::allow('delete', 'all', function () use ($user) {
            return Authority::can('access', 'delete', $user);
        });

        Authority::allow('list', 'all'); //доступ ко всем меню
//        Authority::allow(,'all',$allow_admin);
    }

    protected function resource()
    {
        return strtolower(Arr::get($this->option, 'model', 'unknown'));
    }

    /**
     * Нет доступа
     */
    public function action_403()
    {
        $this->render = false;
        $view = View::factory('admin/403');
        $view->page = $this->page;
        $view->back_url = URL::site($this->last_uri);
        $this->response->body($view);
    }


}
