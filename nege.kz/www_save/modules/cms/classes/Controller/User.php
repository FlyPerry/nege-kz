<?php defined('SYSPATH') or die('No direct access allowed.');


class Controller_User extends Site{
    
    public $profile_uri = 'user/profile';
    

    public function before(){
        parent::before();
        Event::instance()->bind("api.controller.action.login.end",array($this,'ulogin'));
        if(in_array($this->request->action(), array('reg', 'login', 'activation','passremind'))){
            if ($this->user) $this->redirect(URL::site($this->profile_uri, 'http'));
            $this->page->script('ulogin', 'http://ulogin.ru/js/ulogin.js');
        }
    }
    
    public function ulogin($view){
         $ulogin = ULogin::widget_ulogin();
         if (uLogin::check_auth()) {
            if (Session::instance()->get('after_login')) {
                $session = Session::instance();
                $auth_redirect = $session->get('after_login', '');
                $session->delete('after_login');
                $this->redirect($auth_redirect);
            } else {
                $this->redirect($this->last_uri);
            }
        }
        $view->bind('ulogin',$ulogin);
    }
    
    public function action_reg(){
         $this->page->content(View::factory('user/reg')
                ->bind('recaptcha', $recaptcha)
                ->bind('ulogin', $ulogin));
        
        $recaptcha = Recaptcha::instance();
        $ulogin = ULogin::widget_ulogin();
        
        $model = ORM::factory('User');

        $valid = Validation::factory($this->request->post())
            ->rules('password', array(
                array('not_empty'),
                array('min_length', array(':value', 6)),

        ))
            ->rules('password_confirm', array(
                array('matches', array(':validation', ':field', 'password'))

        ));
        $valid = $recaptcha->rules($valid);
        $valid->label('recaptcha_response_field', 'Капча');
        $valid->label('password', 'Пароль');
        $valid->label('password_confirm', 'подтверждение пароля');

        if ($this->request->post('submit')) {
            try {
                $hash = md5(rand(9999, getrandmax()));
                $model->activation_hash = $hash;
                $model->reg_date = date('Y-m-d H:i:s');
                $model->values($this->request->post());
                Event::instance()->dispatch("api.controller.action.passremind.before_save",$model);
                if ($model->save($valid)) {
                    Event::instance()->dispatch("api.controller.action.passremind.after_save",$model);
                    $this->page->content(
                        View::factory('message_page', array(
                            'msg' => __('На указанный адрес электронной почты выслано письмо для подтверждения регистрации')
                        ))
                    );
                }
            } catch (ORM_Validation_Exception $e) {
                $this->errors = $e->errors('validation');
            }
        }
         if (uLogin::check_auth()) {
            if (Session::instance()->get('after_login')) {
                $session = Session::instance();
                $auth_redirect = $session->get('after_login', '');
                $session->delete('after_login');
                $this->redirect($auth_redirect);
            } else {
                $this->redirect($this->last_uri);
            }

        }
    }
    
    public function action_login(){
        $view = View::factory('user/login')->bind('error', $errors);
        Event::instance()->dispatch('api.controller.action.login.begin',$view);
        $this->write_lst_uri = false;
        if (Arr::get($_POST, 'submit')) {
            $username = $this->request->post('username');
            $password = $this->request->post('psswd');
            $remember = (bool)$this->request->post('remember');
            Event::instance()->dispatch('api.controller.action.login.after_login',$view);
            if (Auth::instance()->login($username, $password, $remember)) {
                if (Session::instance()->get('after_login')) {
                    $this->redirect(Session::instance()->get('after_login'));
                } else {
                    $this->redirect($this->last_uri);
                }
            } else {
                $this->errors['psswd'] = __('Неверная пара логин/пароль');
            }
        }
        Event::instance()->dispatch('api.controller.action.login.end',$view);
        $this->page->content($view);
    }
    
    public function action_activation(){
        $model = ORM::factory('User')
            ->where('id', '=', (int)$this->request->param('id'))
            ->where('activation_hash', '=', arr::get($_GET, 'hash'))
            ->find();

        if ($model->loaded()) {
            $model->activation_hash = '';
            $model->save();
            if (!$model->is_active() ) {
                $model->add('roles', ORM::factory('Role', array('name'=>'login')));
            }
        } else {
            $this->redirect(URL::base());
        }
        $this->page->content(
            View::factory('message_page', array(
                'msg' => __('Активация прошла успешно. Можете войти под своим логином')
            ))
        );
    }
    
    public function action_passreset()
    {
        $user = ORM::factory('User')
            ->where('id', '=', (int)$this->request->param('id'))
            ->where('passremind_hash', '=', arr::get($_GET, 'passremind_hash'))
            ->find();

        if (!$user->loaded() OR !$user->passremind_hash)
            $this->request->redirect(Url::base());
        $link = url::site('user/settings/', 'http');
        $newpass = rand(9999, getrandmax());
        $user->password = $newpass;
        $user->passremind_hash = '';
        $user->activation_hash = '';
        $user->save();
        $this->page->title(__('Сброс пароля'));
        $this->page->content(
            View::factory('message_page', array(
                'msg' => __('На указанный адрес электронной почты выслано письмо с новым паролем')
            ))
        );
    }
    
    public function action_passremind(){
        $this->page->content(
            View::factory('user/passremind')->bind('recaptcha', $recaptcha)
        );
        $recaptcha = Recaptcha::instance();
        $model = ORM::factory('User');

        if ($this->request->post('submit')) {
            $validation = Validation::factory($this->request->post())
                ->rules('email', array(
                array('not_empty'),
                array('email')
            ));
            $validation = $recaptcha->rules($validation);
            $validation->label('recaptcha_response_field', 'Капча');
            if ($validation->check()) {
                $model->where('email', '=', $this->request->post('email'))->find();
                if ($model->loaded()) {
                    $hash = md5(rand(9999, getrandmax()));
                    $model->passremind_hash = $hash;
                    if ($model->save()) {
                        Event::instance()->dispatch("api.controller.action.passremind.post_save",$model);
                        $this->page->content(
                            View::factory('message_page', array(
                                'msg' => __('На указанный адрес электронной почты выслано письмо с инструкцией по смене пароля')
                            ))
                        );
                    }
                } else {
                    $this->errors['email'] = __('Пользователя с таким e-mail у нас не зарегистрировано').'!';
                }
            } else {
                $this->errors = $validation->errors('validation');
            }
        }
    }
    
}