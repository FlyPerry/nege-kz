<h3>Панель управления</h3>
<table class="table">
   <thead>
    <tr>
        <th>Название модуля</th>
        <th>Версия</th>
        <th>Зависимости</th>
        <th>&nbsp;</th>
    </tr>
   </thead>
<?php
    foreach ($modules as $module){
        ?>
    <tr>
        <td><?= $module['title'] ?></td>
        <td><?= $module['version'] ?></td>
        <td><?php
            foreach ($module['dependencies'] as $m=>$v){
                echo "$m => $v<br>";
            }
        ?></td>
        <td>
            <?php
            $is_ok=$module['errors'][0];
            $errors=$module['errors'][1];
            if (!$is_ok){
                foreach ($errors as $err){
                    echo "<p class='text-error'>";
                    if ($err['found']==null){
                        echo __("Модуль :module не найден",array(':module'=>$err['module']));
                    } else {
                        echo __("Нужен модуль ':module' версии :version, найдена версия :found",
                        array(
                            ':module'=>$err['module'],
                            ':version'=>$err['version'],
                            ':found'=>$err['found'],
                        ));
                    }
                    echo "</p>";

                }
            }
            ?>
        </td>
    </tr>
        <?
    }
?>
</table>
<div>
    <div class="well">
        Текущая версия проекта: <span class="badge"><?=Arr::get($revision, 0)?></span> <a class="btn btn-primary pull-right" href="<?=URL::site("admin/panel/update_code")?>">Проверить обновления</a>

    </div>
    <?foreach($update_log as $row):?>
    <p><?=$row?></p>
    <?endforeach?>
</div>