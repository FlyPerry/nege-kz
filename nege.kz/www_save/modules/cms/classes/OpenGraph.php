<?php

/**
 * OpenGraph::instance() - возвращает единственный экземпляр класса
 * OpenGraph::instance()->getOGMeta() - возвращает список метатегов
 * OpenGraph::instance()->getOGPrefix() - возвращает используемые пространства имён
 *
 * Любой несуществующий метод начинающийся с приставки "set" будет интерпретироваться как сеттер opengraph метатега
 * OpenGraph::instance()->setTitle('Это title'); // <meta property='og:title' content='Это title' />
 *
 * Для изменения корневого элемента пространства имен(по умолчанию выставляется og), в метод-сеттер необходимо передать второй параметр с названием
 * OpenGraph::instance()->setTitle('Это title к видосу','video'); // <meta property='video:title' content='Это title к видосу' />
 *
 *
 * OpenGraph::instance()->setImageType('jpg'); // <meta property='og:image:type' content='jpg' />
 *
 */
class OpenGraph
{
    public static $instance;
    public $space = array();
    public $metagraph = array();
    public $prefix = array();

    /**
     * Возвращает единственный экземпляр класса
     * @return object
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new OpenGraph();
        }
        return self::$instance;
    }

    /**
     * Устанавливает метатеги
     * @param type $name
     * @param type $arg
     */
    public function __call($name, $arg)
    {
        if (substr($name, 0, 3) == 'set') {
            preg_match_all('/[A-Z]{1}[a-z]{1,}/', $name, $matches, PREG_SET_ORDER);
            if (!empty($arg[1])) {
                $ns = strtolower($arg[1]);
                if (!in_array($arg[1], $this->prefix)) $this->prefix[] = $arg[1];
            } else {
                $ns = 'og';
                if (!in_array('og', $this->prefix)) $this->prefix[] = 'og';
            }
            $space = '';
            foreach ($matches as $value)
                foreach ($value as $num => $type) {
                    $space .= ':' . strtolower($type);
                }
            $this->space[$ns][$space] = trim(strip_tags($arg[0]), PHP_EOL);
        }
    }

    /**
     * Формирует OpenGraph массив
     */
    public function end()
    {
        krsort($this->space);
        foreach ($this->space as $num => $ns) {
            $space = $num;
            foreach ($ns as $key => $value) {
                $this->metagraph[] = '<meta property="' . $space . $key . '" content="' . $value . '" />';
            }
        }
    }

    /**
     * Возвращает пространство имен, использовать в корневом элементе
     * <html<?Opengraph::instance()->getOGPrefix();?>>
     * @return string
     */
    public function getOGPrefix()
    {
        $list = '';
        foreach ($this->prefix as $key => $prefix) {
            if ($prefix == 'og') {
                $list .= $prefix . ': http://ogp.me/ns# ';
            } else {
                $list .= $prefix . ': http://ogp.me/ns/' . $prefix . "#";
            }
        }
        $og_prefix = (!empty($list)) ? ' prefix="' . trim($list, ':') . '"' : '';
        return $og_prefix;
    }

    /**
     * Обрабатывает OpenGraph массив и возвращает список тегов
     * @return string
     */
    public function getOGMeta()
    {
        $result = '';
        $this->end();
        foreach ($this->metagraph as $key => $value) {
            $result .= "\n" . $value;
        }
        return $result . "\n";
    }

    public function __construct()
    {
    }

    public function __wakeup()
    {
    }

    public function __clone()
    {
    }


}