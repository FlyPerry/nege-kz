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
        if(Helper::is_production()){
            $view = View::factory('errors/403');
            // Remembering that `$this` is an instance of HTTP_Exception_403
            $view->message = $this->getMessage();

            $response = Response::factory()
                ->status(403)
                ->body($view->render());

            return $response;


        }else{
           return parent::get_response();
        }

    }
}