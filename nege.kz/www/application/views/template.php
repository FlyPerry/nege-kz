    <!DOCTYPE html>
    <html lang="kk">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, maximum-scale=1.0, minimum-scale=1.0">
        <meta name="yandex-verification" content="3e9868ee6b9cb64c" />
        <meta name="yandex-verification" content="bd103513c7062b05" />
        <!--[if lt IE 9]>
        <script rel="script" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script async rel="script" src="/js/all.min.js"></script>
        <?=$page->get_head(true)?> 
        

        <meta name="description" content="<?=$page->title()?> | NEGE Media - Ең ұшқыр электронды ақпарат құралы">  
         

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-151317528-1"></script>
        <script rel="script">
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);} 
            gtag('js', new Date());

            gtag('config', 'UA-151317528-1');
        </script>

<script type="application/ld+json">[{"@context" : "http://schema.org","@type" : "Organization","address" : {"@type" : "PostalAddress","addressLocality" : "г. Алматы","streetAddress" : "ул.Радлова, 65, офис 201, Бизнес центр «Сәлем»"},"name" : "Ең ұшқыр ақпарат құралы! Жаңа стильдегі медиа","description" : "Жаңа медиа. Ең ұшқыр электронды ақпарат құралы. Қазақ тіліндегі мақалалар, журналистік зерттеулер, сұхбаттар, видеолар. Жаңа стиль. Ең үздік журналистер командасы.","url" : "https://nege.kz/","telephone" : [" +77757468188", "+77772004483"],"email" : "info@nege.kz","logo" : "https://nege.kz/img/logo-test.png"},{"@context" : "http://schema.org","@type" : "Product","@id" : "https://nege.kz/","name" : "Ең ұшқыр ақпарат құралы! Жаңа стильдегі медиа","category" : [{"@type" : "PropertyValue","name" : "Бас тақырып"},{"@type" : "PropertyValue","name" : "Билік"},{"@type" : "PropertyValue","name" : "Қаржылық сараптама"},{"@type" : "PropertyValue","name" : "Экономика жаңалықтары"},{"@type" : "PropertyValue","name" : "Ел"},{"@type" : "PropertyValue","name" : "Мiнбер"},{"@type" : "PropertyValue","name" : "Мәдениет"},{"@type" : "PropertyValue","name" : "Әлем"},{"@type" : "PropertyValue","name" : "Аймақ"},{"@type" : "PropertyValue","name" : "Спорт"},{"@type" : "PropertyValue","name" : "Қызық видео"}]}]</script>
    </head>
	
    <body>
	 <!--<div class="banner"><a href="https://z.cdn.adpool.bet/go?z=1959181394"  target="_blank"><img src="/ban1.jpg"></a></div>
	<div class="full-screen" onclick="location.href='http://google.com';"><div><img src="ban2.jpg"></div></div>
	
    <!-- Yandex.Metrika counter -->
    <script rel="script">
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
    <noscript><div><img src="https://mc.yandex.ru/watch/56036059" style="position:absolute; left:-9999px;" alt="yandex" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <!-- Yandex.RTB R-A-512006-2 
    <div class="wrap mobile-banner">
        <div id="yandex_rtb_R-A-512006-2"></div>
    </div>
    <script type="text/javascript">
        (function(w, d, n, s, t) {
            w[n] = w[n] || [];
            w[n].push(function() {
                Ya.Context.AdvManager.render({
                    blockId: "R-A-512006-2",
                    renderTo: "yandex_rtb_R-A-512006-2",
                    async: true
                });
            });
            t = d.getElementsByTagName("script")[0];
            s = d.createElement("script");
            s.type = "text/javascript";
            s.src = "//an.yandex.ru/system/context.js";
            s.async = true;
            t.parentNode.insertBefore(s, t);
        })(this, this.document, "yandexContextAsyncCallbacks");
    </script>-->
   

        </div>
    <header class="header">
        <div class="logo">
            <a href="/"><img src="/img/logo-test.png" alt="NEGE"></a>
        </div>
        <div class="header-icons">
            <div class="search">
                <img src="/img/search.png" alt="search">

                <form action="<?=URL::site('search')?>" method="get">
                    <input type="text" name="query">
                    <input type="submit">
                </form>
            </div>
            <a href="<?=Helper::another_lang()?>"><?= $template_langs[I18n::$lang]?></a>
            <a href="<?=Helper::another_lang()?>"><img src="/img/reload.png" class="reload" alt="reload"></a>
         </div>
        <div class="burger js-burger">
            <span class="burger-line"></span>
        </div>
        <div class="wrap">
            <div class="header-icons">
                <div class="search">
                    <img src="/img/search.png" alt="search">
            
                    <form action="<?=URL::site('search')?>" method="get">
                        <input type="text" name="query">
                        <input type="submit">
                    </form>
                </div>
                <a href="<?=Helper::another_lang()?>"><?= $template_langs[I18n::$lang]?></a>
                <a href="<?=Helper::another_lang()?>"><img src="/img/reload.png" class="reload" alt="reload"></a>
            </div>
            <?=View::factory('blocks/menu/main_top')?>
        </div>
    </header>
    <?php
       
		 //$xml = @simplexml_load_file('https://nationalbank.kz/rss/rates_all.xml');          

                 $xml = false;
 ?>
    <div class="informer-b">
        <div class="wrap">
            <div class="informer-flex">
                
		<?php if($xml): ?>
                <div class="informer">
                    <?php foreach ($xml->xpath('//item') as $item): ?>
                        <?php if ( $item->title == 'USD' ): ?>
                            <span class="informer-item <?php echo strtolower($item->index) ?>">
                                &#36; <?php echo ''.$item->description.'' ?>
                            </span>
                        <?php endif;?>
                        <?php if ( $item->title == 'EUR' ): ?>
                            <span class="informer-item <?php echo strtolower($item->index) ?>">
                                &#8364; <?php echo ''.$item->description.'' ?>
                            </span>
                        <?php endif;?>
                        <?php if ( $item->title == 'RUB' ): ?>
                            <span class="informer-item <?php echo strtolower($item->index) ?>">
                                &#8381; <?php echo ''.$item->description.'' ?>
                            </span>
                        <?php endif;?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>


                <?php
                    $w = Weather::get();
                ?>
                <?php if($w) : ?>
                    <div class="weather">
                        <?= Date::textdate('now', 'd m') ?>, <?=$w['name']?>
                        <img src="/img/openweathermap-icons/<?=$w['weather'][0]['icon']?>.svg" class="weather" alt="weather"/>
                        <?=$w['main']['temp']?>&#8451;
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <?=$page->content()?>
    <footer class="footer">
        <div class="wrap">
            <div class="logo">
                <a href="<?=URL::site('/')?>"><img src="/img/logo-test.png" alt="NEGE"></a><br/>
                <?=date('Y')?> © nege.kz ақпараттық-сараптамалық порталы
            </div>
            <nav class="bottom-menu">
                <a href="/page/view/redaktsiya">Редакция</a>
                <a href="/page/view/kompaniya_turali">Компания туралы</a>
                <a href="/page/view/zharnama">Жарнама</a>
            </nav>
            <nav class="bottom-right-menu">
                <a href="/page/view/redaktsiyalik_sayasat" class="white">Редакциялық саясат</a>
                <a href="/page/view/avtorlik_kukik" class="white">Авторлық құқық</a>
                <div class="social">
                    <a rel="nofollow" href="https://www.facebook.com/nege.kz" target="_blank" rel="noreferrer noopener" class="fb"></a>
                    <a rel="nofollow" href="https://t.me/negemedia" target="_blank" rel="noreferrer noopener" class="tlgrm"></a>
                    <a rel="nofollow" href="https://twitter.com/negekz" target="_blank" rel="noreferrer noopener" class="tw"></a>
                    <a rel="nofollow" href="https://instagram.com/negekz" target="_blank" rel="noreferrer noopener" class="inst"></a>
                    <a rel="nofollow" href="https://www.youtube.com/channel/UCd1m6dcBATnt5foWRPUkH6g?view_as=subscriber" target="_blank" rel="noreferrer noopener" class="ytb"></a>
                </div>
                <div class="editor">Бас редактор - Ерiк Рахым</div>
            </nav>
        </div>
    </footer>

    <?php if (I18n::$lang == 'ru'): ?>
        <div class="popup jsPopup">
            <p>Перевод материалов сайта осуществляется онлайн-сервисом, не редактируется и служит для ознакомления аудитории с контентом сайта</p>
            <span class="jsPopupClose">Ok</span>
        </div>
    <?php endif;?>
    
    <div class="liveinternet">
        <!--LiveInternet counter-->
        <script rel="script">
            document.write('<a href="//www.liveinternet.ru/click" '+
                'target="_blank"><img src="//counter.yadro.ru/hit?t52.11;r'+
                escape(document.referrer)+((typeof(screen)=='undefined')?'':
                ';s'+screen.width+'*'+screen.height+'*'+(screen.colorDepth?
                    screen.colorDepth:screen.pixelDepth))+';u'+escape(document.URL)+
                ';h'+escape(document.title.substring(0,150))+';'+Math.random()+
                '" alt="" title="LiveInternet: показано число просмотров и'+
                ' посетителей за 24 часа" '+
                'border="0" width="88" height="31"><\/a>')
        </script>
        <!--/LiveInternet-->
    </div>
    </body>
    </html>
<?php
if (Request::$current->query('profiler')){
    echo View::factory('profiler/stats');
}
?>
