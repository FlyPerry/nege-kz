<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sgm
 * Date: 17.09.13
 * Time: 17:06
 * To change this template use File | Settings | File Templates.
 */

class Model_Domain_Allowed extends ORM {

    protected $_table_name = "allowed_domains";
    protected $_belongs_to = array(
        'parent_domain'=>array(
            'model'=>'Domain',
            'foreign_key'=>'domain_id'
        ),
    );

    public function rules(){
        return array(
            'domain'=>array(
                array(array($this, 'unique'), array('domain', ':value')),
//                array('url'),
            ),
        );
    }

}