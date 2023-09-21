<?php
include_once Kohana::find_file('vendors', 'recaptcha/recaptchalib');

class Recaptcha{  
    
    protected static $instance;  
    
    public static function instance() {
        if ( is_null(self::$instance) ) {
            self::$instance = new Recaptcha;
        }
        return self::$instance;
    }
    
    protected function getСonfig(){
        return Kohana::$config->load('recaptcha');
    }
    
    protected function getPrivateKey(){
        return $this->getСonfig()->get('private_key');
    }

    protected function getPublickey(){
        return $this->getСonfig()->get('public_key');
    }

    public function widget(){
        return recaptcha_get_html($this->getPublickey());
    }
    
    public function error($errors='',$external = false){
        if($errors != '' && !empty($errors)){
            $prefix = '';
            if($external){
                $prefix = '_external.';
            }
            return arr::path($errors, $prefix.'recaptcha_response_field');
        } else return '';        
    }
    
    public static function verification($value,$challange_field,$validation,$field){
        $resp = recaptcha_check_answer (self::$instance->getPrivateKey(),
                                $_SERVER["REMOTE_ADDR"],
                                $challange_field,
                                $value);
        return (!$resp->is_valid) ? FALSE : TRUE;
    }
    
     public function rules($obj){
         $obj->rules('recaptcha_response_field', array(
            array('not_empty'),
            array('Recaptcha::verification', array(':value',arr::get($_POST,'recaptcha_challenge_field'),':validation', ':field')),
         ));
         return $obj;
     }
          
    private function __construct(){}
    private function __clone()    {}  
    private function __wakeup()   {}

}

?>
