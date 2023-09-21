<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Основной контроллер CMS
 * Имеет обобщенные возможности
 */
class Cms_Controller extends Controller
{
    /**
     * Отображение контроллера
     * @var View
     */
    public $template='template';

    /**
     * Рендер главной вьювки, если false то нужно в ручную послать ответ
     * через $this->response->body, иначе автоматически будет послана вьювка $this->template
     * @var bool
     */
    public $render=true;

    /**
     * Последний отображенный uri
     * @var string
     */
    public $last_uri;
    public $write_lst_uri = true;

    /**
     * Глобальный массив ошибок, ключ идентификатор ошибки, значение - текствое представление ошибки
     * @var array
     */
    public $errors=array();
    /**
     * @var Cms_Page Объект содержащий информацию о странице
     */
    public $page;

    public $session;

    protected $_csrf;

    protected $_need_csrf=false;

    public function before()
    {
        parent::before();

        $this->session OR $this->session=Session::instance();

        $this->csrf();

        $this->last_uri=$this->session->get('last_uri',URL::base());

        View::bind_global('errors', $this->errors);

        $this->lang_detection('');

        $this->template=View::factory($this->template);

        $this->page=new Cms_Page();

        foreach($this->scripts() as $name=>$path){
            $this->page->script($name,$path);
        }

        foreach($this->styles() as $name=>$path){
            $this->page->style($name,$path);
        }


        View::bind_global('page',$this->page);

    }

    public function after()
    {
        if ($this->render)
        {
            $this->response->body($this->template->render());
            if($this->write_lst_uri)
               Session::instance()->set('last_uri', $this->current_url());
        }

        $this->page->save_messages();

        if ($this->_need_csrf){
            $this->csrf();
        }

        parent::after();
    }

    public function current_url()
    {
        return $this->request->uri().URL::query($this->request->query());
    }

    /**
     * Позволяет сохранить данные пришедшии методом post, в указанную модель $model
     * @param ORM|mixed $model Модель или переменная или имя модели
     * @param null|Validation $external Объект дополнительной валидации
     * @param null|array $expected Значения данного массива будут использованы для фильтрации массива сохраняемых значений
     * @return bool|ORM
     */
    protected function _save(&$model,$values,$external=null, $expected=null)
    {


        try {
            if (!($model instanceof ORM)){
                $model = ORM::factory($model);

                $model->values($values,$expected);
            }
            else {
                $model->values($values,$expected);
            }
            $model->save($external);
        } catch (ORM_Validation_Exception $e) {
            $this->errors=array_merge($this->errors,$e->errors('model'));
            if (isset($this->errors['_external']))
                $this->errors=array_merge($this->errors,$this->errors['_external']);
            return false;
        }
        return $model;
    }

    /**
     * Если передана страка в качестве первого параметра, то вторым аргументов нужно передать значение первичного ключа
     * Если первым параметром передана модель, то она должна быть уже загружена
     * @param ORM|string $model Название модели или загруженная модель
     * @param null $id Значение первичного ключа для поиска модели
     */
    protected function _delete($model,$id=null)
    {
        if (!($model instanceof ORM))
        {
            $model=ORM::factory($model,$id);
        }

        if($model->loaded())
        {
            $model->delete();
        } else {
            throw new HTTP_Exception_404(
                "Model :class with primary key :id not found",
                array(':class'=>get_class($model), ':id'=>$id)
            );
        }
    }

    /**
     * Создает пагинатор для модели, и устанавливает в модели офсет и лимит
     * @static
     * @param $model ORM
     * @param bool|string $config Название конфига для пагинатора
     * @return Pagination
     */
    public static function pagination(&$model,$config='pagination.default')
    {
        $config = Kohana::$config->load($config);
        $config['total_items'] = $model->reset(false)->count_all();
        $pagination = Pagination::factory($config);
        $model->limit($pagination->{'items_per_page'})->offset($pagination->{'offset'});
        return $pagination;
    }

    /**
     * Установка текущего языка
     * @param string $param query|param Бразть из запроса или роута
     * @param bool $cookie Сохранять язык в кукисы или нет. По умолчанию да.
     */
    public function lang_detection($param="query",$cookie=true)
    {
        if ($param=="query")
        {
            $lang=strval($this->request->query('lang'));
        } else {
            $lang=strval($this->request->param('lang'));
        }
        if ($lang AND preg_match("/^(ru|en|kz)$/",$lang))
        {
            I18n::lang($lang);
            Session::instance()->set('lang',$lang);
            $cookie AND Cookie::set('lang',$lang);
        } else {
            $lang=Session::instance()->get('lang',false);
            $lang OR $cookie AND ($lang=Cookie::get('lang',false));
            $lang AND I18n::lang($lang);
        }
    }

    public function csrf_check(){
        $reqeust_token=$this->request->headers('x-csrf-token');
        $session_token=$this->session->get('csrf-token');
        return $reqeust_token===$session_token;
    }

    public function csrf(){
        $token=$this->session->get('csrf-token');
        if (!$token){
            $token=hash_hmac("sha256",time(),Cookie::$salt);
            $this->session->set('csrf-token',$token);
        }
        return $token;
    }

    public function action_csrf()
    {
        $this->page->content((View::factory('admin/csrf')->bind('url',$url)));
        $url=$this->current_url();

    }


    public function scripts(){
        return array();
    }

    public function styles(){
        return array();
    }
}
