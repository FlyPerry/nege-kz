<?php defined('SYSPATH') or die('No direct script access.');

class ULogin { 
    public static $_errors = array();
    
    public static function widget_ulogin(){
        $config = Kohana::$config->load('ulogin');
        return '<div id="uLogin" x-ulogin-params="display=small;fields=email,'.$config->get('fields').';providers='.$config->get('service').';hidden='.$config->get('service_h').';redirect_uri='.urlencode($config->get('redirect_uri')).'"></div>';
    }
    
    public static function check_auth(){
         $user = Auth::instance()->get_user();
         if(!$user || $user->loaded()){
            if(isset($_POST['token'])){
               $s = file_get_contents('http://ulogin.ru/token.php?token='.$_POST['token'].'&host='.getenv('HTTP_HOST'));
               $user = json_decode($s, true);
               if (!isset($user['error'])) {
                   $user = self::create_user($user);
               } else {
                   return false;
               }
            } else {
                return false;
            }            
         }
         return $user;
    }
    
    public static function create_user($user){
        $local_user = ORM::factory('User')->where('email', '=', $user['email'])->find();
        if (!$local_user->loaded()) {
            $pass = mt_rand(100000, 999999);
            $local_user->values($user);
            $local_user->lastname = $user['last_name'];
            $local_user->firstname = $user['first_name'];
            $local_user->username = $user['uid'];
            $local_user->password = $pass;
            $local_user->email = $user['email'];
            $local_user->socpage = $user['identity'];
            try {
                $local_user->save();
                $local_user->add('roles', ORM::factory('Role',array('name'=>'login')));
                Auth::instance()->force_login($local_user, TRUE);
            } catch (ORM_Validation_Exception $e)
            {
                self::$_errors = $e->errors('model');
                $page = new Cms_Page();
                if (Arr::get(self::$_errors, 'email'))
                {
                    $page->message(__("Указанный Вами email уже используется, попробуйте войти под своим логином/паролем на сайт, или восстановить пароль"),Cms_Page::PAGE_MESSAGE_ERROR);
                    unset(self::$_errors['email']);
                }
                foreach (self::$_errors as $error){
                    $page->message($error, Cms_Page::PAGE_MESSAGE_ERROR);
                }
                self::$_errors = array();
                return false;
            }

        } else { //Иначе обнавляем инфу из соц сети
            $local_user->values($user);
            $local_user->save();
        }

        if(in_array('login', $local_user->roles->reset(false)->find_all()->as_array('id','name'))){
           Auth::instance()->force_login($local_user, TRUE);  
        }
        
        return $local_user;
    }
}

