<?php
/**
 * Собирает строки обернутые в __()  и генерит файл en.php
 * @bug Если встреится строка из одного символа, то получится косяк, правится в ручную в самом файле
 */
error_reporting(E_ALL | E_STRICT);
define("SYSPATH", true);

$dirs = array(
    'www/application/views',
    'www/application/classes/controller',
    'www/application/messages',
//    'www/modules/cms',
//    'www/modules/cms_menu',
//    'www/modules/cms_log',
//    'www/modules/slider',
//    'www/modules/news',
//    'www/modules/phpflicker',
//    'www/modules/search',
//    'www/modules/ulogin',
);
class Parser
{

    protected $strings = array();


    function __construct($dirs)
    {
        foreach ($dirs as $d) {
            $this->handle_dir($d, __DIR__);
        }
    }

    function handle_dir($dir, $parent = "./")
    {
        $path = $parent.DIRECTORY_SEPARATOR.$dir;
        if (is_file($path)) {
            $this->handle_file($path);
        }
        if (!is_dir($path) || $dir == '.' || $dir == '..') {
            return;
        }

        $items = scandir($path);
        foreach ($items as $d) {
            $this->handle_dir($d, $path);
        }


    }

    function handle_file($name)
    {
        if ($name == '.' || $name == '..') {
            return;
        }
        $content = file_get_contents($name);
        if (preg_match_all('/__\((([\'"])[^\'"](.+?)\2)/si', $content, $matches, PREG_SET_ORDER)) {
            foreach ($matches as $m) {
                $this->add_string($m[1], $m[2]);
            }
        }
    }

    function add_string($string, $quote)
    {
        $string = str_replace("'),", '', $string);
        $dequote = trim($string, $quote);
        if (!isset($this->strings[$dequote])) {

            $this->strings[$dequote] = "";
        }
    }

    function merge($target)
    {
        $strings = $this->load_config($target);
        $original = $this->strings;
        foreach ($strings as $key => $value) {
            if (isset($this->strings[$key])) {
//                $value = str_replace("'", "\'", $value);
                $this->strings[$key] = $value;
            } else {
                $this->strings[$key] = $value;
            }
        }


        $clone = clone($this);
        $this->strings = $original;
        return $clone;
    }

    function load_config($target)
    {
        return include $target;
    }

    function __toString()
    {
        $strs = "";
        asort($this->strings);
        foreach ($this->strings as $k => $v) {
            $k = $this->quote($k);
            $v = $this->quote($v);
            $strs .= "$k=>$v,\n";
        }
        return $strs;
    }

    public function quote($k)
    {
        if (strpos($k, "'") === FALSE) {
            $k = "'$k'";
        } else {
            $k = '"'.$k.'"';

        }
        return $k;
    }
}


$parser = new Parser($dirs);

$langs = array('en', 'kz','kk');

foreach ($langs as $l) {
    $lang_file = __DIR__.DIRECTORY_SEPARATOR."www/application/i18n/$l.php";
    if (file_exists($lang_file)) {
        $data = $parser->merge($lang_file);
        $content = "<?php\n".
            "return array(\n".
            $data.
            ");\n";
        file_put_contents("$l.php", $content);
    }

}






