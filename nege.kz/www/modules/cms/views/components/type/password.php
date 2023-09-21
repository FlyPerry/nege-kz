<div class="form-group label-floating <?= $error ? 'has-error' : '' ?>">
    <?= Form::label($field, __($label), array('class' => 'control-label ')) ?>
    <?php
    $attr = Arr::get($params, 'attr', array());
    $attr = array_merge($attr, array(
        'id' => $field,
        'class' => 'form-control',
        'ng-model' => "model.{$field}",
        'value-init',
        Arr::get($params, 'ng')
    ));
    ?>
    <?= Form::password("model[{$field}]", NULL, $attr) ?>
    <span class="help-block"><?= $error ?></span>
    <span class="material-input"></span>
</div>