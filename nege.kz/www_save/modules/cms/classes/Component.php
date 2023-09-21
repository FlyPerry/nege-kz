<?php defined('SYSPATH') or die('No direct script access.');

class Component
{
    protected $view;

    protected $elements;

    protected $buttons;

    protected static $errors;

    protected $widgets = array(
        'multilang' => array(),
        'MapPoint' =>array(),
        'partial'=>array(),
    );

    /**
     * @static
     * @param null $view
     * @return Component
     */
    public static function factory($view = "components/form")
    {
        return new Component($view);
    }

    /**
     * @param   string  $key    variable name
     * @param   mixed   $value  referenced variable
     * @return  $this
     */
    public function bind($key,$value){
        if($this->view){
            $this->view->bind($key,$value);
        }
        return $this;
    }

    public function __construct($view)
    {
        $this->elements = array();
        $this->buttons = array();
        $this->view = View::factory($view)
            ->bind('elements', $this->elements)
            ->bind('buttons', $this->buttons);
    }

    public function render()
    {
        return $this->view;
    }

    public function make_array($array)
    {
        $model = $array[1];
        $value = isset($array[4]) ? $array[4] : $model->__get($array[2]);
        return array(
            'label' => $array[0],
            'model' => $array[1],
            'field' => $array[2],
            'params' => $array[3],
            'error' => Arr::get(self::$errors, $array[2]),
            'value' => $value,
        );
    }


    function __call($name, $arguments)
    {
        if (strpos($arguments[2], '.')) {
            $arguments[2] = substr($arguments[2], 0, strpos($arguments[2], '.'));
        }
        $params = $this->make_array($arguments);
        $params_ext = Arr::get($params, 'params');
        if ($params_ext) {
            $widget = Arr::get($params_ext, 'widget');
            if ($widget) {
                $params['component_name'] = $name;
                return $this->widget($widget, $params);
            }
        }
        if (!array_key_exists('admin_only', $params))
            return $this->create_component($name, $params);
    }

    function create_component($name, $values)
    {
        $view = View::factory("components/type/$name", $values);
        $this->elements[] = $view;
        return $view;
    }

    public function widget($name, $params)
    {
        $key = Arr::get($params, 'id', $name);
        if (isset($this->widgets[$key]) && $this->widgets[$key]) {
            $widget = $this->widgets[$key];
        } else {
            $class = "Components_Widget_".ucfirst($name);
            $widget = new $class();
            $this->widgets[$key] = $widget;
            $this->elements[] = $widget;
            $widget->set_id($key);
        }
        $widget->add($params);

        return $widget;
    }


    public function form_input_password($model, $label, $field, $value = false, $error = false)
    {
        if ($value === false) {
            $value = $model->$field;
        }
        return View::factory('components/form/input_password', array(
            'label' => $label,
            'field' => $field,
            'value' => $value,
            'error' => Arr::get(self::$errors, $field, $error),
            'model' => $model
        ));
    }

    public function form_button_save_and_resume($name = 'save_and_resume', $value = 'Сохранить и создать еще', $attr = array())
    {
        $view = View::factory('components/form/button_save_and_resume', array('name' => $name, 'value' => $value, 'attr' => $attr));
        $this->buttons[] = $view;
        return $view;
    }

    public function form_button_save($name = 'save', $value = 'Сохранить', $attr = array())
    {
        $view = View::factory('components/form/button_save', array('name' => $name, 'value' => $value, 'attr' => $attr));
        $this->buttons[] = $view;
        return $view;
    }

    public function form_button_reset($name = 'save', $value = 'Сбросить', $attr = array())
    {
        $view = View::factory('components/form/button_reset', array('name' => $name, 'value' => $value, 'attr' => $attr));
        $this->buttons[] = $view;
        return $view;
    }

    public function form_note($value)
    {
        $view=View::factory('components/form/note')->set('value',$value);
        $this->elements[]=$view;
    }

    public function editable_table($model, $head = array('id' => '#', 'title' => 'Название'), $view = 'components/editable_table')
    {
        return View::factory($view, array(
            'head' => $head,
            'model' => $model,
        ));
    }


    public function menu($items, $view = "components/menu_admin")
    {
        return View::factory($view, array('items' => $items));
    }

    public static function errors(&$errors = null)
    {
        if ($errors == null) {
            return self::$errors;
        }
        self::$errors =& $errors;
    }


    public function text_search($name = "search_text", $value = "", $attr = array(), $btn = "search", $btn_value = "Поиск")
    {
        $_attr = array(
            'size' => 32,
            'id' => $name
        );
        $_attr += $attr;
        return View::factory('components/search_text', array(
            'name' => $name,
            'value' => $value,
            'attr' => $_attr,
            'btn' => $btn,
            'btn_value' => $btn_value
        ));
    }

    public function form_readonly_text($label, $text)
    {
        return View::factory('components/form/readonly_text', array('label' => $label, 'text' => $text));
    }

    public function button_link($uri, $title, $attr = array())
    {
        $view = View::factory('components/button_link', array(
            'uri' => $uri,
            'title' => $title,
            'attr' => $attr,
        ));
        $this->buttons[] = $view;
        return $view;
    }

}

function actions($items){
    foreach ($items as $action) {
        switch (Arr::get($action, 'type')) {
            case "divider":
                echo '<li class="divider"></li>';
                break;
            case "submenu":
                ?>
                <li class="dropdown-submenu"><a href="#"><?=$action['title']?></a>
                    <ul class="dropdown-menu">
                        <?=dropdown($action['submenu'])?>
                    </ul>
                </li>
                <?
                break;
            case 'view':
                ?>
                <a target="_blank" href="<?=str_replace('/cp','',URL::site($action['uri'],'http'))?>"><i class="fa <?=$action['class']?> fa-fw"></i></a>
                <?
                break;
            default:
                ?>
                <a href="<?=URL::site($action['uri'])?>"><i class="fa <?=$action['class']?> fa-fw"></i></a>
                <?
                break;
        }
        if (isset($action['divider'])) {

        } else {

        }
    }
}


function dropdown($items)
{
    foreach ($items as $action) {
        switch (Arr::get($action, 'type')) {
            case "divider":
                echo '<li class="divider"></li>';
                break;
            case "submenu":
                ?>
                <li class="dropdown-submenu"><a href="#"><?=$action['title']?></a>
                    <ul class="dropdown-menu">
                        <?=dropdown($action['submenu'])?>
                    </ul>
                </li>
                <?
                break;
            default:
                ?>
                <li><a href="<?=URL::site($action['uri'])?>"><?=$action['title']?></a></li>
                <?
                break;
        }
        if (isset($action['divider'])) {

        } else {

        }

    }
}