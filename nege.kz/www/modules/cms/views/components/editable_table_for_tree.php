<table class="table table-hover table-striped">
    <thead>
    <tr>
        <th class="span1">&nbsp;</th>
        <th class="span1"><input type="checkbox" class="check-all"></th>

        <th class="span1">&nbsp;</th>
        <?foreach ($head as $td): ?>
        <th><?=__($td)?></th>
        <? endforeach;?>

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
        <td class="span1"><a href="<?=$row->tree_url() ?>"><i class="icon-folder-close"></i></a></td>
        <td class="span1"><input type="checkbox" value="<?=$row->id?>" name="model[]"></td>
        <td class="span1">

            <div class="btn-group">
                <a class="btn-small dropdown-toggle" data-toggle="dropdown" href="#" title="<?=__('11111Действия')?>">
                    <i class="icon-pencil"></i>

                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <?php
                    dropdown($row->actions($user));
                    ?>
                </ul>
            </div>

        </td>
        <?foreach ($head as $field => $label): ?>
        <td><?=$row->get_field($field)?></td>
        <? endforeach;?>

    </tr>
        <? endforeach;?>
    </tbody>
</table>