<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sgm
 * Date: 26.09.13
 * Time: 16:25
 * To change this template use File | Settings | File Templates.
 */

class HTTP_Exception_403 extends Kohana_HTTP_Exception_403 {

    /**
     * Generate a Response for the 403 Exception.
     *
     * The user should be shown a nice 403 page.
     *
     * @return Response
     */
    public function get_response()
    {
        $this->last_uri = Session::instance()->get('last_uri',URL::base());
        $back_url = URL::site($this->last_uri);
        $view = View::factory('errors/403')
            ->bind('back_url', $back_url);
        // Remembering that `$this` is an instance of HTTP_Exception_404
        $view->message = $this->getMessage();
        return $this->prepare_response($view);

    }
}