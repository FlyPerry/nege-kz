<div class="control-group">
    <?php
    $value = Arr::get($params, 'value');
    if ($value):
        ?>
        <?= Form::label($field, __($label)  , array('class' => 'control-label')) ?>
        <div class="controls">
            <?=HTML::anchor($value, $value, array(
            'id' => $field,
            'class' => 'btn'
        ))?>
        </div>
        <?php
    endif;
    ?>
</div>