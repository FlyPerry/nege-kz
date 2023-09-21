    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0">
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
        <script type="text/javascript" src="/js/jquery.bxslider.min.js"></script>
        <script type="text/javascript" src="/js/jquery.jscrollpane.min.js"></script>
        <script type="text/javascript" src="/js/jquery.custom-scroll.js"></script>
        <script type="text/javascript" src="/js/underscore-min.js"></script>
        <?=$page->get_head(true)?>
        <script>
            $(function(){
                $('.slider4').bxSlider({
                    slideWidth: 210,
                    minSlides: 1,
                    maxSlides: 4,
                    moveSlides: 1,
                    slideMargin: 40
                });
            });
        </script>
        <script>
            $(document).ready(function(){
                $('.player .player-menu').click(function() {
                    $(this).toggleClass('opened');
                    $('.player .play-list').toggleClass('opened');
                    $('.player .name').toggleClass('none');
                    $('.player .scale').toggleClass('opened');
                });
                $('.js-burger').click(function () {
                    $('.header').toggleClass('menu-opened');
                });
            });
        </script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151317528-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-151317528-1');
        </script>

        <!-- Yandex.Metrika counter -->
        <script type="text/javascript" >
            (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
                m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
            (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

            ym(56036059, "init", {
                clickmap:true,
                trackLinks:true,
                accurateTrackBounce:true,
                webvisor:true
            });
        </script>
        <noscript><div><img src="https://mc.yandex.ru/watch/56036059" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
        <!-- /Yandex.Metrika counter -->

    </head>
    <body>
    <?= View::factory('blocks/banners/wide', array('location' => 'head')) ?>
    <header class="header">
        <div class="logo">
            <a href="/"><img src="/img/logo-test.png"></a>
        </div>
        <div class="header-icons">
            <div class="search">
                <img src="/img/search.png">

                <form action="<?=URL::site(I18n::$lang.'/search')?>" method="get">
                    <input type="text" name="query">
                    <input type="submit">
                </form>
            </div>
         </div>
        <div class="burger js-burger">
            <span class="burger-line"></span>
        </div>
        <div class="wrap">
            <div class="header-icons">
                <div class="search">
                    <img src="/img/search.png">
            
                    <form action="<?=URL::site(I18n::$lang.'/search')?>" method="get">
                        <input type="text" name="query">
                        <input type="submit">
                    </form>
                </div>
            </div>
            <?=View::factory('blocks/menu/main_top')?>
        </div>
    </header>
    <?=$page->content()?>
    <?=View::factory('blocks/ads')?>
    <footer class="footer">
        <div class="wrap">
            <div class="logo">
                <a href="/"><img src="/img/logo-test.png"></a><br/>
                <?=date('Y')?> © nege.kz ақпараттық порталы
            </div>
            <nav class="bottom-menu">
                <a href="#" class="white">Қызмет көрсету</a><br/>
                <a href="#">RSS</a>
                <a href="#">Мобильдік нұсқа</a>
                <a href="#">Анықтама</a><br/><br/>
                <a href="#" class="white">Редакция</a><br/>
                <a href="#">Компания туралы</a> <a href="#">Менеджмент</a> <a href="#">Әріптестік</a>
            </nav>
            <nav class="bottom-right-menu">
                <a href="#" class="white">Шарттар</a> <a href="#" class="white">Саясат</a> <a href="#" class="white">Авторлық құқық</a>
                <div class="social">
                    <a href="#" class="fb"></a>
                    <a href="#" class="tw"></a>
                    <a href="#" class="tu"></a>
                    <a href="#" class="vk"></a>
                </div>
            </nav>
        </div>
    </footer>
    </body>
    </html>
<?php
if (Request::$current->query('profiler')){
    echo View::factory('profiler/stats');
}
?>