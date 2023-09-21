<table class="table table-hover table-striped">
    <thead>
    <tr>
        <?foreach ($head as $td): ?>
        <th><?=__($td)?></th>
        <? endforeach;?>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?foreach ($model as $row): ?>
        <?php
            if (!($row instanceof IC_Editable))
            {
                continue;
            }
        ?>
    <tr>
        <?foreach ($head as $field => $label): ?>
        <td><?=$row->get_field($field)?></td>
        <?endforeach;?>
        <td>
            <?if($row->permission('edit',$user) AND $row->edit_url()!==FALSE):?>
                <a href="<?=$row->edit_url()?>" class="btn" title="<?=__('Редактировать')?>
                "><i class="icon-pencil"></i></a>
            <?endif?>
            <?if($row->permission('view',$user) AND $row->view_url()!==FALSE):?>
                <a href="<?=$row->view_url()?>" class="btn" title="<?=__('Просмотр')?>
                "><i class="icon-search"></i></a>
            <?endif?>
            <?if($row->permission('delete',$user) AND $row->delete_url()!==FALSE):?>
                <a href="<?=$row->delete_url()?>" class="btn" title="<?=__('Удалить')?>
                "><i class="icon-remove"></i></a>
            <?endif?>

        </td>
    </tr>
    <? endforeach;?>
    </tbody>
</table>