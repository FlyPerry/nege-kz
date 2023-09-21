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
        if(Helper::is_production() || 1){
            $view = View::factory('errors/404');
            $response = Response::factory()
                ->status(404)
                ->body($view->render());
            return $response;

        }else{
            return parent::get_response();
        }


    }
}