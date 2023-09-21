<select-extended
    ng-model="model.<?= $field ?>"
    label="<?= __($label) ?>"
    error="<?= htmlentities($error) ?>"
    field="<?= $field ?>"
    val="<?= json_encode(array_keys($params['value'])) ?>"
    options="<?= htmlentities(json_encode($params['options'])) ?>"
    disabled="<?= Arr::get($params, 'disabled') ?>"
    >

</select-extended>