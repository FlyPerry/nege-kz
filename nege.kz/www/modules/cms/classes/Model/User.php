<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Auth_User implements IC_Translatable{
    protected $_created_column = array('column' => 'reg_date', 'format' => 'Y-m-d H:i:s');
    protected $possibly_banned = true;
    protected $_route = "user";

    protected $_list_title = "Пользователи";
    protected $_edit_title = "Пользователя";
    public static $_model_langs = array('ru'=>'Русский','en'=>'English');
    protected $_has_many = array(
        'roles' => array('model' => 'Role', 'through' => 'roles_users', 'foreign_key' => 'user_id'));
    
    /**
     * Проверка есть ли у пользователя роль "login"
     */
    public function is_active()
    {
        return $this->has('roles', $this->login_role());
    }

    public function get_full_name() {
        return $this->email;
    }
    
    /**
     *  Проверка есть ли у пользователя activation_hash
     */
    public function is_activated(){
        return (empty($this->activation_hash)) ? TRUE : FALSE;
    }
    
    /**
     * 
     * @return type object
     */
    public function login_role()
    {
        $model = ORM::factory('Role')->where('name', '=', 'login')->find();
        return $model;
    }


    public function search_form(){
        return array(
            'search'=>array('firstname'),
            'flags'=>array()
        );
    }

    public static $_model_blocks = array(
        'main' => array(
            'common' => array(
                'title' => 'Основное'
            ),


        ),
        'rt' => array(

        ),
        'rb' => array()
    );

    public function as_array()
    {
        $data = parent::as_array();
        unset($data['password']);
//        unset($data['password']);
        return $data;
    }

    public function save(Validation $validation = NULL)
    {
        if (!$this->username){
            $this->username = $this->email;
        }
        parent::save($validation);
        return $this;
    }

    public function filters(){

        return array(
            'firstname'=>array(
                array('strip_tags'),
            ),
        )+parent::filters();
    }

    public function rules()
    {
        return array(
            'username'=>array(
                array('max_length', array(':value', 32)),
            ),
            'firstname' => array(
                array('not_empty'),
            ),
            'password' => array(
                array('not_empty'),
                array('min_length', array(':value', 5)),
            ),
            'email' => array(
                array('not_empty'),
                array('email'),
                array(array($this, 'unique'), array('email', ':value')),
            ),
        );
    }

    public function fields_description()
    {
        return array(
            'id'=>array(
                'label'=>'#',
                'head'=>false,
                'edit'=>false,
                'type'=>'strings',
            ),
            'title'=>array(
                'label'=>'Имя',
                'head'=>true,
                'edit'=>false,
                'search'=>true,
                'type'=>'strings',
                'block' => 'common',
            ),
            'firstname'=>array(
                'label'=>'Имя',
                'head'=>false,
                'edit'=>true,
                'search'=>true,
                'type'=>'strings',
                'block' => 'common',
            ),
            'email'=>array(
                'edit'=>true,
                'type'=>'strings',
                'label'=>'E-mail',
                'head'=>true,
                'search'=>true,
                'block' => 'common',
            ),
            'password'=>array(
                'edit'=>true,
                'type'=>'password',
                'label'=>'Пароль',
//                'edit'=>true,
                'block' => 'common',
            ),
            'roles'=>array(
                'edit'=>true,
                'label'=>'Роли',
                'type'=>'select_extended',
                'params'=>array(
                    'options'=>ORM::factory('Role')->select_options('id','description'),
                    'value'=>$this->roles->select_options('id','description'),
                ),
                'block' => 'common',
            ),


        );
    }

    public function get_field($field){
        if($field=='title'){
            return $this->firstname;
        }
        return parent::get_field($field);
    }

    public function select_options($id = 'id', $title = null, $order_by = 'ASC')
    {
        if($title=='description'){
            $order_field = 'firstname';
        }else{
            $order_field = $title ? $title : $id;
        }

        return $this->reset(false)->order_by($order_field,$order_by)->find_all()->as_array($id, $title);
    }


    public function get($column){
        if($column=='description' && $this->id){
            return $this->fullname();
        }

        return parent::get($column);
    }

    public function fullname(){
        return $this->firstname." ".$this->lastname;
    }

    public function ava()
    {
        if ($this->photo) {
            return $this->photo_s->url('http');
        }
        return 'http://www.gravatar.com/avatar/'.md5($this->email);
    }

    public function generate_password(){
        $password = rand(0,100000);
        $password = str_pad($password,8,rand(0,10000));
        return $password;
    }

    public function ava_url($size = 100) {

        $url = URL::site($this->photo_s->html_img_url($size, $size));
        if (!$url) {
            $url = 'http://www.gravatar.com/avatar/'.md5($this->email).'?s='.$size;
        }
        return $url;
    }
    
    
}
?>
