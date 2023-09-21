<?php defined('SYSPATH') OR die('No direct access allowed.');


class Cms_ORM extends Kohana_ORM implements IC_Editable, IC_Actions{

    const ACTION_CREATE="CREATE";
    const ACTION_UPDATE="UPDATE";
    const ACTION_DELETE="DELETE";

    public static $_model_types = array();

    public static $_model_langs = array();

    public static $_model_blocks = array(
        'main'=>array(

        ),
        'rt'=>array(

        ),
        'rb'=>array(

        )
    );

    protected $_list_title;
    protected $_edit_title;

    public $_default_values = array();

    /**
     * метод для генерации поисковой формы в админке
     * формат:
     * array(
     *  'search'=>array(список полей для текстового поиска)
     *  'flags'=>array(список полей для поиска по атрибутам(опубликовано,категория,флаги и тд.
     *     поле => array( //не обязательно, можно просто вывести поля списком или указать в массиве range,
     *                    //если требуется указывать в формате ОТ-ДО
     *      'range'=>TRUE/FALSE //не обязательно
     *   )
     *  )
     * )
     * @return array
     */
    public function search_form(){
        return array(
            'search'=>array(),
            'flags'=>array()
        );
    }

    public function list_title(){
        return $this->_list_title;
    }

    public function edit_title(){
        return $this->_edit_title;
    }




    /**
     * @var string Язык по умолчанюи для моделей
     */
    protected $_default_lang='ru';
    /**
     * Признак необходимости логирования изменений
     * @deprecated
     * @var bool
     */
    protected $_need_log=false;

    protected $_action_type;

    protected $_route;
    /**
     * Массив значений которые будут сохранены после создания модели
     * Используется при присваивании значений к has_many полям
     * @var array
     */
    protected $_deffered_values=array();
    /**
     * Массив "частичных моделей" это модели для хранения переводимых полей
     * Например если таблица называется pages то ее переводимые поля должны хранится в page_partials
     * Имя частичной модели формируется путем добавления к имени текущей модели суфикса _Partial
     * Каждый ключ в данном массиве соотвествует языковому коду, а его значение загруженная модель с этим языком
     * @var array
     */
    protected $_partial_models=array();

    public $pagination;

    /**
     * Получить значения поля по его имени
     * Данный метод используется при формировании списка элементов в админке, а также в Cms_ORM::as_array_extended()
     * Применяется для подмены оригнального значения с целью улучшения вывода, например подмена полного текста на обрезанный
     * или подмена ключа на название
     * @param string $field
     * @return mixed
     */
    public function get_field($field)
    {
        return $this->__get($field);
    }

    /**
     * Переопределенный метод, поддерживает два механизма мультязычности на осное "частичных моделей"
     * и на основе языковых суфиксов у моделей
     * @param string $column
     * @return mixed
     * @throws Exception
     */
    public function __get($column) {
        /** @var Cms_ORM $this */
        if ($this instanceof Cms_Interface_Partial){
            $desc=$this->fields_description();
            if (isset($desc[$column]) && isset($desc[$column]['partial']) && $desc[$column]['partial']){
                $value=$this->get_partial_field($column,I18n::$lang);
                if (empty($value)){
                    $value=$this->get_partial_field($column,$this->_default_lang);
                }

                return $value;
            }

        }

        try
        {
            return parent::__get($column);
        } catch (Exception $e)
        {
            try
            {
                $value=parent::__get($column."_".I18n::lang());
                if (empty($value))
                {
                    $value=parent::__get($column."_".$this->_default_lang);
                }

                return $value;
            } catch (Exception $e2)
            {
                throw $e;
            }
        }
    }

