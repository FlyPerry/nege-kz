<div class="control-group">
    <?=Form::label($field, __($label),array('class'=>'control-label'))?>
    <div class="controls">
        <?=Form::file('file')?>
        <span class="error help-inline"><?=__(Arr::get($errors, 'file'))?></span>
    </div>
</div>