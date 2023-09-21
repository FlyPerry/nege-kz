<div class="row">
    <form class="form-inline" method="get"
          action="<?= URL::site('admin/icategory/top_read') ?>">
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
                                        <?php  foreach (ORM::factory('Author')->order_by('title_ru', 'ASC')->find_all() as $row): ?>
                                            <option
                                                value="<?= $row->id ?>" <?= Request::$current->query('author_id') == $row->id ? "SELECTED" : '' ?>><?= $row->title ?></option>
                                        <?php  endforeach ?>
                                    </select>
                                </td>
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

                        </table>
                        <br/>
                        <input type="submit"  value="Найти" class="btn i_btn">
                        <a href="<?= URL::site('admin/icategory/top_read') ?>" class="btn">Сбросить</a>
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


<?php if (count($news)) : ?>
    <table border="1" cellpadding="8" style="table-layout: fixed" width="100%">
        <caption></caption>
        <tr>
            <td width="8%">Дата</td>
            <td width="8%">Количество просмотров</td>
            <td>Название</td>
            <td>Ссылка</td>
            <td width="20%">Автор</td>
        </tr>
        <?php foreach ($news as $item) : ?>
            <tr>
                <td style="word-wrap: break-word;"><?=date('Y-m-d H:i', strtotime($item->date))?></td>
                <td style="word-wrap: break-word;"><?=$item->views?></td>
                <td style="word-wrap: break-word;"><?=$item->title?></td>
                <td style="word-wrap: break-word;"><a href="<?=URL::site($item->view_url(), 'http')?>"><?=URL::site($item->view_url(), 'http')?></a></td>
                <td style="word-wrap: break-word;"><?=$item->author->title_ru?></td>
            </tr>
        <?php endforeach ?>
    </table>

<?php endif ?>