    public function save(Validation $validation = NULL)
    {

        parent::save($validation);
        if (count($this->_deffered_values)>0){
            $this->values($this->_deffered_values);
            $this->_deffered_values=array();
            $this->save();
        }
        if ($this instanceof ISearchable) {
            $this->reindex();
        }
        if ($this instanceof Cms_Interface_Partial){
            foreach ($this->_partial_models as $model){
                $model->object_id=$this->id; //На случай если айди не был раньше установлен по причине не загруженности модели
                $model->save();
            }
        }
        if ($this instanceof Cms_Interface_Tree){
            $this->tree_update(); //Обновление структуры дерева
        }
        return $this;
    }

    public function delete()
    {
        Database::instance()->begin();
        try {
        if ($this instanceof ISearchable) {
            Elastic_Search::instance()->delete($this);
        }
        if ($this instanceof Cms_Interface_Tree){
            $this->tree_delete();//Обновление структуры дерева
        }

            $r=parent::delete();
            Database::instance()->commit();
        } catch (Exception $e){
            Database::instance()->rollback();
            throw $e;
        }
        return $r;

    }

    public function update(Validation $validation = NULL)
    {
        $this->_action_type = ORM::ACTION_UPDATE;
        //Фикс бага. Нужно выполнять валидацию в случае если не было изменений в модели, но внешний валидатор пришел
        if (empty($this->_changed) && $validation!=NULL)
        {
            // Nothing to update
            $this->check($validation);
        }


        parent::update($validation);


        return $this;
    }

    public function check(Validation $extra_validation = NULL)
    {
        if ($this instanceof Cms_Interface_Partial){
            foreach ($this->_partial_models as $model){
                $model->check(); //Побочный эфект: не произойдет валидации основной модели, только частичной
            }

        }
        return parent::check($extra_validation);

    }


    /**
     * Возвращает тип действия которое произошло c моделью (UPDATE, CREATE, DELETE)
     * Работает только если исползуется метод ORM::save() или ORM::delete()
     * @deprecated Метод юзался при логировании, логирование будет вынесено из класса
     * @return string
     */
    public function action_type()
    {
        return $this->_action_type;

    }

    /**
     * Возвращает ORM модель последней записи в логе связанной с данной моделью
     * или FALSE в случаи отсутсвия таковой
     * @deprecated Логирование будет вынесено за пределы класса
     * @return bool|ORM
     */
    public function get_last_change_log()
    {
        if (!$this->_need_log) return false;
        $log=ORM::factory('user_log')->where('class','=',get_class($this))->where('pk','=',$this->pk())->order_by('datetime','DESC')->find();
        if (!$log->loaded()) return false;
        return $log;
    }
    /**
     * Доступ к логам модели, вернет не загруженную ORM модель, сделанно для того чтобы можно было установить до условия и лимиты
     * @deprecated Логирование будет вынесено за пределы класса
     * @return bool|ORM
     */
    public function get_logs()
    {
        if (!$this->_need_log) return false;
        $log=ORM::factory('user_log')->where('class','=',get_class($this))->where('pk','=',$this->pk());
        return $log;
    }

    /**
     * Урл для просмотра
     */
    public function view_url($uri = false)
    {
        $_uri = $this->_route."/view/{$this->id}";

        return $uri ? $_uri : URL::site($_uri);
    }

