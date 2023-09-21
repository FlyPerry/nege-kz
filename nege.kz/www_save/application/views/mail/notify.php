<table>
    <caption>
        Топ самых читаемых новостей за <?= $date ?>
    </caption>
    <thead>
    <tr>
        <td>Просмотров</td>
        <td>Название новости</td>
        <td>Автор</td>
    </tr>
    </thead>
    <tbody>

    <?php foreach ($items as $index => $item) : ?>
        <tr>
            <td><?= $item->views ?></td>
            <td><?= $item->title ?></td>
            <td><?= $item->title_ru ?></td>
        </tr>
    <?php endforeach ?>

    </tbody>
</table>
