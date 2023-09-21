<div class="row">
    <form class="form-inline" method="get"
          action="<?= URL::site('admin/icategory/report/' . Request::$current->param('id')) ?>">
        <div class="accordion" id="search_category">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#search_category"
                       href="#collapseForm_category">
                        +Фильтр </a>
                </div>
                <div id="collapseForm_category" class="accordion-body  out in collapse" style="height: auto;">
                    <div class="accordion-inner">
                        <table class="table">
                            <tr>
                                <td>
                                    <label class="control-label" for="author">Автор</label>
                                    <select name="author_id" id="author">
                                        <option value="">Не выбран</option>
                                        <?php  foreach ($authors as $row): ?>
                                            <option
                                                value="<?= $row->id ?>" <?= Request::$current->query('author_id') == $row->id ? "SELECTED" : '' ?>><?= $row->title ?></option>
                                        <?php  endforeach ?>
                                    </select>
                                </td>
                                <td>
                                    <label for="inner_type">Внутренний тип материала</label>
                                    <select name="inner_type" id="inner_type">
                                        <option value="">Не выбран</option>
                                        <?php  foreach (Model_News::$inner_types as $k => $v): ?>
                                            <option
                                                value="<?= $k ?>" <?= Request::$current->query('inner_type') == $k ? 'SELECTED' : '' ?>><?= $v ?></option>
                                        <?php  endforeach ?>
                                    </select>
                                </td>
                                <td>
                                    <label for="category_id">Категория</label>
                                    <select name="category_id" id="category_id">
                                        <option value="">Не выбрана</option>
                                        <?php  foreach ($categories as $i => $row): ?>
                                            <option
                                                value="<?= $i ?>" <?= Request::$current->query('category_id') == $i ? "SELECTED" : '' ?>><?= $row ?></option>
                                        <?php  endforeach ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="control-label" for="lang">Язык</label>
                                    <select name="lang" id="lang">
                                        <option value="">Не выбран</option>
                                        <?php  foreach (array('ru', 'en', 'kz') as $row): ?>
                                            <option
                                                value="<?=$row ?>" <?= Request::$current->query('lang') == $row ? "SELECTED" : '' ?>><?= $row ?></option>
                                        <?php  endforeach ?>
                                    </select>
                                </td>
                                <td>
                                    <label for="icategory_id"> Внутренняя категория</label>
                                    <select name="icategory_id" id="icategory_id">
                                        <option value="">Не выбрана</option>
                                        <?php  foreach ($icategories as $row): ?>
                                            <option
                                                value="<?= $row->id ?>" <?= Request::$current->query('icategory_id') == $row->id ? "SELECTED" : '' ?>><?= $row->title ?></option>
                                        <?php  endforeach ?>
                                    </select>
                                </td>
                                <td>
                                    <label for="from">От</label>
                                    <div class="input-append date" style="width: 130px">
                                        <input name="from" id="from" type="text" data-format="yyyy-MM-dd" class="datepicker span8" value="<?=Request::$current->query('from')?Request::$current->query('from'): Date::formatted_time("now -1 month",'Y-m-d')?>"/>
                                        <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                    </div>
                                    <label for="to">До</label>
                                    <div class="input-append date" style="width: 130px">
                                        <input name="to" id="to" type="text" data-format="yyyy-MM-dd" class="datepicker span8" value="<?=Request::$current->query('to')?Request::$current->query('to'): Date::formatted_time("now",'Y-m-d')?>"/>
                                        <span class="add-on"><i data-time-icon="icon-time" data-date-icon="icon-calendar"></i></span>
                                    </div>
                                    <script type="text/javascript">
                                        $(function() {
                                            $(".datepicker").parent().datetimepicker({
                                                language: 'ru',
                                                'pickTime':false
                                            });
                                        });
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="infographics_check">Инфографика</label>
                                    <?=Form::checkbox('infographics', null, !!Request::$current->query('infographics'), array('id' => 'infographics_check'))?>
                                </td>
                                <td>
                                    <label for="interactive_check">Интерактив</label>
                                    <?=Form::checkbox('interactive', null, !!Request::$current->query('interactive'), array('id' => 'interactive_check'))?>
                                </td>
                                <td>
                                    <label for="interactive_check">Текст</label>
                                    <input type="text" name="text" value="<?=Request::$current->query('text')?>">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <label class="control-label" for="redactor_id">Пользователь</label>
                                    <select name="redactor_id" id="redactor_id">
                                        <option value="">Не выбран</option>
                                        <?php  foreach (ORM::factory('Role', array('name' => 'news_editor'))->users->order_by('firstname', 'asc')->find_all() as $row): ?>
                                            <option value="<?= $row->id ?>" <?= Request::$current->query('redactor_id') == $row->id ? "SELECTED" : '' ?>><?= $row->fullname() ?></option>
                                        <?php  endforeach ?>
                                    </select>
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <input type="submit"  value="Найти" class="btn i_btn">
                        <a href="<?= URL::site('admin/icategory/report') ?>" class="btn">Сбросить</a>
                    </div>
                </div>
            </div>
        </div>

        <?php if (count(Request::$current->query())) : ?>
            <a href="<?=URL::site(Request::$current->uri().'?'.http_build_query(Request::$current->query()+array('format' =>'excel')))?>" class="btn btn-success" target="blank">
                Скачать в Excel
            </a>
        <?php endif ?>
    </form>
