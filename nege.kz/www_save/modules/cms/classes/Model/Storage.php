<?php
/**
 * Created by JetBrains PhpStorm.
 * User: igor
 * Date: 19.03.13
 * Time: 15:07
 * To change this template use File | Settings | File Templates.
 */
class Model_Storage extends Cms_Model_Storage
{

    public function download_file_url()
    {
        return URL::site('Storage_Manage/download_file/'.$this->id);
    }



}