    /**
     * Урл для редактирования
     */
    public function edit_url($uri = false)
    {
        $id=intval($this->id);
        $params = array(
            'model'=>$this->object_name(),
            'action'=>'edit',
            'id'=>$id
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

    /**
     * Урл для вызова внешнего списка, используется в external_select
     * @param bool $uri
     * @return string
     */
    public function external_list($uri = false){
        $params = array(
            'model'=>$this->object_name(),
            'action'=>'external_list',
            'id'=>$this->id,
        );
        $_uri = Route::get('admin')->uri($params);
        return $uri ? $_uri : URL::site($_uri);
    }

    /**
     * Урл для удаления
     */
    public function delete_url($uri = false)
    {
        $params = array(
            'model'=>$this->object_name(),
            'action'=>'delete',
            'id'=>$this->id,
        );
        $_uri = Route::get('admin')->uri($params);
        return $uri ? $_uri : URL::site($_uri);
    }

    /**
     * Урл списка элементов
     * @param bool $uri
     * @return string
     */
    public function list_url($uri = false)
    {

        $params = array(
            'model'=>$this->object_name(),
            'action'=>'list',
        );
        if(count($this::$_model_langs) AND ($lang=$this->lang() OR $lang=Request::$current->param('lang'))){
            $params['lang'] = $lang;
        }
        $_uri = Route::get('admin')->uri($params);

        return $uri ? $_uri : URL::site($_uri);
    }

    /**
     * Проверка прав
     * @param $action Действие для которого проверяются права (edit|delete|view)
     * @param $user Пользователь для которого идет проверка (тип зависит от реализации)
     * @deprecated
     * @return boolean
     */
    public function permission($action, $user)
    {
        return true;
    }

    /**
     * Метаданные описывающие модель
     * @todo Переименовать методв во чтото более короткое
     * @return array
     */
    public function fields_description()
    {
        return array();
    }

    /**
     * Автогенератор подписей к полям для ошибок валидации
     * @return array
     */
    public function labels()
    {
        $fields = $this->fields_description();
        $data = array();
        foreach ($fields as $name => $value) {
            if (isset($value['label'])) {
                if (isset($value['params']) && isset($value['params']['widget']) && $value['params']['widget']=='multilang'){
                    $data[$name."_ru"] = $value['label'];
                    $data[$name."_kz"] = $value['label'];
                    $data[$name."_en"] = $value['label'];
                } else {
                    $data[$name] = $value['label'];
                }
            }
        }
        return $data;
    }

    /**
     * Расширенный метод присваивания, умеет работать с has_many молями и частичными моделями
     * @param string $column
     * @param mixed $value
     * @return $this|ORM
     */
    public function set($column, $value)
    {
        if (isset($this->_has_many[$column])) {
            $value = $this->run_filter($column, $value);
            $this->set_multiple($column, $value);
            return $this;
        }
        /** @var Cms_ORM $this */
        if ($this instanceof Cms_Interface_Partial){
            if ($column=='partials'){
                foreach ($value as $lang=>$values){
                    foreach ($values as $f=>$v){
                        if (Valid::not_empty($v)){
                            $this->set_partial_field($f,$v,$lang);
                        }
                    }
                }
                return $this;
            }
        }

        return parent::set($column, $value);
    }

    /**
     * Расширенный метод для работы с has_many полями и частичными моделями
     * @param array $values
     * @param array $expected
     * @return ORM
     */
    public function values(array $values, array $expected = NULL)
    {
        if ($expected === NULL) {
            $expected = array_merge(array_keys($this->_table_columns), array_keys($this->fields_description()));

            if ($this instanceof Cms_Interface_Partial){
                $expected[]="partials";
            }

            // Don't set the primary key by default
            unset($values[$this->_primary_key]);
        }
        return parent::values($values, $expected);
    }

    /**
     * Метод для присвоения значений has_many алисасам, содержамщим through таблицу
     * @param $field
     * @param $values
     */
    public function set_multiple($field, $values)
    {
        if (!$this->loaded()) {
            $this->_deffered_values[$field] = $values;
            return;
        }
        if (isset($this->_has_many[$field]['through'])) {
            $this->remove($field);
            $values = array_diff($values, array(0)); //Удаляет элемент со значением 0

            if ($values)
                $this->add($field, $values);
        } else {
            $related = $this->{$field}->table_name();
            $fk = $this->_has_many[$field]['foreign_key'];

            $sql = DB::query(Database::DELETE, "DELETE FROM {$related} WHERE {$fk} = :id")->parameters(array(
                    ":table" => $related,
                    ":fk" => $fk,
                    ":id" => $this->pk()
                )
            );

            $sql = $sql->compile();
            $res = DB::query(Database::DELETE, $sql)->execute();
//            $values = array_diff($values, array(0=>array())); //Удаляет элемент со значением 0
            foreach ($values as $row) {
                if (is_array($row)) {
                    $_model = ORM::factory($this->_has_many[$field]['model']);
                    $_model->values($row);

                    $_model->{$fk} = $this->pk();
                    try {
                        $_model->save();
                    } catch (ORM_Validation_Exception $e) {

                    }
                }

            }
        }
    }



    /**
     * Возрвщает массив ключ значения для для таблицы, пригодно для использвания внутри Form::select
     * @param string $id Значения для ключе массива
     * @param null $title Значение для значений массива
     * @param string $order_by направление сортировки, в качестве поля используется $title
     * @return array
     */
    public function select_options($id = 'id', $title = null, $order_by = 'ASC')
    {
        $order_field = $title ? $title : $id;
        return $this->reset(false)->order_by($order_field,$order_by)->find_all()->as_array($id, $title);
    }

    /**
     * Массив списка действий над моделью в админке
     * Структура:
     * array(
            array(
                'title'=> //Название действия
     *          'uri'=> //uri для выполения действия
     *          'type'=> //не обязательный параметр, может принимать значения submenu (подменю) или divider (разделитель)
     *      ),
     * )
     * @param null $user
     * @return array
     */
    public function actions($user=null)
    {
//        $view = array(
//            'title' => 'Просмотр',
//            'uri' => $this->view_url(true)
//        );
        $edit = array(
            'title' => 'Редактировать',
            'uri' => $this->edit_url(true),
            'class'=>'fa-edit'
        );
        $delete = array(
            'title' => 'Удалить',
            'uri' => $this->delete_url(true),
            'class'=>'fa-times'
        );
        $menu = array(
//            $view,
//            $edit,
//            $delete,
        );
//        Authority::can('view',$this->object_name(),$this) && $menu[]=$view;
        Authority::can('edit',$this->object_name(),$this) && $menu[]=$edit;
        Authority::can('delete',$this->object_name(),$this) && $menu[]=$delete;
        return $menu;
    }

    /**
     * @deprecated вместо данного метода нужно использовать Pagination::apply() подробнее в Cms_Admin::action_list()
     * @param int $per_page
     * @param bool $lang
     */
    public function pagination($per_page = 10, $lang = true)
    {
        if ($lang) $this->lang();

        $pagin = Pagination::factory(array(
                'items_per_page' => $per_page,
                'total_items' => $this->reset(false)->count_all()
            )
        );
        $pagin->apply($this);
        $this->pagination = $pagin->render();
    }


    /**
     * Расширенный метод, умеет автоматом джойнить has_many таблицу и строить условие по внешнему ключу
     * @param mixed $column
     * @param string $op
     * @param mixed $value
     * @return $this
     */
    public function where($column, $op, $value)
    {
        if (!is_object($column) && isset($this->_has_many[$column])) {
            if (isset($this->_has_many[$column]['through'])) {
                $through = $this->_has_many[$column]['through'];
                $fgk = $this->_has_many[$column]['foreign_key'];
                $fk = $this->_has_many[$column]['far_key'];
                $this->join($through);

                $this->on("$through.$fgk", '=', "{$this->object_name()}.{$this->primary_key()}");
                return parent::where($fk, $op, $value);
            }
        }
        return parent::where($column, $op, $value);
    }

    /**
     * Выолняет count_all() для запрос с групирвокой
     * Медленный метод, не желательно его использовать
     * @return mixed
     */
    public function group_count()
    {
        $selects = array();

        foreach ($this->_db_pending as $key => $method) {
            if ($method['name'] == 'select') {
                // Ignore any selected columns for now
                $selects[] = $method;
                unset($this->_db_pending[$key]);
            }
        }

        if (!empty($this->_load_with)) {
            foreach ($this->_load_with as $alias) {
                // Bind relationship
                $this->with($alias);
            }
        }

        $this->_build(Database::SELECT);

        $last = $this->_db_builder->from(array($this->_table_name, $this->_object_name))->select($this->_object_name.'.*')->__toString();


        // Add back in selected columns
        $this->_db_pending += $selects;

        $this->reset();

//        Return the total number of records in a table
//        $last=$this->_db->last_query();
        $q = DB::query(Database::SELECT, "SELECT COUNT(*) as count FROM (:sub) as t");
        $q2 = Db::expr($last);
        $q->bind(':sub', $q2);
        return $q->execute()->get('count');
    }


    public function lang()
    {
        if(isset($this->lang)){
            return $this->lang;
        }
        return false;
    }

    /**
     * Возвращает массив ключей, преобразованных в строку
     * в строку преобразуется для использования на строне клиента в js
     * устраняет неоднозначнность, чтобы числовые значения в JSON шли как строки
     * используется в Cms_API
     * @param string $id
     * @param string $order_field
     * @param string $order_direction
     * @return array
     */
    public function select_keys($id='id',$order_field='id',$order_direction='asc'){
        $selected_options=array_keys($this->select_options($id,$order_field,$order_direction));
        return array_map('strval',$selected_options);
    }


    /**
     * Тоже самое что и as_array, но для получения значения полей используется get_field
     * используется в Cms_API
     * @return array
     */
    public function as_array_ext($fields = array(),$action = null){
        $object = array();

        $fields_description = $this->fields_description();
        $fields_description = count($fields_description)>0?$fields_description:$this->_object;
        foreach ($fields_description as $column => $value)
        {
            // Call __get for any user processing
            $object[$column] = $this->get_field($column);
        }

//        foreach ($this->_related as $column => $model)
//        {
//            // Include any related objects that are already loaded
//            $object[$column] = $model->as_array();
//        }

        return $object;
    }

    /**
     * Метод используется в классе Cms_API для получения списка кнопок
     */
    public function buttons(){
        return array(
            'list'=>array(
                array('type'=>'link','title'=>'Добавить','link'=>$this->edit_url(),'class'=>'btn-success'),
                array('type'=>'button','title'=>'Удалить','click'=>'$deleteModels','class'=>'btn-danger'),
            ),
            'edit'=>array(
                array('type'=>'button','title'=>'Сохранить','click'=>'$saveModel','class'=>'btn btn-success'),
                array('type'=>'button','title'=>'Назад','click'=>'$cancelModel','class'=>'btn'),
                array('type'=>'button','title'=>'Удалить','click'=>'$deleteModel','class'=>'btn btn-danger')
            ),
            'search'=>array(
                array('type'=>'button','title'=>'Поиск','click'=>'$search','class'=>'btn btn-success'),
                array('type'=>'button','title'=>'Сбросить','click'=>'$searchReset','class'=>'btn'),
            ),
        );
    }
    
     /**
     * Фильтр для фильтрации html
     * c исп. сторонней либы
     * htmlpurifier
     */

    public static function clear_html($dirty_html)
    {
        require_once Kohana::find_file('vendors/htmlpurifier/library/','HTMLPurifier.auto');

        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.SafeIframe', true);
//        $config->set('URI.SafeIframeRegexp', '%^http://(www.youtube(?:-nocookie)?.com/embed/|player.vimeo.com/video/)%'); //allow YouTube and Vimeo
        $config->set('URI.SafeIframeRegexp', '%^http(s)+://(www.youtube(?:-nocookie)?.com/embed/|player.vimeo.com/video/)%'); //allow YouTube and Vimeo
        $config->set('Attr.AllowedFrameTargets', array("_blank"));
        $purifier = new HTMLPurifier($config);
        $clean_html = $purifier->purify($dirty_html);
        return $clean_html;
    }

    public function ng_editRoles(){
        return array();
    }

    public function ng_listRoles(){
        return array();
    }

    public function ng_edit_url($uri = false)
    {
        return $this->_object_name."/edit/"; // TODO: Change the autogenerated stub
    }

    public function ng_list_url($uri = false)
    {
        return $this->_object_name."/list/"; // TODO: Change the autogenerated stub
    }

    public function ng_buttons(){
        return array(
            'list'=>array(
                array('type'=>'button','title'=>'Добавить','link'=>'#','click'=>'$editModel','class'=>'btn-success'),
                array('type'=>'button','title'=>'Удалить','link'=>'#','click'=>'$deleteModels','class'=>'btn-danger'),
            ),
            'edit'=>array(
                array('type'=>'button','title'=>'Сохранить','link'=>'#','click'=>'$saveModel','class'=>'btn btn-success'),
                array('type'=>'button','title'=>'В список','link'=>'#','click'=>'$cancelModel','class'=>'btn'),
                array('type'=>'button','title'=>'К родителю','link'=>'#','click'=>'$parentModel','class'=>'btn'),
                array('type'=>'button','title'=>'Удалить','link'=>'#','click'=>'$deleteModel','class'=>'btn btn-danger')
            ),
            'search'=>array(
                array('type'=>'button','title'=>'Поиск','link'=>'#','click'=>'$search','class'=>'btn btn-success'),
                array('type'=>'button','title'=>'Сбросить','link'=>'#','click'=>'$searchReset','class'=>'btn'),
            ),
        );
    }

    public function ng_actions($user=null)
    {
        $menu = array(
            array(
                'title' => 'Просмотр',
//                'link' => '#'
            ),
            array(
                'title' => 'Редактировать',
                'click' => '$editModel',
//                'link'=>'',
            ),
            array(
                'title' => 'Удалить',
//                'link'=>'',
//                'link' => $this->delete_url()
                'click' => '$deleteModel'
            ),
        );
        return $menu;
    }

    /**
     * Возвращает "частичную модель" для текущей модели в случае если модель реализует Cms_Interface_Partial
     * @return ORM
     * @throws Kohana_Exception
     */
    public function partial_model(){
        /** @var Cms_ORM $this */
        if (!($this instanceof Cms_Interface_Partial)){
            throw new Kohana_Exception("This object doesn't implement Cms_Interface_Partial");
        }
        $name=substr(get_class($this),6);
        return ORM::factory($name."_Partial");

    }

    /**
     * Возвращает поле из частичной модели в зависимости от языка
     * !!! сохранения при этом не происходит, для сохранения нужно вызывать метод save у текущей модели
     * @param $field Имя поля в частичной модели
     * @param $lang Язык
     * @return mixed
     */
    public function get_partial_field($field,$lang){
        if (isset($this->_partial_models[$lang])){
            return $this->_partial_models[$lang]->{$field};
        }
        $this->_partial_models[$lang]=$this
            ->partial_model()
            ->where('object_id','=',$this->pk())
            ->where('lang','=',$lang)
            ->find()
        ;
        return $this->_partial_models[$lang]->{$field};
    }

    /**
     * Устанавливает значение в поле частичной модели с учетом языка
     * !!! сохранения при этом не происходит, для сохранения нужно вызывать метод save у текущей модели
     * @param $field
     * @param $value
     * @param $lang
     */
    public function set_partial_field($field,$value,$lang){
        if (!isset($this->_partial_models[$lang])){
            $this->_partial_models[$lang]=$this
                ->partial_model()
                ->where('object_id','=',$this->pk())
                ->where('lang','=',$lang)
                ->find()
            ;
        }
        if (!$this->_partial_models[$lang]->loaded()){
            $this->_partial_models[$lang]->object_id=$this->id;
            $this->_partial_models[$lang]->lang=$lang;
        }

        $this->_partial_models[$lang]->{$field}=$value;

    }

    /**
     * Родительское поле в структуре дерева
     * @return string
     */
    public function tree_parent_field(){
        return "parent_id";
    }

    /**
     * Текстовое поле играющее роль "навзания" в дереве
     * @return string
     */
    public function tree_title_field(){
        return "title";
    }

    /**
     * Возвращает модель хранящее дерево для текущей модели
     * @return ORM
     */
    public function tree_model(){
        $name=substr(get_class($this),6);
        $name="{$name}_Tree";
        return ORM::factory($name);
    }

    /**
     * Обновляет структуру дерева для текущего узла
     */
    public function tree_update(){
        /** @var Cms_Model_Tree $model */
        $model=$this->tree_model();
        $model->insert_node($this->id,$this->{$this->tree_parent_field()});
    }

    /**
     * Удалеят текущий узел из дерева, не трогая при этом его дочернии
     */
    public function tree_delete(){
        /** @var Cms_Model_Tree $model */
        $model=$this->tree_model();
        $model->remove_node($this->id);
    }

    /**
     * Вернет всех предков для текущего узла
     * @return mixed
     */
    public function tree_ancestors(){
        $model=$this->tree_model();
        $class=get_class($this);
        $my_model=new $class;
        return $my_model
            ->join(array($model->table_name(),'path'))->on("path.a",'=',$this->object_name().".id")
            ->where('path.d','=',$this->pk())
            ->where('path.a','!=',$this->pk())
            ->order_by('path.l','desc');
    }

    /**
     * Вернет всех потомков для текущего узла
     * @return mixed
     */
    public function tree_descendant(){
        $model=$this->tree_model();
        $class=get_class($this);
        $my_model=new $class;
        return $my_model
            ->join(array($model->table_name(),'path'))->on("path.d",'=',$this->object_name().".id")
            ->where('path.a','=',$this->pk())
            ->where('path.d','!=',$this->pk())
            ->order_by('path.l','asc');
    }

    /**
     * Урл для просмотра дерева
     * @param bool $uri
     * @return string
     */
    public function tree_url($uri=false){
        $_uri = $this->route()."/tree".($this->id?"/{$this->id}":'');

        return $uri ? $_uri : URL::site($_uri);
    }

    /**
     * Исползьзуется в качестве фильтра, для преобразования пустого значения в null
     * Применяется когда внешнему ключу нужно установить NULL, но форма может прислать только 0 или пустую строку
     * @param $value
     * @return null
     */
    public static function to_null($value){
        if (empty($value)){
            return null;
        }
        return $value;
    }

    public static function to_numeric($value){
        return str_replace(".",",",$value);
    }

    /**
     * Генерация роута, меняет поведение в зависимости от нахождения в админки или публичной части
     * @return string
     */
    public function route()
    {
        return (Request::current()->directory() == 'Admin') ? Route::get('admin')->uri() . "/{$this->_route}" : "{$this->_route}";
    }

    public static function latin($s, $reverse = false)
    {
        $arr_in = array('/kk/', 'Ә', 'Ө', 'Ү', 'Ұ', 'Ң', 'Ғ', 'Қ', 'Һ', 'ә', 'ө', 'ү',
            'ұ', 'ң', 'ғ', 'қ', 'һ', "А", "а", "Ә", "ә", "Б", "б", "В", "в", "Г", "г", "Ғ", "ғ", "Д", "д", "Е", "е",
            "Ё", "ё", "Ж", "ж", "З", "з", "И", "и", "Й", "й", "К", "к", "Қ", "қ", "Л", "л", "М", "м", "Н", "н", "Ң", "ң", "О", "о", "Ө", "ө", "П",
            "п", "Р", "р", "С", "с", "Т", "т", "У", "у", "Ұ", "ұ", "Ү", "ү", "Ф", "ф", "Х", "х", "Һ", "һ", "Ц", "ц", "Ч", "ч", "Ш", "ш", "Щ", "щ",
            "ъ", "Ъ", "Ы", "ы", "І", "і", "ь", "Ь", "Э", "э", "Ю", "ю", "Я", "я");

        $arr_out = array('/la/', 'Ә', 'Ө', 'Ү', 'Ұ', 'Ң', 'Ғ', 'Қ', 'Һ', 'ә', 'ө', 'ү', 'ұ', 'ң', 'ғ', 'қ', 'һ', "A", "a", "Ä", "ä", "B", "b", "V", "v", "G",
            "g", "Ğ", "ğ", "D", "d", "E", "e", "Yo", "yo", "J", "j", "Z", "z", "Ï", "ï", "Y`", "y`", "K", "k", "Q", "q", "L", "l", "M", "m", "N",
            "n", "Ñ", "ñ", "O", "o", "Ö", "ö", "P", "p", "R", "r", "S", "s", "T", "t", "W", "w", "U", "u", "Ü", "ü", "F", "f", "X", "x", "H", "h",
            "C", "c", "Ç", "ç", "Ş", "ş", "Şş", "şş", "ʺ", "ʺ", "I", "ı", "İ", "i", "ʹ", "ʹ", "É", "é", "Yu", "yu", "Ya", "ya");

        if ($reverse) {
            foreach ($arr_out as $k => $v) {
                $s = str_replace($v, $arr_in[$k], $s);
            }
        } else {
            foreach ($arr_in as $k => $v) {
                $s = str_replace($v, $arr_out[$k], $s);
            }
        };


        return $s;
    }

    public static function translit($str)
    {
        $replace = array(
            'а' => 'a',
            'ә' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'ғ' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'e',
            'ж' => 'zh',
            'з' => 'z',
            'й' => 'i',
            'и' => 'i',
            'к' => 'k',
            'қ' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'ң' => 'n',
            'о' => 'o',
            'ө' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ү' => 'u',
            'ұ' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'һ' => 'h',
            'ц' => 'ts',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shch',
            'ъ' => '',
            'ы' => 'i',
            'і' => 'i',
            'ь' => "",
            'э' => 'e',
            'ю' => 'u',
            'я' => 'ya',
            ' ' => '_',
        );

//        $str = Utf8::substr($str, 0, 50);
        $str = UTF8::strtolower($str);
        $str = strtr($str, $replace);
        $str = trim($str);
        $str = preg_replace("/[^\w0-9_']/i", "", $str);
        $str = trim($str, "_");
        return $str;
    }



    public function date()
    {
        if ($this->loaded()) {
            return Date::formatted_time($this->date, 'd.m.Y h:i');
        };
        return '';
    }

    public static function filter_sef($value, $model, $field)
    {
        if ($value == '') {
            $value = ORM::translit($model->$field);
        }
        return $value;
    }

    public function ordinal_date()
    {
        if ($this->loaded()) {
//            if(Date::formatted_time($this->date,'Y')<Date::formatted_time('now','Y')){
            $date = explode(' ', date('Y d m H:i', strtotime($this->date)));
            list($year, $day, $month, $time) = $date;
            if (I18n::$lang == 'en') {
                return sprintf('%d %s %d %s', $day, $this->ordinal_month_name($month), $year, $time);
            }
            return sprintf('%d %s %d %s %s', $day, $this->ordinal_month_name($month), $year, __("г"), $time);
//            }else{
//                $date = explode(' ', date('d m H:i', strtotime($this->date)));
//                list($day, $month, $time) = $date;
//                return sprintf('%d %s,  %s', $day, $this->ordinal_month_name($month), $time);
//            }

        };
        return '';
    }


    public function ordinal_month_name($month)
    {
        return __(Arr::get(explode(' ', self::$ordinal_months), $month - 1));
    }


    public static $ordinal_months = 'января февраля марта апреля мая июня июля августа сентября октября ноября декабря';


    public static $langs = array(
        'ru' => 'ru',
        'en' => 'en',
        'kz' => 'kz',
    );

}