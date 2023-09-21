<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='/css/style.css' rel='stylesheet' type='text/css'>
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="/js/jquery.bxslider.min.js"></script>
    <script type="text/javascript" src="/js/jquery.jscrollpane.min.js"></script>
    <script type="text/javascript" src="/js/jquery.custom-scroll.js"></script>
    <script type="text/javascript" src="/js/underscore-min.js"></script>
    <script>
        $(function(){
            $('.slider4').bxSlider({
                slideWidth: 210,
                minSlides: 1,
                maxSlides: 4,
                moveSlides: 1,
                slideMargin: 72
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
    <script type="text/javascript">

    </script>
</head>
<body>
<header class="header">
    <div class="logo">
        <a href="/"><img src="/img/logo-test.png"></a>
    </div>
    <div class="header-icons">
        <div class="search">
            <img src="/img/search.png">

            <form action="<?=URL::site('search')?>" method="get">
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

                <form action="<?=URL::site('search')?>" method="get">
                    <input type="text" name="query">
                    <input type="submit">
                </form>
            </div>
        </div>
        <?=View::factory('blocks/menu/main_top')?>
    </div>
</header>
<section class="error-page">
    <div class="wrap">
        <h1>404-қате</h1><br>
<p>Құрметті сайт қонақтары!</p>
<p>Сіз сұраған бет жоқ немесе қате орын алды.</p>
<p>Егер сіз көрсетілген мекен-жайдың дұрыс екеніне сенімді болсаңыз, онда бұл бет серверде жоқ немесе оның атауы өзгертілген.</p>
<p>Келесі әрекеттерді орындап көріңіз:</p><ol>
<li><a href="/">Cайттың басты парағын</a> ашып, өзіңізге қажетті парақты табуға тырысыңыз.</li>
<li>Алдыңғы параққа оралу үшін браузердің «Кері» батырмасын басыңыз.      </li>  <ol>    
    </div>
</section>
<footer class="footer">
    <div class="wrap">
        <div class="logo">
            <a href="/"><img src="/img/logo-test.png"></a><br/>
            <?=date('Y')?> © nege.kz ақпараттық порталы
        </div>
        <nav class="bottom-menu">
            <a href="/page/view/redaktsiya">Редакция</a>
            <a href="/page/view/kompaniya_turali">Компания туралы</a>
            <a href="#">Жарнама</a>
        </nav>
        <nav class="bottom-right-menu">
            <a href="/page/view/redaktsiyalik_sayasat" class="white">Редакциялық саясат</a>
            <a href="/page/view/avtorlik_kukik" class="white">Авторлық құқық</a>
            <div class="social">
                <a href="https://www.facebook.com/nege.kz" target="_blank" rel="noreferrer noopener" class="fb"></a>
                <a href="https://t.me/negemedia" target="_blank" rel="noreferrer noopener" class="tlgrm"></a>
                <a href="https://twitter.com/negekz" target="_blank" rel="noreferrer noopener" class="tw"></a>
                <a href="https://instagram.com/negekz" target="_blank" rel="noreferrer noopener" class="inst"></a>
                <a href="https://www.youtube.com/channel/UCd1m6dcBATnt5foWRPUkH6g?view_as=subscriber" target="_blank" rel="noreferrer noopener" class="ytb"></a>
            </div>
            <div class="editor">Бас редактор - Ерiк Рахым</div>
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