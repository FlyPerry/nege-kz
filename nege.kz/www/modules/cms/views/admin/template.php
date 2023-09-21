<!doctype html>
<html><head>
    <link rel="shortcut icon" href="/img/favicon.png">
    <script type="text/javascript">
        BASE_URL = "<?=Url::base()?>";
    </script>
    <?=$page->get_head()?>

</head><body ng-app="admin">
<div id="wrapper">

    <div class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?=URL::site('controlpanel')?>">
                    <div class="logo">
                        <img src="<?=URL::site('img/logo.png')?>">
                    </div>
                </a>

                <a class="navbar-brand" href="<?=$user->edit_url()?>"><?=$user->username?></a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?=Url::site()?>">
                        На сайт
                    </a>
                </li>
            </ul>
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse panel" id="side-menu-container">

                    <?=View::factory("components/menu_admin", array("items" => $menu,'first'=>true))?>
                    <script>
                        $(function(){
                            $('#side-menu-container').affix({
                                offset: {
                                    top: 1,
                                    bottom: function () {
                                        return (this.bottom = $('.footer').outerHeight(true))
                                    }
                                }
                            })
                        });
                    </script>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
                <!-- /.navbar-static-side -->
        </div>

    </div>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <?php
                foreach ($page->read_messages(Cms_Page::PAGE_MESSAGE_NOTICE) as $msg) {
                    ?>
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <?=$msg?>
                    </div>
                    <?
                }
                ?>
                <?php
                foreach ($page->read_messages(Cms_Page::PAGE_MESSAGE_WARNING) as $msg) {
                    ?>
                    <div class="alert alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <?=$msg?>
                    </div>
                    <?
                }
                ?>
                <?php
                foreach ($page->read_messages(Cms_Page::PAGE_MESSAGE_ERROR) as $msg) {
                    ?>
                    <div class="alert alert-danger alert-warning alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <?=$msg?>
                    </div>
                    <?
                }
                ?>

            </div>
        </div>

        <?=$page->content()?>
    </div>
</div>
<!--
<div class="row">
    <div class="navbar navbar-default">
        <div class="container"><div class="navbar-header"><a class="navbar-brand" href="<?=$user->edit_url()?>"><?=$user->username?></a></div>
            <?if ($user && $user->loaded()): ?>

            <? endif;?>
            <ul class="nav navbar-nav">
                <li>
                    <a href="<?//=Url::site()?>">
                        На сайт
                    </a>
                </li>
                <?php
                //if (class_exists('Model_Notification')){
                    ?>
                <li <?//=Request::$current->controller() == 'notification' ? 'class="active"' : ''?>>
                        <a href="<?//=Url::site('admin/notification/list')?>">
    Уведомления
                            <?php
                            //$notify = Orm::factory('admin_notification')->count_all();
                            //if ($notify > 0) {
    //echo '<span class="badge badge-success">'.$notify.'</span>';
//}
                            ?>
                        </a>
                    </li>
                <?
                //}
                ?>
            </ul>
        </div>
    </div>
</div>
-->
<script src="//api-maps.yandex.ru/2.0-stable/?load=package.standard&amp;lang=ru-RU" type="text/javascript"></script>

</body></html>