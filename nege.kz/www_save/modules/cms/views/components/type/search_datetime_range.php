<?
    $value1 = $value2 = null;
    if($value){
        list($value1,$value2) = explode('__',$value);
    }
?>
<div class="form-group <?= !$value ? 'is-empty' : '' ?> <?= $error ? 'has-error' : '' ?>">

        <input type="hidden" name="<?=$field?>" id="<?=$field?>" value="<?=$value?>">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= Form::label($field."_from", __($label." от"), array('class' => 'control-label')) ?>
            <div class="input-group date">
                <?php
                $attr = Arr::get($params, 'attr', array());
                $attr = $attr + array(
                        'id' => $field."_from",
                        'class' => 'form-control',
                    );
                ?>
                <?= Form::input(null, $value1?Date::formatted_time($value1, 'd-m-Y'):null, $attr) ?>
                <span class="help-block"><?= $error ?></span>
        <span class="input-group-btn">
            <a class="btn btn-fab btn-fab-mini show-datepicker datepickerbutton">
                <i class="material-icons">insert_invitation</i>
            </a>
        </span>
                <span class="material-input"></span>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <?= Form::label($field."_to", __($label." до"), array('class' => 'control-label')) ?>
            <div class="input-group date">
                <?php
                $attr = Arr::get($params, 'attr', array());
                $attr = $attr + array(
                        'id' => $field."_to",
                        'class' => 'form-control',
                    );
                ?>
                <?= Form::input(null, $value2?Date::formatted_time($value2, 'd-m-Y'):null, $attr) ?>
                <span class="help-block"><?= $error ?></span>
        <span class="input-group-btn">
            <a class="btn btn-fab btn-fab-mini show-datepicker datepickerbutton">
                <i class="material-icons">insert_invitation</i>
            </a>
        </span>
                <span class="material-input"></span>
            </div>
        </div>


</div>


<script type="text/javascript">
    $(function () {
        var from_value = <?=$value1?$value1:'null'?>;
        var to_value = <?=$value2?$value2:'null'?>;
        var datePickerElement = $('#<?=$field."_from"?>').parent();
        var datepicker = $(datePickerElement).datetimepicker({
            locale: 'ru',
            allowInputToggle: true,
            format: 'DD-MM-YYYY',
            widgetPositioning: {
                horizontal: 'right',
                vertical: 'auto'
            }
        });

        datepicker.on('dp.change', function (e) {
            $('#<?=$field."_from"?>').change();
            from_value = $('#<?=$field."_from"?>').val();
//            datepicker2.minDate(e.date);
            set_date(from_value,to_value);
        });

        var datePickerElement2 = $('#<?=$field."_to"?>').parent();
        var datepicker2 = $(datePickerElement2).datetimepicker({
            locale: 'ru',
            allowInputToggle: true,
            format: 'DD-MM-YYYY',
            widgetPositioning: {
                horizontal: 'right',
                vertical: 'auto'
            }
        });

        datepicker2.on('dp.change', function (e) {
            $('#<?=$field."_to"?>').change();
            to_value = $('#<?=$field."_to"?>').val();
//            datepicker.maxDate(e.date);
            set_date(from_value,to_value);
        });

        from_value = $('#<?=$field."_from"?>').val();
        to_value = $('#<?=$field."_to"?>').val();
//        set_date(from_value,to_value);

        function set_date(from_value,to_value){
            $("#<?=$field?>").val(from_value+'__'+to_value);
        }
    });
</script>