<?php

class Site extends Cms_Controller_Site
{

    public $template_langs = array(
        'kz' => 'KAZ',
        'ru' => 'RUS'
    );

    public function before()
    {

 
        parent::before();

        $this->page->meta('Nege', 'og:title');
        $this->page->meta('website', 'og:type');
        View::bind_global('template_langs',$this->template_langs);
/*        if (!$this->request->param('lang')) {
            $this->redirect(I18n::$lang . "/" . $this->request->uri(), 301);
            exit;
        };*/
//        $this->page->meta('index,follow','robots');
//        $this->page->meta(__('Круглосуточная лента новостей. Последние новости Казахстана, новости бизнеса, экономика, происшествия, новости спорта, назарбаев, экспорт, новости астаны, трансляции брифинов СЦК, онлайн-конференции.'),'description');
//        $this->page->meta(__('Круглосуточная лента новостей. Последние новости Казахстана, новости бизнеса, экономика, происшествия, новости спорта, назарбаев, экспорт, новости астаны, трансляции брифинов СЦК, онлайн-конференции.'),'og:description');
//        $this->page->meta(__('новости Казахстана, новости Казахстана на сегодня онлайн, новости дня, последние новости Казахстана, новости правительства, брифинги СЦК, онлайн-конференции'),'keywords');
//        $this->page->meta('e6fb3866a2eb58efd5ab9d2d5c09150435032c8d','openstat-verification');
//        $this->page->meta('CD6C99557011EE6BDD9900616A9CCD8F','msvalidate.01');
          $this->page->meta(URL::site('img/logo-test.png','https'),'og:image'); 
        $this->page->meta(URL::Site($this->request->url(),'http'),'og:url');
        
    }


    public function scripts()
    {
        return parent::scripts() + array(
//            'jquery' => 'js/lib/jquery.1.11.1.min.js',
            'jquery.bxslider' => 'js/jquery.bxslider.min.js',
            'jquery.jscrollpane' => 'js/jquery.jscrollpane.min.js',
            'jquery.custom-scroll' => 'js/jquery.custom-scroll.js',
//            'recaptcha'=>'http://www.google.com/recaptcha/api/js/recaptcha_ajax.js',
//            'jquery-ui'=>'js/lib/jquery-ui-1.9.1.custom.min.js',
//            'bootstrap'=>'js/lib/bootstrap/js/bootstrap.min.js',
//            'redactor'=>'js/lib/redactor/redactor.min.js',
//            'angular'=>'js/lib/angular.min.js',
//            'angular-resource'=>'js/lib/angular-resource.min.js',
//            'angular-sanitaze'=>'js/lib/angular-sanitize.min.js',
//            'storage'=>'js/lib/storage.js',
//            'date_time_picker' => 'js/lib/datetimepicker.js',
//            'require'=>'js/require.js',
            'index' => 'js/index.js',
//            'fotorama' => 'js/fotorama.js',
//            'lightbox' => 'js/jquery.lightbox.js',
//            'upload'=> 'js/upload.js',
//            'ulogin'=> 'http://ulogin.ru/js/ulogin.js',
//            'readmore' => 'js/readmore.min.js',

        );
    }

    public function styles()
    {
        return parent::styles() + array(
//            'jquery-ui'=>'js/lib/jquery-ui-1.9.1.custom/css/smoothness/jquery-ui-1.9.1.custom.min.css',
//            'bootstrap'=>'js/lib/bootstrap/css/bootstrap.min.css',
            /*            'responsive'=>'js/lib/bootstrap   /css/bootstrap-responsive.min.css',*/
//            'redactor'=>'js/lib/redactor/redactor.css',
            'style' => 'css/style-all.min.css',
//            'jquery.custom-scroll' => 'css/jquery.custom-scroll.css',
//            'lightbox'=>'css/lightbox.css',
//            'google_fonts'=>'css/google_fonts.css',
//            'fotorama'=>'css/fotorama.css',
//            'lang'=>'css/lang/'.I18n::$lang.'.css',
//            'upload' => 'css/upload.css'
        );
    }

    public function after()
    {
        $view = $this->page->content();
        Event::instance()->dispatch('api.controller.action.login.end', $view);
        parent::after();
    }

    public function check_pages($page, $total_pages, $redirect = null)
    {
        if ($page && ($page > $total_pages || preg_match('#[a-zA-Zа-яА-Я]#', $page, $match))) {
            if ($redirect) {
                return 'redirect';
            } else {
                throw new HTTP_Exception_404();
            }
        }
        $current_uri = Request::initial()->current()->uri();
        if (preg_match('#page-1$#', $current_uri)) {
            $this->redirect(preg_replace('#page-1#', '', $current_uri), 301);
        }
    }
}
