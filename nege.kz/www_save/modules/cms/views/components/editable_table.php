<table class="table table-hover table-striped">
    <thead>
    <tr>
        <?foreach ($head as $td): ?>
            <th><?=__($td)?></th>

        <? endforeach;?>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?foreach ($model as $row): ?>
        <?php
        if (!($row instanceof IC_Editable)) {
            continue;
        }
        ?>
        <tr>

            <?foreach ($head as $field => $label): ?>
                <?if($field=='title'):?>
                    <td><a href="<?=$row->edit_url()?>"><?=$row->get_field($field)?></a></td>
                    <?else:?>
                    <td><?=$row->get_field($field)?></td>
                    <?endif?>

            <? endforeach;?>
            <td>
                <?php
                /**
                 * @var $row ORM
                 **/
                $items = $row->actions($user);
                ?>
                <?if(count($items)>0): ?>
                    <div class="edit-item pull-right">
                        <?=actions($items)?>
                    </div>

                <?endif;?>

            </td>
        </tr>
    <? endforeach;?>
    </tbody>
</table>