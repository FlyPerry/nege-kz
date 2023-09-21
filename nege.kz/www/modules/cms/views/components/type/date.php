<div class="form-group <?= !$value ? 'is-empty' : '' ?> <?= $error ? 'has-error' : '' ?>">
    <?= Form::label($field, __($label), array('class' => 'control-label')) ?>
    <div class="input-group date">
        <?php
        $attr = Arr::get($params, 'attr', array());
        $attr = $attr + array(
                'id' => $field,
                'class' => 'form-control',
                'ng-model' => "model.{$field}",
                Arr::get($params, 'ng'),
                'value-init'
            );
        ?>
        <?= Form::input("model[$field]", Date::formatted_time($value, 'd-m-Y'), $attr) ?>
        <span class="help-block"><?= $error ?></span>
        <span class="input-group-btn">
            <a class="btn btn-fab btn-fab-mini show-datepicker datepickerbutton">
                <i class="material-icons">insert_invitation</i>
            </a>
        </span>
        <span class="material-input"></span>
    </div>
</div>


<script type="text/javascript">
    $(function () {
        var datePickerElement = $('#<?=$field?>').parent();
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
            $('#<?=$field?>').change()
        });
    });
</script>
