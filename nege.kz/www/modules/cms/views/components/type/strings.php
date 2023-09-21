<div class="form-group label-floating <?= $value===null||$value===false|| !isset($value) ? 'is-empty' : '' ?> <?= $error ? 'has-error' : '' ?>">
    <?= Form::label($field, __($label), array('class' => 'control-label')) ?>
    <?php
    $attr = Arr::get($params, 'attr', array());
    $attr = $attr + array(
            'id' => $field,
            'class' => 'form-control',
            'ng-model' => "model.{$field}",
            'value-init',
            Arr::get($params, 'ng')
        );
    ?>
    <?= Form::input("model[$field]", $value, $attr) ?>
    <span class="help-block"><?= $error ?></span>
    <span class="material-input"></span>
</div>