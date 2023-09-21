<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 19.03.13
 * Time: 14:05
 * To change this template use File | Settings | File Templates.
 */
class Cms_Storage
{
    public static $watermark_path = 'img/bnews_watermark.png';
    protected static $instance;
    protected $config=array();

    protected function __construct()
    {
        $this->config=Kohana::$config->load('cms.storage');
    }

    /**
     * Возвращает объект хранилища
     * @static
     * @return Cms_Storage
     */
    public static function  instance()
    {
        if (!self::$instance) {
            self::$instance = new Cms_Storage();
            return self::$instance;
        } else {
            return self::$instance;
        }
    }

    /**
     * Добавляет загруженный пользователем файл в хранилище
     * @param $files
     * @param $field
     * @param array $tags
     * @return null|\ORM
     */
    public function upload($files,$field,$tags=array(), $water = false){
        $file = $files[$field];
        if (!$this->validate_upload($file))
        {
            return null;
        }

        return $this->add($file['tmp_name'],$file['name'],$tags, null, null, $water);
    }

    /**
     * Добавляет файл в хранилище
     * @param $file
     * @param $original_name Оригинальное имя файла
     * @param array $tags Метки для файла
     * @param null $ext
     * @param $parent_id Родительский файл
     * @return \ORM
     */
    public function add($file,$original_name=null,$tags=array(),$ext=null,$parent_id=null, $do_water = false){
        if ($ext==null){
            if ($original_name!=null){
                $ext=pathinfo($original_name,PATHINFO_EXTENSION);
            } else {
                $ext=pathinfo($file,PATHINFO_EXTENSION);
            }
        }
        $hash=$this->hash($file);
        $dir=$this->dir_name($hash);
        $this->mk_dir($dir);
        $filename=$this->file_name($hash,$ext);
        //todo: Валидация файла, добавление связей, меток, тэгов
        $model=$this->model();
        $model->name=$filename;
        $model->dir=$dir;
        $model->key=$hash;
        $model->original_name=$original_name;
        $model->size=filesize($file);
        $model->type=$ext;
//        $model->tags=$tags;
        $model->parent_id=$parent_id;
        $model->is_new=1;
        if (getimagesize($file) && $do_water && self::$watermark_path){
            $watermark = self::$watermark_path;
            $n_path = ImagesHelper::watermark($file, $watermark, 'bottom', 100, 20);
            imagepng($n_path, DOCROOT.$dir.$filename.".$ext");
        }else{
            copy($file, DOCROOT.$dir.$filename.".$ext");
        };
        $model->save();
        return $model;

    }

    /**
     * Удаляет файл из хранилища
     * @param $file_id
     * @return bool
     */
    public function remove($file_id){
        $file=$this->model($file_id);
        if ($file->loaded()){
            $file->delete();
        } else {
            return false;
        }
        return true;
    }

    /**
     * Возвращает превью файла, если возможно
     * @param $file_id
     */
    public function preview($file_id){

    }

    /**
     * Сборщик мусора
     */
    public function gc(){
        $dir=DOCROOT.$this->config['root'];
        $iterator=new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir,FilesystemIterator::SKIP_DOTS),RecursiveIteratorIterator::CHILD_FIRST);
        /** @var SplFileInfo $finfo */
        foreach ($iterator as $finfo){
            if ($finfo->isDir()) continue;
            $name=$finfo->getBasename();
            $model=$this->model();
            $model->where('name','=',$name)->find();
            if (!$model->loaded()){
                unlink($finfo->getRealPath());

            }
        }
    }

    /**
     * Валидация файла
     * @param $file
     * @return bool
     */
    protected function validate($file){
        return true;
    }

    protected function validate_upload($file){

        return Upload::not_empty($file) && Upload::valid($file);
    }

    /**
     * Генерирует имя папки по хэшу
     * @param $hash
     * @return string
     */
    protected function dir_name($hash){
        return $this->config['root'].DIRECTORY_SEPARATOR.substr($hash,0,2).DIRECTORY_SEPARATOR;
    }

    /**
     * Генерирует имя файла по хэшу и расширению
     * @param $hash
     * @param null $ext
     * @return string
     */
    protected function file_name($hash,$ext=null){
        return $hash;
    }

    protected function hash($filename){
        return MD5(microtime()+rand()+$filename);
    }

    /**
     * Создает папку, если она не существует
     * @param $dir
     * @throws Kohana_Exception
     * @return bool
     */
    protected function mk_dir($dir){
        $dir=DOCROOT.$dir;
        if (is_dir($dir))
            return true;
        if (!mkdir($dir,0775,true)){
            throw new Kohana_Exception("Not possible create dir :dir",array(':dir'=>$dir));
        }
        return true;
    }

    public function model($id=null){
        return ORM::factory('Storage',$id);
    }


    public function get_list($parent){
        $collection=$this->model();
        return $collection->where('parent_id','=',$parent)->find_all();
    }

    public function load_image_from_url($url, $watermark = false)
    {
        $max_size = 5;
        $fileHandler = tmpfile();
        $length = 0;
        $write_function = function ($ch, $str) use (&$fileHandler, &$length, $max_size) {
            $l = fwrite($fileHandler, $str);
            $length += $l;
            if ($length > 1024 * 1024 * $max_size) {
                return 0;
            }
            return $l;
        };

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_USERAGENT => 'Mozilla/5.0',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_WRITEFUNCTION => $write_function
        ));
        curl_exec($ch);
        if ($errno = curl_errno($ch)) {
            $error_msg = curl_error($ch);
            if ($errno == 23) {
                $error_msg = 'Превышен допустимый размер файла';
            }
            throw new Exception($error_msg);
        }
        curl_close($ch);
        rewind($fileHandler);
        $metaData = stream_get_meta_data($fileHandler);
        $finfo = finfo_open();
        $mime_type = finfo_buffer($finfo, stream_get_contents($fileHandler), FILEINFO_MIME_TYPE);
        $ext = '';
        switch ($mime_type) {
            case 'image/jpeg':
                $ext = 'jpg';
                break;
            case 'image/png':
                $ext = 'png';
                break;
            case 'image/gif':
                $ext = 'gif';
                break;
            default:
                throw new Exception('Файл не является изображением');
        }
        return Storage::instance()->add(Arr::get($metaData, 'uri'), null, null, $ext, null, $watermark);
    }


}
