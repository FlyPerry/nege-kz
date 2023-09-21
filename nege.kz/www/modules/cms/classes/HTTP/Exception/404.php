<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sgm
 * Date: 26.09.13
 * Time: 16:25
 * To change this template use File | Settings | File Templates.
 */

class HTTP_Exception_404 extends Kohana_HTTP_Exception_404 {



    /**
     * Generate a Response for the 404 Exception.
     *
     * The user should be shown a nice 404 page.
     *
     * @return Response
     */
    public function get_response()
    {
        if(Helper::is_production()){

            $view = View::factory('errors/404');
            // Remembering that `$this` is an instance of HTTP_Exception_404
            $view->message = $this->getMessage();
            return $this->prepare_response($view);

        }else{
            return parent::get_response();
        }


    }
}