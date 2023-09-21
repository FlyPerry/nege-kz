<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 19.03.13
 * Time: 15:05
 * To change this template use File | Settings | File Templates.
 */
class Cms_Model_Storage extends ORM
{
    protected $_updated_column = array('column'=>'updated','format'=>'Y-m-d H:i:s');
    protected $_created_column = array('column'=>'created','format'=>'Y-m-d H:i:s');

    public function is_file(){
        return !$this->is_dir();
    }

    public function is_dir(){
        return $this->type=='dir';
    }

    public function full_path() {
        $docroot = str_replace('\\','/',DOCROOT);
        $docroot = rtrim($docroot, '/');
        return $docroot.$this->dir().$this->name.".{$this->type}";
    }

    public function get_file(){
        $full_path = $this->full_path();
        if (!is_file($full_path)){
            return false;
        }
        return new SplFileObject($full_path);
    }

    public function url($protocol=null,$index=false){
        return Url::site($this->dir().$this->name.".{$this->type}",$protocol,$index);
    }

    public function uri(){
        return $this->dir().$this->name.".{$this->type}";
    }

    public function delete()
    {
        if ($this->is_file()){
            $path=$this->full_path();
            if (is_file($path)){
                unlink($path);
            }
        }
        return parent::delete();
    }

    public function filters(){
        return array(
            'tags'=>array(
                array(array($this,'tag_filter')),
            )
        );
    }

    public function tag_filter($value)
    {
        if (is_array($value) && count($value)) {
            return '{'.implode('}{', $value).'}';
        }
        return '';
    }

    public function html_img_url($width = null, $height = null, $attr = array())
    {
        try {
            $file = $this->cropped_file() != false ? $this->cropped_file() : $this->get_file();
            if (!is_file($this->full_path())) {
                return false;
            }

            $url = Photo::translate2url($file->getRealPath());

            if ($width or $height) {
                $url = Photo::resize($file, $width, $height);
            }
            return substr($url, 0, 1) == '/' ? $url : "/{$url}";
        } catch (Exception $e) {
            return null;
        }
    }

    public function html_img($width = null, $height = null, $attr = array())
    {
        try {
            $file = $this->cropped_file() != false ? $this->cropped_file() : $this->get_file();
            return $this->_html_img($file, $width, $height, $attr);
        } catch (Exception $e) {
            return null;
        }
    }

    public function html_cropped_img($width = null, $height = null, $attr = array())
    {
        try {
            $file = $this->cropped_file() != false ? $this->cropped_file() : $this->get_file();
            return $this->_html_img($file, $width, $height, $attr);
        } catch (Exception $e) {
            return null;
        }
    }

    protected function _html_img($file, $width = null, $height = null, $attr = array())
    {
        try {
            if (!is_file($this->full_path())) {
            return false;
            }

            $url = Photo::translate2url($file->getRealPath());

            if ($width or $height) {
                $url = Photo::resize($file, $width, $height);
            }
            return HTML::image($url, $attr);
        } catch (Exception $e) {
            return null;
        }
    }

    public function download_file_url()
    {
        return url::site('client/download/' . $this->id);
    }

    function human_filesize($bytes, $decimals = 2)
    {

        $sz = 'BKMGTP';
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$sz[$factor];
    }

    /**
     * Метит файл "грязным" т.е. файл был загружен, но не связан с какой либо сущностью,
     * следовательно через определнный промежуток времени его можно удалить
     * @param int $flag
     */
    public function dirty($flag = 1)
    {
        $this->is_new = $flag;
        $this->save();
    }

    /**
     * Валидатор для клиентских файлов
     * @param $data
     * @param $field
     * @return Validation
     */
    public static function client_file_validator($data, $field)
    {
        $valid = Validation::factory($data);
        $valid->rules($field, array(
            array('Upload::size', array(':value', '2M')),
            array('Upload::type', array(':value', array('jpg', 'jpeg', 'gif', 'png', 'doc', 'docx', 'xls', 'xlsx', 'rtf', 'txt', 'pdf', 'rar', 'zip')))
        ));
        return $valid;
    }

    public function as_array()
    {
        return array(
            'filename' => $this->original_name,
            'download_url' => $this->url('http'),
            'delete_url' => Url::site('client/delete/' . $this->id),
            'id' => $this->id,
            'size' => $this->human_filesize($this->size())
        );
    }

    public function size()
    {
        $file = new SplFileInfo(DOCROOT . $this->uri());
        if ($file->isReadable()) {
            return $file->getSize();
        }

        return 0;

    }

    /**
     * @return mixed
     */
    public function dir()
    {
        return str_replace('\\', '/', $this->dir);
    }

    public function metadata($data=null){
        if ($data==null){
            if (empty($this->metadata)){
                return array();
            }
            return json_decode($this->metadata,true);
        }

        $this->metadata=json_encode($data);
    }

    public function cropped_file(){
        $meta=$this->metadata();
        if (isset($meta['crop'])){
            $file = $this->get_file();
            if ($file==false){ //Файл не существует
                return false;
            }
            return new SplFileObject(
                Photo::instance()
                    ->_crop(
                        $file,
                        $meta['crop']['x'],
                        $meta['crop']['y'],
                        $meta['crop']['w'],
                        $meta['crop']['h']
                    )
            );
        }
        return false;
    }

    public function cropped_img_url($width=null,$height=null, $protocol=null, $index=false){
        $file=$this->cropped_file()!=false?$this->cropped_file():$this->get_file();
        if (!is_file($this->full_path())){
            return false;
        }

        $url=Photo::translate2url($file->getRealPath());

        if ($width or $height)
        {
            $url= Photo::resize($file,$width,$height);
        }
        return URL::site($url);
    }
}
