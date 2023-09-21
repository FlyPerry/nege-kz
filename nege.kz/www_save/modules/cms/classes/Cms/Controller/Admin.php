<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Базовый контроллер админки
 *
 * @author Igor Noskov <igor.noskov87@gmail.com>
 */
class Cms_Controller_Admin extends Cms_Controller_Site {

    public $template='admin/template';

    protected $need_auth=TRUE;

    protected  $login_uri="admin/login";

    public function roles()
    {
        return array(
            'controller_roles' => array(
                'admin'
            ),
            'actions_roles' => array(

            )
        );
    }

}

?>