</div>


<?php if ($data['author_name'] || $data['redactor_name']) : ?>
<table border="1" cellpadding="8">
    <caption><h4>Статистика автора</h4></caption>
        <?php if ($data['author_name']) : ?>
            <tr>
                <td>Автор</td>
                <td align="right"><?=$data['author_name']?></td>
            </tr>
        <?php endif ?>

        <?php if($data['redactor_name']) : ?>
            <tr>
                <td>Пользователь</td>
                <td align="right"><?=$data['redactor_name']?></td>
            </tr>
        <?php endif ?>
        <tr>
            <td>Период</td>
            <td align="right"><?=Request::$current->query('from')?> - <?=Request::$current->query('to')?></td>
        </tr>
        <tr>
            <td>Общее количество материалов</td>
            <td align="right"><?=Arr::get($data, 'author_posts_count')?></td>
        </tr>
        <tr>
            <td>Количество новостей</td>
            <td align="right"><?=Arr::get($data, 'news_count')?></td>
        </tr>

        <?php if (count($data['inner_types_posts_count'])) : ?>
            <?php foreach ( $data['inner_types_posts_count'] as $id=>$count) : ?>
                <tr>
                    <td><?=Arr::get(Model_News::$inner_types, $id)?></td>
                    <td align="right"><?=$count?></td>
                </tr>
            <?php endforeach?>
        <?php endif ?>
        <?php if (Request::$current->query('interactive')) : ?>
            <tr>
                <td>Интерактив</td>
                <td align="right"><?=Arr::get($data, 'interactive_count')?></td>
            </tr>
        <?php endif ?>
        <?php if (Request::$current->query('infographics')) : ?>
            <tr>
                <td>Инфографика</td>
                <td align="right"><?=Arr::get($data, 'infographics_count')?></td>
            </tr>
        <?php endif ?>
</table>
<?php endif ?>
<br>
<?php foreach(Arr::get($data, 'posts', array()) as $name => $report) : ?>
    <table border="1" cellpadding="8" width="100%" style="table-layout: fixed">
        <caption><h4><?=$name?> (<?=count($report)?>)</h4></caption>
        <tbody>
        <tr>
            <td width="7%" style="word-wrap: break-word">Дата</td>
            <td style="word-wrap: break-word">Заголовок</td>
            <td style="word-wrap: break-word">Ссылка</td>
            <td width="5%" style="word-wrap: break-word">Просмотров</td>
            <td width="10%" style="word-wrap: break-word">Тип информации</td>
            <td style="word-wrap: break-word">Примечание</td>
        </tr>
        <?php foreach($report as $row):?>
            <tr>
                <td><?=date('Y-m-d H:i', strtotime($row->date))?></td>
                <td style="word-wrap: break-word"><?=$row->title?></td>
                <td style="word-wrap: break-word"><a href="<?=$row->view_url()?>"><?=URL::site($row->view_url(),'http')?></a></td>
                <td><?=$row->views?></td>
                <td><?=$row->get_field('inner_type')?></td>
                <td><?=$getNotes($row)?></td>
            </tr>
        <?php endforeach?>
        </tbody>
    </table>
<?php endforeach ?>