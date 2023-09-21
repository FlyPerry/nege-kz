<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Created by JetBrains PhpStorm.
 * User: Igor Noskov <igor.noskov87@gmail.com>
 * Date: 19.01.12
 * Time: 13:43
 * To change this template use File | Settings | File Templates.
 */

class Cms_Page
{
    const PAGE_MESSAGE_NOTICE=1;

    const PAGE_MESSAGE_WARNING=2;

    const PAGE_MESSAGE_ERROR=4;

    /**
     * @var string Заголовок страницы
     */
    protected $title;
    /**
     * @var View|string Представление страницы
     */
    protected $content;
    /**
     * @var string Относительный путь до контента
     */
    protected static $content_dir="media";
    /**
     * Модель страницы, опционально
     * @var null|ORM
     */
    public $model;
    
      /**
     * Счетчик для метатегов и OpenGraph
     */
    public $count = 1;
    /**
     * Массив скриптов, стилей и метатэгов страницы
     * @var array
     */
    protected  $header;
    /**
     * @var array Массив сообщений
     */
    protected static $messages=array();

    protected static $session;

    protected $document_root;

    public function __construct($model=null,$session=null)
    {
         $this->header = array(
            'scripts' => array(),
            'styles' => array(),
            'meta' => array(),
            'og'   => array(),
        );
        $this->model=$model;
        $session AND self::$session=$session;
        $session OR self::$session=Session::instance();
        self::_load_messages();
        isset($_SERVER["DOCUMENT_ROOT"]) AND $this->document_root($_SERVER["DOCUMENT_ROOT"]);
    }

    /**
     * Добавляет скрипт
     * @param null|string $name
     * @param null|string $path
     */
    public function script($name=null,$path=null)
    {
        $this->headers('scripts',$name,$this->find_content($path));
        return $this;
    }
    /**
     * Добавляет стиль
     * @param null|string $name
     * @param null|string $path
     */
    public function style($name=null,$path=null)
    {
        $this->headers('styles',$name,$this->find_content($path));
        return $this;
    }

    /**
     * Добавляет метатэг
     * @todo: Реализовать
     */
    public function meta_tag()
    {
        return $this;
    }
    
    /**
     * Добавляет метатэг
     * Атрибуты
     * @name string $name
     * @content string $content
     * @equiv null|string $equiv 
     * @charset null|string $charset
     */
    public function meta($content, $name, $equiv = null,$charset = null)
    {
        $params = array();
        ($name) ? $params['property'] = $name : '';
        ($equiv) ? $params['http-equiv'] = $equiv: '';
        ($charset) ? $params['charset'] = $charset : '';
        ($content) ? $params['content'] = trim(strip_tags($content),PHP_EOL) : '';
        $this->headers('meta', ($name!='') ? $name : $this->count, $params);
        $this->count++;
        return $this;
    }

    public function headers($type,$name=null,$value=null)
    {
        if (!$name)
        {
            return $this->header[$type];
        }

        if ($name && !$value)
        {
            return isset($this->header[$type][$name])?$this->header[$type][$name]:NULL;
        }

        if ($name && $value)
        {
            $this->header[$type][$name]=$value;
        }
    }

    /**
     * Реализует принцип каскадной файловой системы для медиа контента
     * @param string $path Относительный путь до контента, например: js/jquery.min.js
     * @return string Каскадный путь
     * @throws Kohana_Exception
     */
    public function find_content($path)
    {

        if (preg_match('/:\/\//i',$path)) return $path;
        $path=str_replace('\\','/',$path);
        $path=ltrim($path,'/');
        $ext=pathinfo($path,PATHINFO_EXTENSION);
        $name=pathinfo($path,PATHINFO_BASENAME);
        $name=substr($name,0,strlen($name)-strlen($ext)-1);
        $dir=pathinfo($path,PATHINFO_DIRNAME);

        $file=$this->document_root().URL::base().$path;
        if (is_file($file) && is_readable($file))
        {
            return $path;
        }
        $destination=$file;
        $file=Kohana::find_file(self::$content_dir.DIRECTORY_SEPARATOR.$dir,$name,$ext);
        if ($file)
        {
            $dir=dirname($destination);
            is_dir($dir) OR mkdir($dir,0775,true);
            copy($file,$destination);
            chmod($destination,0775);
            return $path;
        } else {
            throw new Kohana_Exception("File not found :file",array(':file'=>$path));
        }
    }



