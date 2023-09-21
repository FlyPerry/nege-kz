<!DOCTYPE html>
<html>
<head>
    <script type="text/javascript">
        BASE_URL = "<?=Url::base()?>";
    </script>
    <?=$page->get_head()?>
</head>
<body>
<div class="row-fluid">
    <div class="navbar">
        <div class="navbar-inner">
            <?php if ($user && $user->loaded()): ?>
                <a class="brand" href="<?=$user->edit_url()?>"><?=$user->username?></a>
            <?php  endif;?>
            <ul class="nav">
                <li>
                    <a href="<?=Url::site()?>">
                        На сайт
                    </a>
                </li>
                <?php
                if (class_exists('Model_Notification')){
                    ?>
                    <li <?=Request::$current->controller() == 'notification' ? 'class="active"' : ''?>>
                        <a href="<?=Url::site('admin/notification/list')?>">
                            Уведомления
                            <?php
                            $notify = Orm::factory('admin_notification')->count_all();
                            if ($notify > 0) {
                                echo '<span class="badge badge-success">'.$notify.'</span>';
                            }
                            ?>
                        </a>
                    </li>
                <?php
                }
                ?>
                <!--                    <li><a href="#">Link</a></li>-->
            </ul>
        </div>
    </div>
</div>
<div class="row-fluid">
    <div class="span12">
        <ul class="breadcrumb">
            <?php
            $last = array_pop($crumbs);
            ?>
            <?php foreach ($crumbs as $el): ?>
                <li><a href="<?=Url::site($el['uri'])?>"><?=$el['title']?></a> <span class="divider">/</span></li>
            <?php  endforeach;?>
            <li class="active"><?=$last['title']?></li>
        </ul>
    </div>
</div>
<div class="row-fluid">
    <div class="span2">
        <?=View::factory("components/menu_admin", array("items" => $menu))?>
    </div>
    <div class="span10">
        <?php
        foreach ($page->read_messages(Cms_Page::PAGE_MESSAGE_NOTICE) as $msg) {
            ?>
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?=$msg?>
            </div>
        <?php
        }
        ?>
        <?php
        foreach ($page->read_messages(Cms_Page::PAGE_MESSAGE_WARNING) as $msg) {
            ?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?=$msg?>
            </div>
        <?php
        }
        ?>
        <?php
        foreach ($page->read_messages(Cms_Page::PAGE_MESSAGE_ERROR) as $msg) {
            ?>
            <div class="alert alert-error">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <?=$msg?>
            </div>
        <?php
        }
        ?>
        <?=$page->content()?>
    </div>
</div>

<!--<div class="navbar" style="margin: 90px 0 0 0; line-height: 42px;">-->
<!--            <div class="navbar-inner">Разработано в <a href="http://kaznetmedia.kz/">kaznetmedia</a></div>-->
<!--</div>-->

<!-- Modal -->
<div id="modalSelect" class="modal hide fade modal-select" tabindex="-1" role="dialog" aria-labelledby="modalSelect" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Выбирете элемент из списка</h3>
    </div>
    <div class="modal-body">

    </div>
    <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Отмена</button>
    </div>
</div>

<!-- Modal -->
<div id="storage"
     class="modal hide fade"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel"
     aria-hidden="true"
     style="width: 900px;margin-left: -450px;">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Файловый менеджер</h3>
    </div>
    <div class="modal-body">
        <iframe src="<?=Url::site('ru/storage/index')?>" frameborder="0" width="100%" height="390" id="fileBrowser">

        </iframe>
    </div>
    <!--    <div class="modal-footer">-->
    <!--        <button class="btn" data-dismiss="modal" aria-hidden="true"></button>-->
    <!--       -->
    <!--    </div>-->
</div>
<script src="http://api-maps.yandex.ru/2.0-stable/?load=package.standard&lang=ru-RU" type="text/javascript"></script>
</body>
</html>