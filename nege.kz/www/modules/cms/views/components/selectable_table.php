<table class="table table-striped table-hover ">
    <thead>
    <tr>
        <? foreach ($head as $td): ?>
            <th><?= __($td) ?></th>
        <? endforeach; ?>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <? foreach ($model as $row): ?>
        <tr>
            <? foreach ($head as $field => $label): ?>
                <td><?= $row->get_field($field) ?></td>
            <? endforeach; ?>
            <td>
                <a href="#" data-id="<?=$row->id ?>" data-title="<?=$row->title() ?>" class="select">Выбрать</a>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>