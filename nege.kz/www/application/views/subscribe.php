<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
</head>
<body style="background: #f7f7f7; font-family: Arial;">
<center>
    <table style="background: #fff; width: 600px;" cellspacing="0" cellpadding="0">
        <tr>
            <td style="background: #db1f1f; padding: 0 0 10px 20px;">
                <a href="<?= URL::base('http') ?>" target="_blank"><img src="<?= URL::site('img/logo.png', 'http') ?>"></a>
            </td>
        </tr>
        <tr>
            <td style="padding: 20px; font-size: 15px;">
                <p>Здравствуйте, <?= $subscribe->username ?>!<br/>Подборка последних новостей для Вас.</p>
                <?php  foreach ($news as $item): ?>
                    <p><img src="<?= $item->file_s->html_img_url(561, 316, 'http') ?>"></p>
                    <p>
                        <a href="<?= $item->view_url(false, 'http') ?>"
                           style="font-weight: bold; color: #000; text-decoration: none;" target="_blank">
                            <?= $item->title ?>
                        </a>
                    </p>
                    <p><?= $item->description ?></p>
                    <p>&nbsp;</p>
                <?php  endforeach ?>
            </td>
        </tr>
    </table>
    <table style="background: #2f343c; width: 600px; margin-top: 20px; color: #fff;" cellspacing="0" cellpadding="0">
        <tr>
            <td style="padding: 20px; font-size: 15px; line-height: 180%;">
                С уважением, команда <a href="<?=URL::base('http')?>" target="_blank" style="color: #7c818a; text-decoration: none;">Newsfeed</a><br/>
                <a href="#" style="color: #7c818a; text-decoration: none;" target="_blank">Отписаться от рассылки</a><br/>
                <a href="<?=URL::base('http')?>" style="color: #7c818a; text-decoration: none;" target="_blank">HTML версия</a><br/>
                <a href="#" style="color: #7c818a; text-decoration: none;" target="_blank">Настройки уведомлений</a>

                <div align="right" style="padding-top: 20px;">
                    Подпишитесь на нас
                    <a href="#" target="_blank">
                        <img src="<?= URL::site('img/soc-ic_03.png', 'http') ?>"
                             onmouseover="this.src='<?= URL::site('img/soc-ic_15.png', 'http') ?>'"
                             onmouseout="this.src='<?= URL::site('img/soc-ic_03.png', 'http') ?>'"
                             style="vertical-align: middle; margin-left: 10px;">
                    </a>
                    <a href="#" target="_blank">
                        <img src="<?= URL::site('img/soc-ic_05.png', 'http') ?>"
                             onmouseover="this.src='<?= URL::site('img/soc-ic_16.png', 'http') ?>'"
                             onmouseout="this.src='<?= URL::site('img/soc-ic_05.png', 'http') ?>'" style="vertical-align: middle;">
                    </a>
                    <a href="#" target="_blank">
                        <img src="<?= URL::site('img/soc-ic_07.png', 'http') ?>"
                             onmouseover="this.src='<?= URL::site('img/soc-ic_17.png', 'http') ?>'"
                             onmouseout="this.src='<?= URL::site('img/soc-ic_07.png', 'http') ?>'" style="vertical-align: middle;">
                    </a>
                    <a href="#" target="_blank">
                        <img src="<?= URL::site('img/soc-ic_09.png', 'http') ?>"
                             onmouseover="this.src='<?= URL::site('img/soc-ic_18.png', 'http') ?>'"
                             onmouseout="this.src='<?= URL::site('img/soc-ic_09.png', 'http') ?>'" style="vertical-align: middle;">
                    </a>
                </div>
            </td>
        </tr>
    </table>
</center>
</body>
</html>