<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Контроллер с поддержко авторизации через модуль Auth
 * Поддерживает ограничение доступа по ролям
 */
abstract class Cms_Controller_Auth extends Cms_Controller
{
    /**
     * @var Model_User Текущий пользователь
     */
    protected $user;

    /**
     * @var string URI для входа
     */
    protected $login_uri = "user/login";
    /**
     * @var bool Признак необходимости авторизации
     */
    protected $need_auth = false;

    public static function isSecure() {
        return
            (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
            || $_SERVER['SERVER_PORT'] == 443;
    }

    public static function domain() {
        return (Site::isSecure()?'https':'http').'://'.$_SERVER['HTTP_HOST'].'/';
    }

    public function before()
    {
        parent::before();

        $this->user_detection();

        if ($this->need_auth()) {
            if (!$this->user) {
                $this->_login();
            } else {
                Authority::initialize($this->user); //По сути этот метод нам не нужен
                $this->init_authority(); //Метод который добавит все необходимые правила
                $this->check_permission(); //Первый уровень проверки, проверка доступа к контроллеру
            }
        }

    }

    /**
     * Получает юзера через модуль Auth
     */
    public function user_detection()
    {
        $this->user = Auth::instance()->get_user();
        if (!$this->user) {
//            $this->user=Auth::instance()->auto_login();
        }
        View::bind_global('user', $this->user);
    }

    /**
     * Отправляет на страницу входа, запоминает в сессию URI на который нужно вернутся
     */
    protected function _login()
    {
        Session::instance()->set('after_login', $this->request->uri());
        $this->redirect($this->login_uri);
    }

    /**
     * Выход
     */
    public function action_logout()
    {
        if ($this->user) {
            $this->_logout();
        }
        $this->redirect(URL::base());
    }

    /**
     * Метод для разлогивания юзера
     */
    protected function _logout()
    {
        Auth::instance()->logout();
        Session::instance()->destroy();
        Cookie::delete('authautologin');
    }

    /**
     * Проверяет права доступа юзера
     * Первый этап
     * @throws HTTP_Exception_403
     */
    protected function check_permission()
    {
        $allow = false;
        //Может ли юзер использовать этот контроллер
        $allow=Authority::can('access',$this->request->controller(),$this->user);
        //Может ли юзер использовать этот экшен
        $allow=$allow && Authority::can('access',$this->request->action(),$this->user);
        if (!$allow) {
            $this->response->status(403);
            throw new HTTP_Exception_403("You don't have permission to access :uri", array(':uri' => $this->request->uri()));
        }
    }

    /**
     * Настройка ролей
     *
     * Пример конфигурации:
     * <code>
     * return array(
     *     'controller_roles'=>array(
     *          'login', //Доступ только залогиненым
     *      ),
     *     'actions_roles'=>array(
     *          'edit'=>array(      //Ограничение доступа к экшену
     *              'admin',        //Разрешение на использование экшена, только админу
     *          ),
     *      )
     *);
     * </code>
     * @deprecated Больше не исползуется, т.к. введен Autority
     * @return array
     */
    public function roles()
    {
        return array(
            'controller_roles' => array(
                'login',
            ),
            'actions_roles' => array()
        );
    }

    /**
     * Возвращает признак необходимости авторизации
     * @return bool
     */
    public function need_auth()
    {
        return $this->need_auth;
    }

    protected function init_authority(){
        Authority::allow('access','all',function($user){
            return $user->has('roles',ORM::factory('Role',array('name'=>'login')));
        });

    }

    protected function resource(){
        return $this;
    }
}