    /**
     * @return string Html код для вставки скриптов
     */
    public function get_scripts()
    {
        $result="";
        foreach ($this->headers('scripts') as $script)
        {
            $result.=HTML::script($script)."\n";
        }
        return $result;
    }
    /**
     * @return string Html код для вставки стилей
     */
    public function get_styles()
    {
        $result="";
        foreach ($this->headers('styles') as $script)
        {
            $result.=HTML::style($script)."\n";
        }
        return $result;
    }

    
    /**
     * @return string Html код для вставки мета тэгов
     * 
     */
    public function get_meta()
    {
        $result = "";
        $meta = $this->headers('meta');
        $data = '';
         if(!empty($meta)){
            foreach ($meta as $key => $value) {
                    $data .= HTML::attributes($value);
                    $result .= "<meta ".$data." />\n";
                    $data = '';
            }
          return $result;  
        } else return "\n";
    }
    /**
     * @return string Html код заголовка страницы
     */
    public function get_title()
    {
        return empty($this->title)?'':"<title>{$this->title}</title>\n";
    }
    
    /**
     * Добавляет title страницы
     * @param string $title
     * @return string
     */
    public function title($title=null)
    {
        if ($title==null)
        {
            return $this->title;
        } else {
            $this->title=$title;
        }
    }

    /**
     * @param bool $without_scripts не подключть скрипты, чтобы их можно было подключить отдельно
     * @return string Html код для HEAD
     */
    public function get_head($without_scripts=false)
    {
        return $this->get_title()
            .$this->get_meta()
            .OpenGraph::instance()->getOGMeta()
            .$this->get_styles()
            .($without_scripts?'':$this->get_scripts());
    }


    /**
     * @return string|View Содержимое страницы
     */
    public function content($content = NULL)
    {
        if ($content!=null)
        {
            $this->content=$content;
        } else return $this->content;
    }

    /**
     * Записывает сообщения в стэк сообщений
     * Для извленчения сообщений из стэка нужно использовать Cms_Page::read_messages(), т.к. она удаляет сообщения из стэка
     * @param null $message
     * @param int $level Уровень сообщения self::PAGE_MESSAGE_ERROR | self::PAGE_MESSAGE_NOTICE | self::PAGE_MESSAGE_WARNING
     * @return mixed Если не указано сообщение, то будет возвращен весь массив заданного уровня
     */
    public static function message($message=NULL,$level=self::PAGE_MESSAGE_NOTICE)
    {
        if (is_array($message))
        {
            self::$messages[$level]=self::$messages[$level]+$message;
        } elseif($message) {
            self::$messages[$level][]=$message;
        } else {
            return self::$messages[$level];
        }
        self::_save_messages(); //Гарантирует что если будет редирект, то сообщения остануться в сессии
    }

    /**
     * Читает стэк сообщений заданного уровня, и очищает его
     * @static
     * @param $level
     * @return array
     */
    public static function read_messages($level=self::PAGE_MESSAGE_NOTICE)
    {
        $messages=isset(self::$messages[$level]) && is_array(self::$messages[$level])?self::$messages[$level]:array();
        self::$messages[$level]=array();
        self::_save_messages();
        return $messages;
    }

    /**
     * @static
     * Сохраняет стэк сообщений в сессию
     */
    protected  static function _save_messages()
    {
        if (isset(self::$messages[self::PAGE_MESSAGE_NOTICE]))
            self::$messages[self::PAGE_MESSAGE_NOTICE] = array_unique(self::$messages[self::PAGE_MESSAGE_NOTICE]);
        if (isset(self::$messages[self::PAGE_MESSAGE_ERROR]))
            self::$messages[self::PAGE_MESSAGE_ERROR] = array_unique(self::$messages[self::PAGE_MESSAGE_ERROR]);
        if (isset(self::$messages[self::PAGE_MESSAGE_WARNING]))
            self::$messages[self::PAGE_MESSAGE_WARNING] = array_unique(self::$messages[self::PAGE_MESSAGE_WARNING]);
        self::$session->set('cms_page_messages',self::$messages);
    }

    protected static function _load_messages()
    {
        self::$messages=self::$session->get('cms_page_messages',array());
    }

    public function save_messages()
    {
        self::_save_messages();
    }

    public function document_root($document_root=null)
    {
        if ($document_root!=null)
        {
            $this->document_root=$document_root;
        } else {
            return $this->document_root;
        }
    }

    public function content_dir($content_dir)
    {
        if ($content_dir!=null)
        {
            self::$content_dir=$content_dir;
        } else {
            return self::$content_dir;
        }
    }

    public function script_dir($path){
        // The file has not been found yet
        $found = FALSE;
        $paths=array(APPPATH);
        $paths += Kohana::modules();
        $paths[]=DOCROOT;
        foreach ($paths as $dir)
        {
            if (is_dir($dir.$path))
            {
                // A path has been found
                $found = $dir.$path;

                // Stop searching
                break;
            }
        }
        $iterator=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($found,RecursiveIteratorIterator::SELF_FIRST));
        /** @var SplFileInfo $fileInfo */
        foreach ($iterator as $fileInfo){
            if ($fileInfo->isFile() && $fileInfo->getExtension()=='js'){
                $this->script($fileInfo->getRealPath(),substr($fileInfo->getRealPath(),strlen(DOCROOT)));
            }
        }
    }
}
